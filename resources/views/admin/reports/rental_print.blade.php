<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan_Operasional_Penyewaan_{{ $startDate }}_sd_{{ $endDate }}</title>
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
            width: 85px;
            height: 85px;
            object-fit: contain;
        }
        .header-content {
            padding: 0 100px;
        }
        .header-content h1 {
            margin: 0;
            font-family: 'Times New Roman', Times, serif;
            font-size: 26px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #000;
        }
        .header-content p {
            margin: 6px 0 0;
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            font-size: 13px;
            line-height: 1.4;
        }
        .header-content p strong {
            font-size: 17px;
            font-weight: bold;
            display: block;
            margin-bottom: 3px;
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
            margin-bottom: 25px;
        }
        .card {
            flex: 1;
            border: 1px solid #ccc;
            padding: 12px;
            border-radius: 6px;
            text-align: center;
        }
        .card span {
            font-size: 10px;
            text-transform: uppercase;
            color: #555;
            font-weight: bold;
            display: block;
            margin-bottom: 4px;
        }
        .card h3 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
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
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #555;
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
            <h1>LAPORAN OPERASIONAL PENYEWAAN</h1>
            <p>
                <strong>CameraSewa Official Store</strong><br>
                Jl. Gajah No.VII, Air Tawar Bar., Kec. Padang Utara, Kota Padang, Sumatera Barat 25132<br>
                Telp: (021) 1234-5678 | Email: hello@camerasewa.com
            </p>
        </div>
    </div>

    <!-- Informasi Laporan -->
    <div class="meta-info">
        <div>
            <span>Periode Sewa:</span> {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} s.d. {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}
        </div>
        <div>
            <span>Dicetak Pada:</span> {{ \Carbon\Carbon::now()->format('d M Y H:i') }}
        </div>
    </div>

    <!-- Kotak Ringkasan -->
    <div class="summary-cards">
        <div class="card">
            <span>Total Transaksi Booking</span>
            <h3>{{ $totalTransactions }} Transaksi</h3>
        </div>
        <div class="card">
            <span>Total Unit Alat Disewa</span>
            <h3>{{ $totalUnitsRented }} Unit</h3>
        </div>
        <div class="card">
            <span>Kamera Paling Laris</span>
            <h3 style="font-size: 14px;">
                @if($popularProducts->count() > 0)
                    {{ $popularProducts->first()->product->produk_name ?? '-' }} ({{ $popularProducts->first()->total_rented }}x)
                @else
                    -
                @endif
            </h3>
        </div>
    </div>

    <!-- Tabel Rincian -->
    <h3 style="font-size: 14px; margin-bottom: 8px;">Rincian Aktivitas Penyewaan Unit</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 12%">Kode Trx</th>
                <th style="width: 23%">Penyewa</th>
                <th style="width: 35%">Daftar Unit Kamera Disewa</th>
                <th class="text-center" style="width: 12%">Total Unit</th>
                <th class="text-center" style="width: 18%">Tanggal Sewa</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $trx)
                @php
                    $qtyTrx = 0;
                    foreach($trx->details as $d) { $qtyTrx += $d->banyak; }
                @endphp
                <tr>
                    <td class="font-mono">#{{ $trx->code }}</td>
                    <td>
                        <strong>{{ $trx->receiver }}</strong><br>
                        <span style="font-size: 11px; color: #666;">({{ $trx->user->name ?? '' }})</span>
                    </td>
                    <td>
                        <ul style="margin: 0; padding-left: 14px; list-style-type: square;">
                            @forelse($trx->details as $detail)
                                <li style="margin-bottom: 2px;">
                                    <strong>{{ $detail->product->produk_name ?? 'Item Tidak Diketahui' }}</strong> ({{ $detail->banyak }} Unit)
                                </li>
                            @empty
                                <li>-</li>
                            @endforelse
                        </ul>
                    </td>
                    <td class="text-center font-mono font-bold">{{ $qtyTrx }} Unit</td>
                    <td class="text-center">{{ $trx->tanggal_sewa ? $trx->tanggal_sewa->format('d/m/Y') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada aktivitas penyewaan dalam periode ini.</td>
                </tr>
            @endforelse
            
            @if($transactions->count() > 0)
                <tr class="total-row">
                    <td colspan="3" class="text-right" style="text-transform: uppercase;">Total Akumulasi Unit Disewa:</td>
                    <td class="text-center font-mono">{{ $totalUnitsRented }} Unit</td>
                    <td></td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Tanda Tangan & Footer -->
    <div class="footer">
        <div>
            Sistem Persewaan Kamera - Laporan Operasional Penyewaan Unit.
        </div>
        <div class="signature-box">
            <p>Bagian Operasional,</p>
            <div class="line">{{ auth()->user()->name ?? 'Admin' }}</div>
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
