<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Mail\ResetOtpMail;

class AuthController extends Controller
{
    public function login() {
        return view('login');
    }

    public function register() {
        return view('register');
    }

    public function loginPost(Request $request) {
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            return redirect('/dashboard');
        }
        
        return back()->with('error', 'Email atau Password salah!');
    }

    public function registerPost(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.'
        ]);

        // Generate OTP
        $otp = rand(100000, 999999);

        // Store registration data and OTP in session
        session([
            'register_data' => [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user'
            ],
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(10)
        ]);

        // Send OTP via email
        try {
            Mail::to($request->email)->send(new OtpMail($otp));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email OTP. Pastikan konfigurasi email benar.')->withInput();
        }

        return redirect('/verify-otp')->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }

    public function verifyOtp() {
        if (!session('register_data')) {
            return redirect('/register')->with('error', 'Silakan daftar terlebih dahulu.');
        }
        return view('verify-otp');
    }

    public function verifyOtpPost(Request $request) {
        $request->validate([
            'otp' => 'required|numeric'
        ]);

        $sessionOtp = session('otp_code');
        $expiresAt = session('otp_expires_at');
        $registerData = session('register_data');

        if (!$sessionOtp || !$registerData) {
            return redirect('/register')->with('error', 'Sesi telah berakhir, silakan daftar ulang.');
        }

        if (now()->greaterThan($expiresAt)) {
            session()->forget(['otp_code', 'otp_expires_at']);
            return back()->with('error', 'Kode OTP telah kedaluwarsa. Silakan daftar ulang atau minta OTP baru.'); // In a real app we'd have a resend OTP method
        }

        if ($request->otp == $sessionOtp) {
            // OTP is correct, create user
            $user = User::create($registerData);

            // Clear session data
            session()->forget(['register_data', 'otp_code', 'otp_expires_at']);

            // Login user
            Auth::login($user);
            return redirect('/dashboard')->with('success', 'Registrasi berhasil dan email telah diverifikasi!');
        }

        return back()->with('error', 'Kode OTP salah!');
    }

    public function logout() {
        Auth::logout();
        return redirect('/');
    }

    // --- LUPA PASSWORD FLOW ---

    public function forgotPassword() {
        return view('forgot-password');
    }

    public function forgotPasswordPost(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'Email tidak terdaftar dalam sistem kami.'
        ]);

        $otp = rand(100000, 999999);

        session([
            'reset_email' => $request->email,
            'reset_otp_code' => $otp,
            'reset_otp_expires_at' => now()->addMinutes(10)
        ]);

        try {
            Mail::to($request->email)->send(new ResetOtpMail($otp));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email OTP. Pastikan konfigurasi email benar.')->withInput();
        }

        return redirect('/verify-reset-otp')->with('success', 'Kode OTP untuk reset password telah dikirim ke email Anda.');
    }

    public function verifyResetOtp() {
        if (!session('reset_email')) {
            return redirect('/forgot-password')->with('error', 'Silakan masukkan email Anda terlebih dahulu.');
        }
        return view('verify-reset-otp');
    }

    public function verifyResetOtpPost(Request $request) {
        $request->validate([
            'otp' => 'required|numeric'
        ]);

        $sessionOtp = session('reset_otp_code');
        $expiresAt = session('reset_otp_expires_at');
        $resetEmail = session('reset_email');

        if (!$sessionOtp || !$resetEmail) {
            return redirect('/forgot-password')->with('error', 'Sesi telah berakhir, silakan ulangi proses lupa password.');
        }

        if (now()->greaterThan($expiresAt)) {
            session()->forget(['reset_otp_code', 'reset_otp_expires_at']);
            return back()->with('error', 'Kode OTP telah kedaluwarsa. Silakan minta OTP baru.');
        }

        if ($request->otp == $sessionOtp) {
            session(['reset_verified' => true]);
            session()->forget(['reset_otp_code', 'reset_otp_expires_at']);
            
            return redirect('/reset-password')->with('success', 'OTP diverifikasi. Silakan masukkan kata sandi baru Anda.');
        }

        return back()->with('error', 'Kode OTP salah!');
    }

    public function resetPassword() {
        if (!session('reset_verified') || !session('reset_email')) {
            return redirect('/forgot-password')->with('error', 'Silakan verifikasi OTP terlebih dahulu.');
        }
        return view('reset-password');
    }

    public function resetPasswordPost(Request $request) {
        $request->validate([
            'password' => 'required|string|min:6|confirmed'
        ], [
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.'
        ]);

        $email = session('reset_email');
        if (!$email) {
            return redirect('/forgot-password')->with('error', 'Sesi telah berakhir.');
        }

        $user = User::where('email', $email)->first();
        if ($user) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            session()->forget(['reset_email', 'reset_verified']);

            return redirect('/login')->with('success', 'Kata sandi berhasil direset! Silakan login dengan kata sandi baru Anda.');
        }

        return redirect('/forgot-password')->with('error', 'Terjadi kesalahan, pengguna tidak ditemukan.');
    }
}