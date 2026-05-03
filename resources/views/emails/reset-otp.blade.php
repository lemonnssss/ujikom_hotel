<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h2 style="color: #333; text-align: center;">Reset Kata Sandi</h2>
        <p style="color: #555; font-size: 16px;">Halo,</p>
        <p style="color: #555; font-size: 16px;">Kami menerima permintaan untuk mereset kata sandi akun Anda. Gunakan kode OTP berikut untuk melanjutkan proses reset password:</p>
        <div style="background-color: #f8f9fa; border: 1px dashed #ccc; padding: 15px; text-align: center; font-size: 24px; font-weight: bold; letter-spacing: 5px; color: #0d6efd; margin: 20px 0;">
            {{ $otp }}
        </div>
        <p style="color: #555; font-size: 16px;">Kode OTP ini berlaku selama 10 menit. Jika Anda tidak meminta reset kata sandi, abaikan email ini.</p>
        <p style="color: #555; font-size: 16px;">Terima kasih,<br>Tim Hotel Kami</p>
    </div>
</body>
</html>
