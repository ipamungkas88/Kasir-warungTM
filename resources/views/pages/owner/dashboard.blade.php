<x-sidebar-layout>
  <x-slot:title>Dashboard Owner - Warung TM</x-slot:title>

  <div class="mx-auto max-w-7xl">
    <div class="py-6">
      <!-- Header -->
      <div class="mx-auto max-w-none">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Dashboard Owner</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Ringkasan penjualan dan analisis bisnis</p>
      </div>

      <!-- Statistics Cards -->
      <div class="mx-auto max-w-none mt-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
          <!-- Daily Sales -->
          <div class="bg-white overflow-hidden shadow rounded-lg dark:bg-gray-800">
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
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                      Penjualan Hari Ini</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white">Rp
                      {{ number_format($dailySales, 0, ',', '.') }}</dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>

          <!-- Daily Transactions -->
          <div class="bg-white overflow-hidden shadow rounded-lg dark:bg-gray-800">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0.621 0 1.125-.504 1.125-1.125V9.375c0-.621.504-1.125 1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                  </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                      Transaksi Hari Ini</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white">
                      {{ $dailyTransactions }}</dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>

          <!-- Monthly Sales -->
          <div class="bg-white overflow-hidden shadow rounded-lg dark:bg-gray-800">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                  </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                      Penjualan Bulan Ini</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white">Rp
                      {{ number_format($thisMonth, 0, ',', '.') }}</dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>

          <!-- Growth -->
          <div class="bg-white overflow-hidden shadow rounded-lg dark:bg-gray-800">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  @php
                    $growth = $lastMonth > 0 ? (($thisMonth - $lastMonth) / $lastMonth) * 100 : 0;
                  @endphp
                  <svg class="h-6 w-6 {{ $growth >= 0 ? 'text-green-600' : 'text-red-600' }}"
                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    @if ($growth >= 0)
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                    @else
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 6L9 12.75l4.286-4.286a11.948 11.948 0 014.306 6.43l.776 2.898m0 0l3.182-5.511m-3.182 5.511l-5.511-3.182" />
                    @endif
                  </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                      Pertumbuhan</dt>
                    <dd
                      class="text-lg font-semibold {{ $growth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                      {{ $growth >= 0 ? '+' : '' }}{{ number_format($growth, 1) }}%
                    </dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Charts and Lists Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
          <!-- Sales Chart -->
          <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-800">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Penjualan 7 Hari
              Terakhir</h3>
            <div class="space-y-3">
              @php $maxSales = collect($weeklyData)->max('sales') @endphp
              @foreach ($weeklyData as $day)
                <div class="flex items-center justify-between">
                  <span
                    class="text-sm text-gray-600 dark:text-gray-400 w-16">{{ $day['date'] }}</span>
                  <div class="flex-1 mx-3">
                    <div class="bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                      @php $percentage = $maxSales > 0 ? ($day['sales'] / $maxSales) * 100 : 0 @endphp
                      <div class="bg-blue-600 h-3 rounded-full" style="width: {{ $percentage }}%">
                      </div>
                    </div>
                  </div>
                  <span class="text-sm font-medium text-gray-900 dark:text-white w-20 text-right">
                    Rp {{ number_format($day['sales'], 0, ',', '.') }}
                  </span>
                </div>
              @endforeach
            </div>
          </div>

          <!-- Popular Items -->
          <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-800">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Menu Terpopuler
              Bulan Ini</h3>
            <div class="space-y-3">
              @forelse($popularItems as $item)
                <div class="flex items-center justify-between py-2">
                  <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                      {{ $item->menu_name }}</p>
                  </div>
                  <div class="text-right">
                    <span
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                      {{ $item->total_sold }} terjual
                    </span>
                  </div>
                </div>
              @empty
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">Belum ada data
                  penjualan</p>
              @endforelse
            </div>
          </div>
        </div>

        <!-- Low Stock Alert -->
        @if ($lowStockItems->count() > 0)
          <div
            class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8 dark:bg-yellow-900/20 dark:border-yellow-600">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                  Peringatan Stok Menipis!
                </h3>
                <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                  <p>{{ $lowStockItems->count() }} item memiliki stok ≤ 10:</p>
                  <ul class="list-disc list-inside mt-1">
                    @foreach ($lowStockItems->take(5) as $item)
                      <li>{{ $item->name }} ({{ $item->stock }} tersisa)</li>
                    @endforeach
                    @if ($lowStockItems->count() > 5)
                      <li>dan {{ $lowStockItems->count() - 5 }} item lainnya</li>
                    @endif
                  </ul>
                </div>
                <div class="mt-3">
                  <a href="{{ route('owner.manajemen-menu') }}"
                    class="text-sm font-medium text-yellow-800 dark:text-yellow-200 hover:text-yellow-600 dark:hover:text-yellow-100">
                    Kelola Stok →
                  </a>
                </div>
              </div>
            </div>
          </div>
        @endif

        <!-- Quick Actions -->
        <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-800">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Aksi Cepat</h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('owner.manajemen-menu') }}"
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
              <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
              </svg>
              Tambah Menu
            </a>

            <a href="{{ route('owner.laporan-penjualan') }}"
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
              <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
              Lihat Laporan
            </a>

            <a href="{{ route('owner.manajemen-pengguna') }}"
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
              <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
              </svg>
              Kelola User
            </a>

            <a href="{{ route('owner.riwayat-transaksi') }}"
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700">
              <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Riwayat Transaksi
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-sidebar-layout>
