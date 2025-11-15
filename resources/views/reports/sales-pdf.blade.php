<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Laporan Penjualan - Warung TM</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      margin: 0;
      padding: 20px;
      color: #333;
    }

    .header {
      text-align: center;
      margin-bottom: 30px;
      border-bottom: 2px solid #333;
      padding-bottom: 15px;
    }

    .header h1 {
      font-size: 24px;
      margin: 0;
      color: #2563eb;
    }

    .header h2 {
      font-size: 18px;
      margin: 5px 0;
      color: #666;
    }

    .report-info {
      display: table;
      width: 100%;
      margin-bottom: 20px;
    }

    .report-info .left,
    .report-info .right {
      display: table-cell;
      vertical-align: top;
      width: 50%;
    }

    .summary-section {
      margin-bottom: 30px;
    }

    .summary-cards {
      display: table;
      width: 100%;
      margin-bottom: 20px;
    }

    .summary-card {
      display: table-cell;
      width: 33.333%;
      padding: 15px;
      margin: 0 5px;
      background-color: #f8f9fa;
      border: 1px solid #dee2e6;
      border-radius: 5px;
      text-align: center;
    }

    .summary-card h3 {
      font-size: 14px;
      margin: 0 0 5px 0;
      color: #666;
      font-weight: normal;
    }

    .summary-card .value {
      font-size: 18px;
      font-weight: bold;
      color: #2563eb;
      margin: 0;
    }

    .chart-section {
      margin-bottom: 30px;
    }

    .chart-section h3 {
      font-size: 16px;
      margin-bottom: 15px;
      color: #333;
      border-bottom: 1px solid #ddd;
      padding-bottom: 5px;
    }

    .chart-data {
      background-color: #f8f9fa;
      padding: 15px;
      border-radius: 5px;
    }

    .chart-item {
      display: table;
      width: 100%;
      margin-bottom: 8px;
    }

    .chart-label {
      display: table-cell;
      width: 20%;
      font-weight: bold;
    }

    .chart-bar {
      display: table-cell;
      width: 60%;
      vertical-align: middle;
    }

    .chart-value {
      display: table-cell;
      width: 20%;
      text-align: right;
      font-weight: bold;
      color: #2563eb;
    }

    .bar {
      height: 20px;
      background-color: #e5e7eb;
      border-radius: 10px;
      overflow: hidden;
    }

    .bar-fill {
      height: 100%;
      background: linear-gradient(90deg, #3b82f6, #1d4ed8);
      border-radius: 10px;
    }

    .transactions-section {
      margin-bottom: 30px;
    }

    .transactions-section h3 {
      font-size: 16px;
      margin-bottom: 15px;
      color: #333;
      border-bottom: 1px solid #ddd;
      padding-bottom: 5px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    table th,
    table td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    table th {
      background-color: #f8f9fa;
      font-weight: bold;
      color: #333;
      text-align: center;
    }

    .footer {
      text-align: center;
      margin-top: 30px;
      padding-top: 15px;
      border-top: 1px solid #ddd;
      font-size: 10px;
      color: #666;
    }

    .no-data {
      text-align: center;
      padding: 40px;
      color: #666;
      font-style: italic;
    }

    .page-break {
      page-break-before: always;
    }
  </style>
</head>

<body>
  <!-- Header -->
  <div class="header">
    <h1>WARUNG TM</h1>
    <h2>Laporan Penjualan</h2>
    <p>Periode: {{ $startDate->format('d F Y') }} - {{ $endDate->format('d F Y') }}</p>
  </div>

  <!-- Report Information -->
  <div class="report-info">
    <div class="left">
      <strong>Jenis Periode:</strong> {{ ucfirst($period) }}<br>
      <strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->format('d F Y H:i') }}
    </div>
    <div class="right">
      <strong>Total Transaksi:</strong> {{ $totalTransactions }}<br>
      <strong>Total Penjualan:</strong> Rp {{ number_format($totalSales, 0, ',', '.') }}
    </div>
  </div>

  <!-- Summary Section -->
  <div class="summary-section">
    <h3>Ringkasan Penjualan</h3>
    <div class="summary-cards">
      <div class="summary-card">
        <h3>Total Penjualan</h3>
        <p class="value">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
      </div>
      <div class="summary-card">
        <h3>Total Transaksi</h3>
        <p class="value">{{ $totalTransactions }}</p>
      </div>
      <div class="summary-card">
        <h3>Rata-rata per Transaksi</h3>
        <p class="value">Rp {{ number_format($averageTransaction, 0, ',', '.') }}</p>
      </div>
    </div>
  </div>



  <!-- Transactions Section -->
  <div class="transactions-section">
    <h3>Detail Transaksi</h3>

    @if ($transactions->count() > 0)
      <table>
        <thead>
          <tr>
            <th style="width: 15%">Kode Transaksi</th>
            <th style="width: 20%">Tanggal & Waktu</th>
            <th style="width: 20%">Kasir</th>
            <th style="width: 15%">Pembayaran</th>
            <th style="width: 15%">Total</th>
            <th style="width: 15%">Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($transactions as $transaction)
            <tr>
              <td>{{ $transaction->transaction_code ?? 'TRX-' . $transaction->id }}</td>
              <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
              <td>{{ $transaction->user->name ?? 'N/A' }}</td>
              <td>{{ ucfirst($transaction->payment_method) }}</td>
              <td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
              <td>{{ ucfirst($transaction->status) }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <div class="no-data">
        <p>Tidak ada data transaksi untuk periode yang dipilih.</p>
      </div>
    @endif
  </div>

  <!-- Footer -->
  <div class="footer">
    <p>Laporan ini digenerate otomatis oleh sistem Warung TM pada
      {{ \Carbon\Carbon::now()->format('d F Y H:i:s') }}</p>
    <p>© {{ \Carbon\Carbon::now()->year }} Warung TM - Semua hak cipta dilindungi</p>
  </div>
</body>

</html>
