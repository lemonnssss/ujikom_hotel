<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Statistik - Hotelku</title>
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
        .report-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #0a1628;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .report-subtitle {
            text-align: center;
            font-size: 14px;
            color: #666;
            margin-bottom: 30px;
        }
        .stats-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 30px; 
        }
        .stats-table th, .stats-table td { 
            border: 1px solid #e0e3ea; 
            padding: 12px; 
            text-align: left; 
        }
        .stats-table th { 
            background-color: #f8f9fc; 
            color: #0a1628; 
            font-weight: bold;
            width: 40%;
        }
        .revenue-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 30px; 
        }
        .revenue-table th, .revenue-table td { 
            border: 1px solid #e0e3ea; 
            padding: 10px; 
            text-align: left; 
        }
        .revenue-table th { 
            background-color: #f8f9fc; 
            color: #0a1628; 
            font-weight: bold;
        }
        .text-right { text-align: right !important; }
        .text-center { text-align: center !important; }
        
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
                    <strong>Laporan Resmi Perusahaan</strong><br>
                    Jl. Kebahagiaan No. 123, Jakarta<br>
                    Email: admin@hotelku.com<br>
                    Tanggal Cetak: {{ date('d F Y H:i') }}
                </td>
            </tr>
        </table>
    </div>

    <div class="report-title">LAPORAN STATISTIK HOTEL</div>
    <div class="report-subtitle">
        Cabang: {{ $selectedHotel ? $selectedHotel : 'Semua Cabang (Keseluruhan)' }} | Tahun: {{ date('Y') }}
    </div>

    <table class="stats-table">
        <tr>
            <th>Total Pendapatan (Bersih)</th>
            <td style="font-size: 16px; font-weight: bold; color: #34c77b;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Total Transaksi Reservasi</th>
            <td>{{ number_format($totalBookings, 0, ',', '.') }} Transaksi</td>
        </tr>
        <tr>
            <th>Jumlah Kamar Saat Ini Terisi</th>
            <td>{{ number_format($occupiedRoomsCount, 0, ',', '.') }} Kamar</td>
        </tr>
    </table>

    <h3 style="color: #0a1628; margin-bottom: 10px;">Rincian Pendapatan Bulanan (Tahun {{ date('Y') }})</h3>
    <table class="revenue-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 50px;">No</th>
                <th>Bulan</th>
                <th class="text-right">Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @php $totalCalc = 0; @endphp
            @foreach($chartData as $idx => $data)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td>{{ $data['month'] }}</td>
                <td class="text-right">Rp {{ number_format($data['total'], 0, ',', '.') }}</td>
            </tr>
            @php $totalCalc += $data['total']; @endphp
            @endforeach
            <tr style="font-weight: bold; background-color: #f8f9fc;">
                <td colspan="2" class="text-right">TOTAL PENDAPATAN TAHUN {{ date('Y') }}</td>
                <td class="text-right">Rp {{ number_format($totalCalc, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini diterbitkan secara otomatis oleh sistem Hotelku.<br>
        Data yang tertera adalah akurat pada saat dokumen ini dicetak.
    </div>

</body>
</html>
