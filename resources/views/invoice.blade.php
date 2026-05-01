<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $booking->id }} - Hotelku</title>
    <style>
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 13px; 
            color: #333; 
            margin: 0;
            padding: 20px;
        }
        .header { 
            margin-bottom: 30px; 
            border-bottom: 2px solid #0a1628; 
            padding-bottom: 15px; 
        }
        .header-table {
            width: 100%;
        }
        .header-table td {
            vertical-align: middle;
        }
        .logo { 
            font-size: 32px; 
            font-weight: bold; 
            color: #0a1628; 
            margin: 0;
        }
        .logo span { 
            color: #c9a84c; 
        }
        .company-info {
            text-align: right;
            font-size: 12px;
            color: #666;
            line-height: 1.4;
        }
        .invoice-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #0a1628;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .info-table { 
            width: 100%; 
            margin-bottom: 30px; 
        }
        .info-table td { 
            padding: 5px 0; 
            vertical-align: top; 
        }
        .label {
            font-weight: bold;
            color: #555;
            width: 120px;
            display: inline-block;
        }
        .items-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 30px; 
        }
        .items-table th, .items-table td { 
            border: 1px solid #e0e3ea; 
            padding: 12px; 
            text-align: left; 
        }
        .items-table th { 
            background-color: #f8f9fc; 
            color: #0a1628; 
            font-weight: bold;
        }
        .text-right { text-align: right !important; }
        .text-center { text-align: center !important; }
        
        .summary-box {
            width: 50%;
            float: right;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }
        .summary-table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        .summary-table .total-row td { 
            border-top: 2px solid #0a1628;
            border-bottom: none;
            font-weight: bold; 
            font-size: 16px;
            color: #0a1628;
        }
        .clear { clear: both; }
        
        .status-box {
            margin-top: 20px;
            font-size: 16px;
            font-weight: bold;
            display: inline-block;
            padding: 10px 20px;
            border: 2px solid;
            text-transform: uppercase;
        }
        .status-paid { 
            color: #34c77b; 
            border-color: #34c77b;
        }
        .status-pending { 
            color: #f59e0b; 
            border-color: #f59e0b;
        }
        .footer { 
            margin-top: 60px; 
            font-size: 11px; 
            color: #888; 
            border-top: 1px solid #ddd; 
            padding-top: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header">
        <table class="header-table">
            <tr>
                <td>
                    <h1 class="logo">Hotel<span>ku</span></h1>
                </td>
                <td class="company-info">
                    <strong>Premium Hospitality Experience</strong><br>
                    Jl. Kebahagiaan No. 123, Jakarta<br>
                    Email: support@hotelku.com<br>
                    Telp: (021) 1234-5678
                </td>
            </tr>
        </table>
    </div>

    <div class="invoice-title">INVOICE</div>

    <table class="info-table">
        <tr>
            <td style="width: 50%;">
                <div><span class="label">Invoice No</span> : INV-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}-{{ date('y', strtotime($booking->created_at)) }}</div>
                <div><span class="label">Tgl. Terbit</span> : {{ date('d F Y', strtotime($booking->created_at)) }}</div>
                <div><span class="label">Status</span> : 
                    @php
                        $paymentStatus = $booking->payments->first()->payment_status ?? 'pending';
                    @endphp
                    @if($paymentStatus == 'paid')
                        <span style="color: #34c77b; font-weight: bold;">LUNAS</span>
                    @else
                        <span style="color: #f59e0b; font-weight: bold;">MENUNGGU PEMBAYARAN</span>
                    @endif
                </div>
            </td>
            <td style="width: 50%;">
                <div><span class="label">Kepada</span> : {{ $booking->guest->name ?? '-' }}</div>
                <div><span class="label">Email</span> : {{ $booking->guest->email ?? '-' }}</div>
                <div><span class="label">Telepon</span> : {{ $booking->guest->phone ?? '-' }}</div>
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th>Deskripsi Layanan</th>
                <th class="text-center">Kuantitas</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php
                $checkIn = \Carbon\Carbon::parse($booking->check_in);
                $checkOut = \Carbon\Carbon::parse($booking->check_out);
                $days = $checkIn->diffInDays($checkOut);
                $days = $days == 0 ? 1 : $days;
                $roomPrice = $booking->room->roomType->price ?? 0;
                $roomTotal = $roomPrice * $days;
            @endphp
            <tr>
                <td>
                    <strong>Kamar {{ $booking->room->roomType->name ?? 'Tipe Kamar' }}</strong> (No. {{ $booking->room->room_number ?? '-' }})<br>
                    <small>Check-in: {{ date('d M Y', strtotime($booking->check_in)) }} - Check-out: {{ date('d M Y', strtotime($booking->check_out)) }}</small>
                </td>
                <td class="text-center">{{ $days }} Malam</td>
                <td class="text-right">Rp {{ number_format($roomPrice, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($roomTotal, 0, ',', '.') }}</td>
            </tr>

            @if($booking->restaurantOrder && $booking->restaurantOrder->details->count() > 0)
                @foreach($booking->restaurantOrder->details as $idx => $detail)
                <tr>
                    <td>
                        <strong>{{ $detail->menu->name ?? 'Layanan Restoran' }}</strong>
                        @if($idx == 0)
                            <br><small>Tagihan Tambahan Restoran</small>
                        @endif
                    </td>
                    <td class="text-center">{{ $detail->quantity }}x</td>
                    <td class="text-right">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div class="summary-box">
        <table class="summary-table">
            <tr>
                <td>Subtotal Kamar</td>
                <td class="text-right">Rp {{ number_format($roomTotal, 0, ',', '.') }}</td>
            </tr>
            @if($booking->restaurantOrder)
            <tr>
                <td>Subtotal Restoran</td>
                <td class="text-right">Rp {{ number_format($booking->restaurantOrder->total_price, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($booking->discount_amount > 0)
            <tr>
                <td style="color: #34c77b;">Diskon / Voucher</td>
                <td class="text-right" style="color: #34c77b;">-Rp {{ number_format($booking->discount_amount, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td>TOTAL</td>
                <td class="text-right">Rp {{ number_format($booking->total_price + ($booking->restaurantOrder ? $booking->restaurantOrder->total_price : 0), 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
    
    <div class="clear"></div>

    <div class="status-box {{ $paymentStatus == 'paid' ? 'status-paid' : 'status-pending' }}">
        {{ $paymentStatus == 'paid' ? 'L U N A S' : 'B E L U M  L U N A S' }}
    </div>

    <div class="footer">
        Dokumen ini diterbitkan secara elektronik oleh Hotelku dan sah sebagai bukti pembayaran (jika LUNAS).<br>
        Terimakasih telah mempercayakan akomodasi Anda kepada kami.
    </div>

</body>
</html>
