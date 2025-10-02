<x-sidebar-layout>
  <x-slot:title>Laporan Penjualan - Warung TM</x-slot:title>

  <div class="mx-auto max-w-7xl">
    <div class="py-6">
      <!-- Header -->
      <div class="mx-auto max-w-none">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Laporan Penjualan</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Analisis penjualan harian, mingguan, dan
          bulanan</p>
      </div>

      <!-- Filter Controls -->
      <div class="mx-auto max-w-none mt-8">
        <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-800 mb-6">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Filter Laporan</h3>

          <form method="GET" action="{{ route('owner.laporan-penjualan') }}"
            class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Period -->
            <div>
              <label for="period"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Periode</label>
              <select name="period" id="period" onchange="toggleDateFields()"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="daily"
                  {{ request('period', 'daily') === 'daily' ? 'selected' : '' }}>Harian</option>
                <option value="weekly" {{ request('period') === 'weekly' ? 'selected' : '' }}>
                  Mingguan</option>
                <option value="monthly" {{ request('period') === 'monthly' ? 'selected' : '' }}>
                  Bulanan</option>
                <option value="custom" {{ request('period') === 'custom' ? 'selected' : '' }}>Kustom
                </option>
              </select>
            </div>

            <!-- Date From -->
            <div id="date-from-field"
              class="{{ request('period') !== 'custom' ? 'opacity-50' : '' }}">
              <label for="start_date"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dari
                Tanggal</label>
              <input type="date" name="start_date" id="start_date"
                value="{{ request('start_date') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                {{ request('period') !== 'custom' ? 'disabled' : '' }}>
            </div>

            <!-- Date To -->
            <div id="date-to-field"
              class="{{ request('period') !== 'custom' ? 'opacity-50' : '' }}">
              <label for="end_date"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sampai
                Tanggal</label>
              <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                {{ request('period') !== 'custom' ? 'disabled' : '' }}>
            </div>

            <!-- Submit Button -->
            <div class="flex items-end">
              <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md font-medium">
                Generate Laporan
              </button>
            </div>
          </form>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
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
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total
                      Penjualan</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white">Rp
                      {{ number_format($totalSales ?? 0, 0, ',', '.') }}</dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>

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
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total
                      Transaksi</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white">
                      {{ $totalTransactions ?? 0 }}</dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>

          <div class="bg-white overflow-hidden shadow rounded-lg dark:bg-gray-800">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                  </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                      Rata-rata Transaksi</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-white">
                      Rp {{ number_format($averageTransaction ?? 0, 0, ',', '.') }}
                    </dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Chart Section -->
        @if (isset($chartData) && !empty($chartData))
          <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-800 mb-8">
            <div class="flex justify-between items-center mb-4">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Grafik Penjualan</h3>
              <div class="flex space-x-2">
                <button onclick="exportPDF()"
                  class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                  <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                  PDF
                </button>
                <button onclick="exportExcel()"
                  class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                  <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                  </svg>
                  Excel
                </button>
              </div>
            </div>
            <div class="space-y-3">
              @php $maxValue = collect($chartData)->max('value') @endphp
              @foreach ($chartData as $data)
                <div class="flex items-center justify-between">
                  <span
                    class="text-sm text-gray-600 dark:text-gray-400 w-20">{{ $data['label'] }}</span>
                  <div class="flex-1 mx-3">
                    <div class="bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                      @php $percentage = $maxValue > 0 ? ($data['value'] / $maxValue) * 100 : 0 @endphp
                      <div
                        class="bg-gradient-to-r from-blue-500 to-blue-600 h-4 rounded-full transition-all duration-300"
                        style="width: {{ $percentage }}%"></div>
                    </div>
                  </div>
                  <span class="text-sm font-medium text-gray-900 dark:text-white w-24 text-right">
                    Rp {{ number_format($data['value'], 0, ',', '.') }}
                  </span>
                </div>
              @endforeach
            </div>
          </div>
        @endif

        <!-- Transaction Table -->
        @if (isset($transactions) && $transactions->count() > 0)
          <div class="bg-white shadow rounded-lg dark:bg-gray-800">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detail Transaksi</h3>
            </div>

            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                  <tr>
                    <th
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                      Kode Transaksi
                    </th>
                    <th
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                      Tanggal
                    </th>
                    <th
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                      Kasir
                    </th>
                    <th
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                      Total
                    </th>
                    <th
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                      Pembayaran
                    </th>
                  </tr>
                </thead>
                <tbody
                  class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                  @foreach ($transactions as $transaction)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                          {{ $transaction->transaction_code }}
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 dark:text-white">
                          {{ $transaction->created_at->format('d/m/Y H:i') }}
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 dark:text-white">
                          {{ $transaction->user->name }}
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">
                          Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <span
                          class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $transaction->payment_method === 'cash'
                            ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100'
                            : ($transaction->payment_method === 'card'
                                ? 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100'
                                : 'bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100') }}">
                          {{ ucfirst($transaction->payment_method) }}
                        </span>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        @endif

        @if (!isset($transactions) || $transactions->count() === 0)
          <div class="bg-white shadow rounded-lg p-12 text-center dark:bg-gray-800">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
              stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0.621 0 1.125-.504 1.125-1.125V9.375c0-.621.504-1.125 1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada data</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
              Silakan pilih periode untuk melihat laporan penjualan.
            </p>
          </div>
        @endif
      </div>
    </div>
  </div>

  <script>
    function toggleDateFields() {
      const period = document.getElementById('period').value;
      const dateFromField = document.getElementById('date-from-field');
      const dateToField = document.getElementById('date-to-field');
      const startDateInput = document.getElementById('start_date');
      const endDateInput = document.getElementById('end_date');

      if (period === 'custom') {
        dateFromField.classList.remove('opacity-50');
        dateToField.classList.remove('opacity-50');
        startDateInput.disabled = false;
        endDateInput.disabled = false;
      } else {
        dateFromField.classList.add('opacity-50');
        dateToField.classList.add('opacity-50');
        startDateInput.disabled = true;
        endDateInput.disabled = true;
      }
    }

    function exportPDF() {
      alert('Fitur export PDF akan segera tersedia');
      // TODO: Implement PDF export
    }

    function exportExcel() {
      alert('Fitur export Excel akan segera tersedia');
      // TODO: Implement Excel export
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
      toggleDateFields();
    });
  </script>
</x-sidebar-layout>
