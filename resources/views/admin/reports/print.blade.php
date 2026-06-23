<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan_Penyewaan_{{ $startDate }}_sd_{{ $endDate }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1a1a1a;
            background-color: #ffffff;
            margin: 0;
            padding: 20px;
            font-size: 13px;
            line-height: 1.5;
        }
        .header {
            position: relative;
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #000;
            padding-bottom: 20px;
        }
        .header img {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 90px;
            height: 90px;
            object-fit: contain;
        }
        .header-content {
            padding: 0 100px;
        }
        .header-content h1 {
            margin: 0;
            font-family: 'Times New Roman', Times, serif;
            font-size: 28px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #000;
        }
        .header-content p {
            margin: 8px 0 0;
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            font-size: 14px;
            line-height: 1.4;
        }
        .header-content p strong {
            font-size: 18px;
            font-weight: bold;
            display: block;
            margin-bottom: 4px;
        }
        .meta-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 12px;
        }
        .meta-info div span {
            font-weight: bold;
        }
        .summary-cards {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }
        .card {
            flex: 1;
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
        }
        .card span {
            font-size: 10px;
            text-transform: uppercase;
            color: #666;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .card h3 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table th, table td {
            border: 1px solid #e0e0e0;
            padding: 8px 10px;
            text-align: left;
        }
        table th {
            background-color: #f5f5f5;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-mono { font-family: Courier, monospace; }
        .total-row {
            font-weight: bold;
            background-color: #fafdff;
        }
        .footer {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #666;
        }
        .signature-box {
            text-align: center;
            width: 200px;
        }
        .signature-box .line {
            margin-top: 60px;
            border-top: 1px solid #1a1a1a;
            padding-top: 5px;
            font-weight: bold;
        }
        @media print {
            body { padding: 0; }
            button { display: none; }
            @page {
                size: A4;
                margin: 1.5cm;
            }
        }
    </style>
</head>
<body>

    <!-- Header Laporan -->
    <div class="header">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Toko">
        <div class="header-content">
            <h1>LAPORAN KEUANGAN</h1>
            <p>
                <strong>CameraSewa Official Store</strong><br>
                Jl. Lensa Fotografi No. 123, Kebayoran Baru, Jakarta Selatan, 12110<br>
                Telp: (021) 1234-5678 | Email: hello@camerasewa.com
            </p>
        </div>
    </div>

    <!-- Informasi Laporan -->
    <div class="meta-info">
        <div>
            <span>Periode Laporan:</span> {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} s.d. {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}
        </div>
        <div>
            <span>Dicetak Pada:</span> {{ \Carbon\Carbon::now()->format('d M Y H:i') }}
        </div>
    </div>

    <!-- Kotak Ringkasan -->
    <div class="summary-cards">
        <div class="card">
            <span>Total Pendapatan Riil</span>
            <h3>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
        </div>
        <div class="card">
            <span>Jumlah Transaksi Sukses</span>
            <h3>{{ $totalTransactions }} Transaksi</h3>
        </div>
        <div class="card">
            <span>Kamera Terpopuler</span>
            <h3>
                @if($popularProducts->count() > 0)
                    {{ $popularProducts->first()->product->produk_name ?? 'N/A' }}
                @else
                    -
                @endif
            </h3>
        </div>
    </div>

    <!-- Tabel Rincian -->
    <h3>Rincian Transaksi Penyewaan</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 12%">Kode Trx</th>
                <th>Penyewa</th>
                <th class="text-center" style="width: 15%">Tanggal Sewa</th>
                <th class="text-center" style="width: 12%">Status</th>
                <th class="text-right" style="width: 18%">Nilai Transaksi</th>
                <th class="text-right" style="width: 18%">Kas Diterima</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalTransactedVal = 0;
                $totalReceivedVal = 0;
            @endphp
            @forelse($transactions as $trx)
                @php
                    $totalTransactedVal += $trx->total_price;
                    $received = $trx->transaksi_status === 'completed' ? $trx->total_price : $trx->uang_panjar;
                    $totalReceivedVal += $received;
                @endphp
                <tr>
                    <td class="font-mono">#{{ $trx->code }}</td>
                    <td>
                        <strong>{{ $trx->receiver }}</strong> ({{ $trx->user->name ?? '' }})
                    </td>
                    <td class="text-center">{{ $trx->tanggal_sewa ? $trx->tanggal_sewa->format('d/m/Y') : '-' }}</td>
                    <td class="text-center" style="text-transform: uppercase; font-size: 10px;">{{ $trx->transaksi_status }}</td>
                    <td class="text-right font-mono">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                    <td class="text-right font-mono">Rp {{ number_format($received, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada transaksi dalam periode ini.</td>
                </tr>
            @endforelse
            
            @if($transactions->count() > 0)
                <tr class="total-row">
                    <td colspan="4" class="text-right" style="text-transform: uppercase;">Total Akumulasi:</td>
                    <td class="text-right font-mono">Rp {{ number_format($totalTransactedVal, 0, ',', '.') }}</td>
                    <td class="text-right font-mono">Rp {{ number_format($totalReceivedVal, 0, ',', '.') }}</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Tanda Tangan & Footer -->
    <div class="footer">
        <div>
            Sistem Persewaan Kamera - Dicetak secara otomatis oleh sistem.
        </div>
        <div class="signature-box">
            <p>Admin Toko,</p>
            <div class="line">{{ auth()->user()->name }}</div>
        </div>
    </div>

    <!-- Script Cetak Otomatis -->
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
