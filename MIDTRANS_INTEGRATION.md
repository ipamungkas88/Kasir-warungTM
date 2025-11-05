# Implementasi Midtrans QRIS Payment Gateway

## Overview

Implementasi ini menambahkan fitur pembayaran QRIS menggunakan Midtrans Sandbox ke dalam sistem kasir Warung TM.

## Fitur yang Ditambahkan

1. **Payment Method QRIS**: Option pembayaran QRIS di dropdown metode pembayaran
2. **Modal Pop-up QRIS**: Modal yang menampilkan interface pembayaran Midtrans Snap
3. **Real-time Payment Processing**: Integrasi dengan Midtrans untuk proses pembayaran real-time
4. **Callback Handler**: Endpoint untuk menangani notifikasi status pembayaran dari Midtrans

## File yang Dimodifikasi/Ditambahkan

### 1. Dependencies

-   **Midtrans PHP SDK**: `composer require midtrans/midtrans-php`

### 2. Configuration Files

-   **config/midtrans.php**: Konfigurasi Midtrans (Server Key, Client Key, dll)
-   **.env**: Environment variables untuk Midtrans credentials

### 3. Database Migration

-   **2025_11_05_122251_add_payment_columns_to_transactions_table.php**:
    -   Menambah kolom `payment_token`
    -   Menambah kolom `payment_status`
    -   Menambah kolom `midtrans_order_id`

### 4. Services

-   **app/Services/MidtransService.php**: Service class untuk handle Midtrans API

### 5. Controllers

-   **app/Http/Controllers/KasirController.php**:
    -   Method `createPaymentToken()`: Generate Snap token untuk QRIS
    -   Method `midtransCallback()`: Handle callback dari Midtrans
    -   Method `checkPaymentStatus()`: Check status pembayaran manual

### 6. Models

-   **app/Models/Transaction.php**: Menambah fillable fields untuk payment columns

### 7. Routes

-   **routes/web.php**:
    -   Route untuk create payment token
    -   Route untuk Midtrans callback (dikecualikan dari CSRF protection)
    -   Route untuk check payment status

### 8. Views

-   **resources/views/pages/kasir/transaksi.blade.php**:
    -   Menambah option QRIS di dropdown payment method
    -   Menambah modal pop-up untuk QRIS payment
    -   Integrasi Midtrans Snap script
    -   JavaScript untuk handle QRIS payment flow

### 9. Middleware Configuration

-   **bootstrap/app.php**: Mengecualikan route callback dari CSRF protection

## Kredensial Midtrans Sandbox

```
Server Key: SB-Mid-server-GwUP_WGbJPMxIc4IA5KCHyab
Client Key: SB-Mid-client-nKsqvar5cn60u2Lv
Environment: Sandbox
```

## Cara Penggunaan

1. Login sebagai kasir
2. Navigasi ke menu "Transaksi"
3. Pilih menu yang akan dibeli
4. Pilih metode pembayaran "QRIS"
5. Klik "Proses Pesanan"
6. Modal QRIS akan muncul dengan interface Midtrans Snap
7. Scan QRIS code untuk melakukan pembayaran
8. Status pembayaran akan diupdate secara real-time

## Flow Pembayaran QRIS

1. **Inisiasi**: User memilih QRIS dan klik "Proses Pesanan"
2. **Token Generation**: System mengirim request ke endpoint `createPaymentToken`
3. **Snap Integration**: Midtrans Snap token di-embed ke dalam modal
4. **Payment Process**: User melakukan pembayaran melalui QRIS
5. **Callback**: Midtrans mengirim notifikasi ke callback endpoint
6. **Status Update**: System mengupdate status transaksi di database
7. **Completion**: User melihat konfirmasi transaksi berhasil

## Testing

-   Gunakan Midtrans Simulator untuk testing: https://simulator.sandbox.midtrans.com/
-   Untuk QRIS testing, gunakan QRIS simulator yang tersedia di Midtrans dashboard

## Security Features

1. **Signature Verification**: Verifikasi signature dari callback Midtrans
2. **CSRF Exception**: Callback endpoint dikecualikan dari CSRF protection
3. **Server Key Protection**: Server key disimpan di environment variables

## Error Handling

-   Logging untuk callback errors
-   Try-catch blocks untuk semua Midtrans operations
-   User-friendly error messages
-   Fallback untuk payment failures

## Notes

-   Implementasi ini menggunakan Midtrans Sandbox untuk development
-   Untuk production, ubah `MIDTRANS_IS_PRODUCTION=true` dan gunakan production credentials
-   Pastikan callback URL dikonfigurasi di Midtrans dashboard untuk production
