<x-sidebar-layout>
  <x-slot:title>Dashboard Kasir - Warung TM</x-slot:title>

  <div class="mx-auto max-w-7xl">
    <div class="py-6">
      <!-- Header -->
      <div class="mx-auto max-w-none">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Dashboard Kasir</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Selamat datang, {{ auth()->user()->name }}!
        </p>
      </div>

      <!-- Stats Cards -->
      <div class="mx-auto max-w-none mt-8">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
          <!-- Transaksi Hari Ini -->
          <div class="overflow-hidden rounded-lg bg-white shadow dark:bg-gray-800">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                  </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate dark:text-gray-400">
                      Transaksi Hari Ini</dt>
                    <dd class="text-lg font-medium text-gray-900 dark:text-white">
                      {{ $todayCount }}</dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>

          <!-- Total Penjualan Hari Ini -->
          <div class="overflow-hidden rounded-lg bg-white shadow dark:bg-gray-800">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate dark:text-gray-400">Total
                      Penjualan Hari Ini</dt>
                    <dd class="text-lg font-medium text-gray-900 dark:text-white">Rp
                      {{ number_format($todayTotal, 0, ',', '.') }}</dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>

          <!-- Total Item Terjual -->
          <div class="overflow-hidden rounded-lg bg-white shadow dark:bg-gray-800">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                  </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate dark:text-gray-400">Total
                      Item Terjual</dt>
                    <dd class="text-lg font-medium text-gray-900 dark:text-white">
                      {{ $todayItems }}</dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content Grid -->
      <div class="mx-auto max-w-none mt-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

          <!-- Transaksi Terbaru -->
          <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-800">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Transaksi Terbaru
            </h3>
            <div class="space-y-4">
              @forelse($recentTransactions as $transaction)
                <div class="border-l-4 border-blue-500 pl-4 py-2">
                  <div class="flex justify-between items-start">
                    <div>
                      <p class="font-semibold text-gray-900 dark:text-white">
                        {{ $transaction->transaction_code }}</p>
                      <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $transaction->created_at->format('H:i') }} -
                        {{ $transaction->items->count() }} item
                      </p>
                      <p class="text-xs text-gray-500 dark:text-gray-500">
                        {{ $transaction->items->pluck('menu_name')->take(2)->join(', ') }}
                        @if ($transaction->items->count() > 2)
                          <span>, +{{ $transaction->items->count() - 2 }} lainnya</span>
                        @endif
                      </p>
                    </div>
                    <div class="text-right">
                      <p class="font-semibold text-green-600">Rp
                        {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
                      <p class="text-xs text-gray-500 dark:text-gray-500">
                        {{ ucfirst($transaction->payment_method) }}</p>
                    </div>
                  </div>
                </div>
              @empty
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">Belum ada transaksi
                  hari ini</p>
              @endforelse
            </div>

            @if ($recentTransactions->count() > 0)
              <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ url('/kasir/riwayat-transaksi') }}"
                  class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                  Lihat Semua Transaksi →
                </a>
              </div>
            @endif
          </div>

          <!-- Menu Populer Hari Ini -->
          <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-800">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Menu Populer Hari
              Ini</h3>
            <div class="space-y-3">
              @forelse($popularItems as $item)
                <div class="flex justify-between items-center py-2">
                  <div>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $item->menu_name }}</p>
                  </div>
                  <div class="text-right">
                    <p class="font-semibold text-blue-600">{{ $item->total_qty }} porsi</p>
                  </div>
                </div>
              @empty
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">Belum ada penjualan
                  hari ini</p>
              @endforelse
            </div>
          </div>

        </div>
      </div>

      <!-- Quick Actions -->
      <div class="mx-auto max-w-none mt-8">
        <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-800">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Aksi Cepat</h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ url('/transaksi') }}"
              class="flex items-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
              <svg class="h-8 w-8 text-blue-600 mr-3" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
              </svg>
              <div>
                <p class="font-semibold text-blue-900 dark:text-blue-100">Transaksi Baru</p>
                <p class="text-sm text-blue-700 dark:text-blue-200">Buat transaksi penjualan</p>
              </div>
            </a>

            <a href="{{ url('/riwayat-transaksi') }}"
              class="flex items-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
              <svg class="h-8 w-8 text-green-600 mr-3" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
              </svg>
              <div>
                <p class="font-semibold text-green-900 dark:text-green-100">Riwayat Transaksi</p>
                <p class="text-sm text-green-700 dark:text-green-200">Lihat riwayat penjualan</p>
              </div>
            </a>

            <div class="flex items-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
              <svg class="h-8 w-8 text-purple-600 mr-3" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
              </svg>
              <div>
                <p class="font-semibold text-purple-900 dark:text-purple-100">Laporan Hari Ini</p>
                <p class="text-sm text-purple-700 dark:text-purple-200">{{ $todayCount }}
                  transaksi</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-sidebar-layout>
