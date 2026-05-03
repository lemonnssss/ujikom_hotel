<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\RestaurantOrder;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function __construct()
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Generate Snap Token via AJAX
     */
    public function getSnapToken(Request $request)
    {
        $request->validate([
            'type' => 'required|in:booking,restaurant',
            'id'   => 'required|integer',
        ]);

        $type = $request->type;
        $id = $request->id;
        $totalPrice = 0;
        $itemDetails = [];
        $customerDetails = [];

        if ($type === 'booking') {
            $booking = Booking::with(['rooms.roomType', 'guest', 'restaurantOrder.details.menu'])->findOrFail($id);
            
            $roomPrice = $booking->total_price;
            $totalPrice = $roomPrice;
            
            $itemDetails[] = [
                'id' => 'ROOM-' . ($booking->rooms->first()->id ?? $booking->id),
                'price' => (int) $roomPrice,
                'quantity' => 1,
                'name' => substr(($booking->room_qty . 'x ' . ($booking->rooms->first()->roomType->name ?? 'Kamar Hotel')), 0, 50),
            ];

            if ($booking->restaurantOrder) {
                $restTotal = (int) $booking->restaurantOrder->total_price;
                $totalPrice += $restTotal;
                $itemDetails[] = [
                    'id' => 'REST-' . $booking->restaurantOrder->id,
                    'price' => $restTotal,
                    'quantity' => 1,
                    'name' => substr('Paket Restoran', 0, 50),
                ];
            }

            $customerDetails = [
                'first_name' => $booking->guest->name ?? 'Guest',
                'email' => $booking->guest->email ?? '',
                'phone' => $booking->guest->phone ?? '',
            ];

        } elseif ($type === 'restaurant') {
            $order = RestaurantOrder::with(['details.menu', 'guest'])->findOrFail($id);
            $totalPrice = (int) $order->total_price;

            if ($order->details && $order->details->count() > 0) {
                foreach ($order->details as $detail) {
                    $itemDetails[] = [
                        'id' => 'MENU-' . $detail->restaurant_menu_id,
                        'price' => (int) $detail->price,
                        'quantity' => (int) $detail->quantity,
                        'name' => substr($detail->menu->name ?? 'Menu Item', 0, 50),
                    ];
                }
            } else {
                $itemDetails[] = [
                    'id' => 'RESTORDER-' . $order->id,
                    'price' => $totalPrice,
                    'quantity' => 1,
                    'name' => 'Pesanan Restoran',
                ];
            }

            $guest = $order->guest;
            $customerDetails = [
                'first_name' => $guest->name ?? 'Guest',
                'email' => $guest->email ?? '',
                'phone' => $guest->phone ?? '',
            ];
        }

        $orderId = strtoupper($type) . '-' . $id . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $totalPrice,
            ],
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Simpan / update payment record dengan snap token
            $paymentData = [
                'amount' => $totalPrice,
                'payment_method' => null,
                'payment_status' => 'pending',
                'snap_token' => $snapToken,
                'midtrans_order_id' => $orderId,
            ];

            if ($type === 'booking') {
                $paymentData['booking_id'] = $id;
                if (isset($booking->restaurantOrder)) {
                    $paymentData['restaurant_order_id'] = $booking->restaurantOrder->id;
                }
            } else {
                $paymentData['restaurant_order_id'] = $id;
            }

            // Cek apakah sudah ada payment pending untuk order ini
            $existingPayment = Payment::where(function ($q) use ($type, $id) {
                if ($type === 'booking') {
                    $q->where('booking_id', $id);
                } else {
                    $q->where('restaurant_order_id', $id);
                }
            })->where('payment_status', 'pending')->first();

            if ($existingPayment) {
                $existingPayment->update([
                    'snap_token' => $snapToken,
                    'midtrans_order_id' => $orderId,
                    'amount' => $totalPrice,
                ]);
            } else {
                Payment::create($paymentData);
            }

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
            ]);

        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat token pembayaran: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle Midtrans webhook notification
     */
    public function handleNotification(Request $request)
    {
        try {
            $notification = new \Midtrans\Notification();

            $transactionStatus = $notification->transaction_status;
            $orderId = $notification->order_id;
            $paymentType = $notification->payment_type;
            $fraudStatus = $notification->fraud_status ?? null;
            $transactionId = $notification->transaction_id;

            Log::info('Midtrans Notification', [
                'order_id' => $orderId,
                'status' => $transactionStatus,
                'payment_type' => $paymentType,
            ]);

            $payment = Payment::where('midtrans_order_id', $orderId)->first();

            if (!$payment) {
                Log::warning('Payment not found for order: ' . $orderId);
                return response()->json(['message' => 'Payment not found'], 404);
            }

            $payment->midtrans_transaction_id = $transactionId;
            $payment->payment_method = $paymentType;

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $payment->payment_status = 'paid';
                    $this->confirmOrder($payment);
                } else {
                    $payment->payment_status = 'failed';
                }
            } elseif ($transactionStatus == 'settlement') {
                $payment->payment_status = 'paid';
                $this->confirmOrder($payment);
            } elseif ($transactionStatus == 'pending') {
                $payment->payment_status = 'pending';
            } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
                $payment->payment_status = 'failed';
                $this->cancelOrder($payment);
            }

            $payment->save();

            return response()->json(['message' => 'OK']);

        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error processing notification'], 500);
        }
    }

    /**
     * Confirm booking/order after successful payment
     */
    private function confirmOrder(Payment $payment)
    {
        if ($payment->booking_id) {
            $booking = Booking::find($payment->booking_id);
            if ($booking) {
                $booking->update(['status' => 'confirmed']);
            }
        }

        if ($payment->restaurant_order_id) {
            $order = RestaurantOrder::find($payment->restaurant_order_id);
            if ($order) {
                $order->update(['status' => 'paid']);
            }
        }
    }

    /**
     * Cancel booking/order on failed/expired payment
     */
    private function cancelOrder(Payment $payment)
    {
        if ($payment->booking_id) {
            $booking = Booking::find($payment->booking_id);
            if ($booking && $booking->status === 'pending') {
                $booking->update(['status' => 'cancelled']);
            }
        }

        if ($payment->restaurant_order_id) {
            $order = RestaurantOrder::find($payment->restaurant_order_id);
            if ($order && $order->status === 'ordered') {
                $order->update(['status' => 'cancelled']);
            }
        }
    }

    /**
     * Payment finish redirect page
     */
    public function paymentFinish(Request $request)
    {
        $orderId = $request->query('order_id');
        $statusCode = $request->query('status_code');
        $transactionStatus = $request->query('transaction_status');

        $status = 'pending';
        $message = 'Pembayaran sedang diproses.';

        // Fallback untuk Localhost (karena localhost tidak bisa terima Webhook otomatis)
        // Kita cek status langsung ke server Midtrans
        try {
            if ($orderId) {
                // Konfigurasi Midtrans sudah diset di constructor
                $statusResponse = \Midtrans\Transaction::status($orderId);
                
                $realStatus = $statusResponse->transaction_status;
                $fraudStatus = $statusResponse->fraud_status ?? null;
                
                $payment = Payment::where('midtrans_order_id', $orderId)->first();
                
                if ($payment && $payment->payment_status === 'pending') {
                    $payment->payment_method = $statusResponse->payment_type ?? null;
                    $payment->midtrans_transaction_id = $statusResponse->transaction_id ?? null;
                    
                    if ($realStatus == 'capture' || $realStatus == 'settlement') {
                        if ($fraudStatus == 'challenge') {
                            $payment->payment_status = 'pending';
                        } else {
                            $payment->payment_status = 'paid';
                            $this->confirmOrder($payment);
                        }
                    } elseif (in_array($realStatus, ['deny', 'cancel', 'expire'])) {
                        $payment->payment_status = 'failed';
                        $this->cancelOrder($payment);
                    }
                    $payment->save();
                }

                // Gunakan realStatus untuk visual UI
                $transactionStatus = $realStatus;
            }
        } catch (\Exception $e) {
            Log::warning('Midtrans Check Status Error on Finish Page: ' . $e->getMessage());
        }

        if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
            $status = 'success';
            $message = 'Pembayaran berhasil! Terima kasih atas pesanan Anda.';
        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
            $status = 'failed';
            $message = 'Pembayaran gagal atau dibatalkan.';
        }

        return view('payment-finish', compact('status', 'message', 'orderId'));
    }
}
