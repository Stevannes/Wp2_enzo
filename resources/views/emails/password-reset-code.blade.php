<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi Pembaruan Kata Sandi</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            padding: 24px;
            color: #1e293b;
        }
        .container {
            max-width: 560px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }
        .header {
            background-color: #0a0f1d;
            padding: 32px 24px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 22px;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            font-weight: 900;
        }
        .header p {
            color: #c29b53;
            margin: 6px 0 0 0;
            font-size: 11px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            font-weight: 700;
        }
        .content {
            padding: 32px 28px;
        }
        .greeting {
            font-size: 15px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 12px;
        }
        .text {
            font-size: 13px;
            line-height: 1.6;
            color: #475569;
            margin-bottom: 24px;
        }
        .code-box {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            border: 2px solid #c29b53;
            margin-bottom: 24px;
        }
        .code-box-label {
            color: #c29b53;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            margin-bottom: 8px;
        }
        .code-value {
            font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
            font-size: 36px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: 0.25em;
            margin: 0;
        }
        .alert-box {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 12px 16px;
            border-radius: 6px;
            font-size: 12px;
            color: #92400e;
            line-height: 1.5;
            margin-bottom: 24px;
        }
        .footer {
            background-color: #f8fafc;
            padding: 20px 24px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            font-size: 11px;
            color: #94a3b8;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Brand -->
        <div class="header">
            <h1 style="text-transform: lowercase;">enzo</h1>
            <p>building construction and interior</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">Halo, {{ $name }}</div>
            <div class="text">
                Kami menerima permintaan untuk memperbarui kata sandi akun klien enzo Anda. Gunakan kode verifikasi 6 digit berikut untuk mengonfirmasi perubahan kata sandi Anda:
            </div>

            <!-- OTP Code Card -->
            <div class="code-box">
                <div class="code-box-label">KODE VERIFIKASI PEMBARUAN KATA SANDI</div>
                <div class="code-value">{{ $code }}</div>
            </div>

            <div class="alert-box">
                <strong>Penting:</strong> Kode verifikasi ini hanya berlaku selama <strong>15 menit</strong>. Jangan bagikan kode ini kepada pihak manapun demi keamanan data proyek dan akun Anda.
            </div>

            <div class="text" style="margin-bottom: 0;">
                Jika Anda tidak pernah meminta perubahan kata sandi ini, abaikan email ini. Akun Anda tetap aman dan kata sandi Anda tidak akan berubah.
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} enzo — building construction and interior. Seluruh Hak Cipta Dilindungi.<br>
            Email otomatis dari Sistem Keamanan Terpusat enzo Customer Portal.
        </div>
    </div>
</body>
</html>
