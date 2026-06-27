<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faktur_Rental_{{ $transaction->code }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace; /* Monospace gives that dot-matrix/receipt feel */
            color: #000;
            background-color: #f3f4f6;
            margin: 0;
            padding: 20px;
            font-size: 13px;
            line-height: 1.4;
        }
        .invoice-container {
            max-width: 600px; /* Memanjang ke bawah, tidak terlalu lebar */
            margin: 0 auto;
            background: #fff;
            padding: 15px;
            border: 1px solid #000;
        }
        /* Top Header Box */
        .header-box {
            border: 1px solid #000;
            display: flex;
            padding: 10px;
            margin-bottom: 15px;
        }
        .header-logo {
            width: 80px;
            height: 80px;
            border: 1px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }
        .header-logo img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .header-company {
            flex: 1;
        }
        .header-company strong {
            font-size: 16px;
            display: block;
            margin-bottom: 4px;
        }
        .header-meta {
            text-align: right;
        }
        .header-meta strong {
            display: block;
            margin-bottom: 4px;
        }
        /* Customer Info */
        .customer-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 0 5px;
        }
        /* Data List */
        .section-title {
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 5px;
            padding: 0 5px;
        }
        .data-row {
            display: flex;
            padding: 3px 5px;
        }
        .data-label {
            width: 180px;
            flex-shrink: 0;
        }
        .data-value {
            flex: 1;
        }
        .item-list {
            margin-bottom: 5px;
        }
        .item-list div {
            margin-bottom: 3px;
        }
        /* Footer Signatures */
        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
            padding: 0 20px;
        }
        .sig-box {
            text-align: center;
            width: 150px;
        }
        .sig-name {
            margin-top: 60px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
        @media print {
            body { 
                background-color: #fff; 
                padding: 0; 
            }
            .invoice-container {
                border: none;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="invoice-container">
    <!-- Header Box -->
    <div class="header-box">
        <div class="header-logo">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
        </div>
        <div class="header-company">
            <strong>CAMERA SEWA STORE</strong>
            <div>Jl. Gajah No.VII, Air Tawar Bar., Kec. Padang Utara, Kota Padang, Sumatera Barat 25132</div>
            <div>HP: (021) 1234-5678 | Email: hello@camerasewa.com</div>
        </div>
        <div class="header-meta">
            <strong>Faktur penyewaan</strong>
            <div>No. Transaksi: {{ $transaction->code }}</div>
            <div>Tgl: {{ \Carbon\Carbon::now()->format('d-M-y') }}</div>
        </div>
    </div>

    <!-- Customer Info -->
    <div class="customer-info">
        <div>
            <div>Nama Penyewa : {{ $transaction->receiver }}</div>
            <div>Alamat / Kota: {{ $transaction->city }}</div>
        </div>
        <div>
            <div>No.hp : {{ $transaction->user->phone ?? '-' }}</div>
        </div>
    </div>

    <!-- Detail Faktur Penyewaan -->
    <div class="section-title">Detail Faktur Penyewaan</div>
    <div class="data-row">
        <div class="data-label">Kode Transaksi</div>
        <div class="data-value">: {{ $transaction->code }}</div>
    </div>
    <div class="data-row">
        <div class="data-label">Item Sewa</div>
        <div class="data-value">: 
            <div class="item-list">
                @foreach($transaction->details as $detail)
                    <div>- {{ $detail->product->produk_name ?? 'Produk dihapus' }} ({{ $detail->banyak }} unit x {{ $detail->duration_hours == 0 ? '5 Menit' : $detail->duration_hours . ' Jam' }})</div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="data-row">
        <div class="data-label">Status Penyewaan</div>
        <div class="data-value">: {{ strtoupper($transaction->transaksi_status) }}</div>
    </div>
    <div class="data-row">
        <div class="data-label">Tanggal Sewa</div>
        <div class="data-value">: {{ $transaction->tanggal_sewa ? $transaction->tanggal_sewa->format('d F Y') : '-' }}</div>
    </div>
    <div class="data-row">
        <div class="data-label">Uang Muka (DP)</div>
        <div class="data-value">: Rp {{ number_format($transaction->uang_panjar, 0, ',', '.') }}</div>
    </div>

    <!-- Detail Transfer -->
    <div class="section-title">Detail transfer / Pembayaran</div>
    <div class="data-row">
        <div class="data-label">Sisa Bayar Pelunasan</div>
        <div class="data-value">: Rp {{ number_format(max(0, $transaction->total_price - $transaction->uang_panjar), 0, ',', '.') }}</div>
    </div>
    <div class="data-row">
        <div class="data-label">Metode Pembayaran</div>
        <div class="data-value">: {{ $transaction->bayar->jenis_bayar ?? 'Manual' }}</div>
    </div>
    <div class="data-row">
        <div class="data-label">Total Harga</div>
        <div class="data-value">: Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</div>
    </div>

    <!-- Signatures -->
    <div class="signatures">
        <div class="sig-box">
            <div>Diterima oleh</div>
            <div class="sig-name">{{ $transaction->receiver }}</div>
        </div>
        <div class="sig-box">
            <div>Pimpinan</div>
            <div class="sig-name">CameraSewa</div>
        </div>
    </div>

</div>

<script>
    window.onload = function() {
        window.print();
    }
</script>
</body>
</html>
