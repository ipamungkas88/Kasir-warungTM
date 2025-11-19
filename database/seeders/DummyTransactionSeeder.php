<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DummyTransactionSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Tambahkan user kasir jika belum ada
        DB::table('users')->insertOrIgnore([
            [
                'id' => 2,
                'name' => 'Kasir 1',
                'username' => 'kasir1',
                'email' => 'kasir1@warung.tm',
                'password' => bcrypt('kasir123'),
                'role' => 'kasir',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'name' => 'Kasir 2',
                'username' => 'kasir2',
                'email' => 'kasir2@warung.tm',
                'password' => bcrypt('kasir123'),
                'role' => 'kasir',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Data transaksi hari ini (19 November 2025)
        $transactions = [
            [
                'user_id' => 2,
                'transaction_code' => 'TRX-20251119001',
                'total_amount' => 43000,
                'total_items' => 3,
                'paid_amount' => 50000,
                'change_amount' => 7000,
                'payment_method' => 'cash',
                'status' => 'completed',
                'notes' => 'Pelanggan reguler',
                'created_at' => '2025-11-19 08:30:00',
                'updated_at' => '2025-11-19 08:30:00'
            ],
            [
                'user_id' => 3,
                'transaction_code' => 'TRX-20251119002',
                'total_amount' => 28000,
                'total_items' => 2,
                'paid_amount' => 30000,
                'change_amount' => 2000,
                'payment_method' => 'digital',
                'status' => 'completed',
                'notes' => null,
                'created_at' => '2025-11-19 09:15:00',
                'updated_at' => '2025-11-19 09:15:00'
            ],
            [
                'user_id' => 2,
                'transaction_code' => 'TRX-20251119003',
                'total_amount' => 35000,
                'total_items' => 3,
                'paid_amount' => 35000,
                'change_amount' => 0,
                'payment_method' => 'card',
                'status' => 'completed',
                'notes' => null,
                'created_at' => '2025-11-19 10:45:00',
                'updated_at' => '2025-11-19 10:45:00'
            ],
            [
                'user_id' => 3,
                'transaction_code' => 'TRX-20251119004',
                'total_amount' => 52000,
                'total_items' => 2,
                'paid_amount' => 55000,
                'change_amount' => 3000,
                'payment_method' => 'cash',
                'status' => 'completed',
                'notes' => 'Pesanan keluarga',
                'created_at' => '2025-11-19 12:20:00',
                'updated_at' => '2025-11-19 12:20:00'
            ],
            [
                'user_id' => 2,
                'transaction_code' => 'TRX-20251119005',
                'total_amount' => 18000,
                'total_items' => 2,
                'paid_amount' => 20000,
                'change_amount' => 2000,
                'payment_method' => 'cash',
                'status' => 'completed',
                'notes' => null,
                'created_at' => '2025-11-19 13:30:00',
                'updated_at' => '2025-11-19 13:30:00'
            ],
            [
                'user_id' => 3,
                'transaction_code' => 'TRX-20251119006',
                'total_amount' => 40000,
                'total_items' => 2,
                'paid_amount' => 50000,
                'change_amount' => 10000,
                'payment_method' => 'cash',
                'status' => 'completed',
                'notes' => null,
                'created_at' => '2025-11-19 15:10:00',
                'updated_at' => '2025-11-19 15:10:00'
            ],
            // Data kemarin (18 November 2025)
            [
                'user_id' => 2,
                'transaction_code' => 'TRX-20251118001',
                'total_amount' => 38000,
                'total_items' => 2,
                'paid_amount' => 40000,
                'change_amount' => 2000,
                'payment_method' => 'cash',
                'status' => 'completed',
                'notes' => null,
                'created_at' => '2025-11-18 08:15:00',
                'updated_at' => '2025-11-18 08:15:00'
            ],
            [
                'user_id' => 3,
                'transaction_code' => 'TRX-20251118002',
                'total_amount' => 25000,
                'total_items' => 1,
                'paid_amount' => 25000,
                'change_amount' => 0,
                'payment_method' => 'digital',
                'status' => 'completed',
                'notes' => null,
                'created_at' => '2025-11-18 09:30:00',
                'updated_at' => '2025-11-18 09:30:00'
            ],
            [
                'user_id' => 2,
                'transaction_code' => 'TRX-20251118003',
                'total_amount' => 47000,
                'total_items' => 2,
                'paid_amount' => 50000,
                'change_amount' => 3000,
                'payment_method' => 'cash',
                'status' => 'completed',
                'notes' => 'Makan siang kantor',
                'created_at' => '2025-11-18 11:45:00',
                'updated_at' => '2025-11-18 11:45:00'
            ],
            // Data bulan Oktober 2025
            [
                'user_id' => 2,
                'transaction_code' => 'TRX-20251031001',
                'total_amount' => 45000,
                'total_items' => 2,
                'paid_amount' => 50000,
                'change_amount' => 5000,
                'payment_method' => 'cash',
                'status' => 'completed',
                'notes' => null,
                'created_at' => '2025-10-31 11:30:00',
                'updated_at' => '2025-10-31 11:30:00'
            ],
            [
                'user_id' => 3,
                'transaction_code' => 'TRX-20251031002',
                'total_amount' => 38000,
                'total_items' => 2,
                'paid_amount' => 40000,
                'change_amount' => 2000,
                'payment_method' => 'digital',
                'status' => 'completed',
                'notes' => null,
                'created_at' => '2025-10-31 15:20:00',
                'updated_at' => '2025-10-31 15:20:00'
            ],
            [
                'user_id' => 2,
                'transaction_code' => 'TRX-20251030001',
                'total_amount' => 42000,
                'total_items' => 2,
                'paid_amount' => 45000,
                'change_amount' => 3000,
                'payment_method' => 'cash',
                'status' => 'completed',
                'notes' => null,
                'created_at' => '2025-10-30 09:45:00',
                'updated_at' => '2025-10-30 09:45:00'
            ],
            // Data September 2025
            [
                'user_id' => 2,
                'transaction_code' => 'TRX-20250930001',
                'total_amount' => 41000,
                'total_items' => 2,
                'paid_amount' => 45000,
                'change_amount' => 4000,
                'payment_method' => 'cash',
                'status' => 'completed',
                'notes' => null,
                'created_at' => '2025-09-30 12:15:00',
                'updated_at' => '2025-09-30 12:15:00'
            ],
            [
                'user_id' => 3,
                'transaction_code' => 'TRX-20250930002',
                'total_amount' => 36000,
                'total_items' => 2,
                'paid_amount' => 40000,
                'change_amount' => 4000,
                'payment_method' => 'digital',
                'status' => 'completed',
                'notes' => null,
                'created_at' => '2025-09-30 17:30:00',
                'updated_at' => '2025-09-30 17:30:00'
            ]
        ];

        DB::table('transactions')->insertOrIgnore($transactions);

        // Tambahkan transaction items untuk beberapa transaksi sebagai contoh
        $transactionItems = [
            // TRX-20251119001 (43000) - 3 items
            [
                'transaction_id' => 1,
                'menu_id' => 1,
                'menu_name' => 'Nasi Gudeg',
                'quantity' => 1,
                'menu_price' => 25000,
                'subtotal' => 25000,
                'created_at' => '2025-11-19 08:30:00',
                'updated_at' => '2025-11-19 08:30:00'
            ],
            [
                'transaction_id' => 1,
                'menu_id' => 5,
                'menu_name' => 'Es Teh Manis',
                'quantity' => 2,
                'menu_price' => 5000,
                'subtotal' => 10000,
                'created_at' => '2025-11-19 08:30:00',
                'updated_at' => '2025-11-19 08:30:00'
            ],
            [
                'transaction_id' => 1,
                'menu_id' => 6,
                'menu_name' => 'Es Jeruk',
                'quantity' => 1,
                'menu_price' => 8000,
                'subtotal' => 8000,
                'created_at' => '2025-11-19 08:30:00',
                'updated_at' => '2025-11-19 08:30:00'
            ],
            // TRX-20251119002 (28000) - 2 items
            [
                'transaction_id' => 2,
                'menu_id' => 2,
                'menu_name' => 'Soto Ayam',
                'quantity' => 1,
                'menu_price' => 20000,
                'subtotal' => 20000,
                'created_at' => '2025-11-19 09:15:00',
                'updated_at' => '2025-11-19 09:15:00'
            ],
            [
                'transaction_id' => 2,
                'menu_id' => 6,
                'menu_name' => 'Es Jeruk',
                'quantity' => 1,
                'menu_price' => 8000,
                'subtotal' => 8000,
                'created_at' => '2025-11-19 09:15:00',
                'updated_at' => '2025-11-19 09:15:00'
            ]
        ];

        DB::table('transaction_items')->insertOrIgnore($transactionItems);

        echo "Data dummy transaksi berhasil ditambahkan!\n";
    }
}
