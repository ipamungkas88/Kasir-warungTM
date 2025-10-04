<x-sidebar-layout>
  <x-slot:title>Riwayat Transaksi - Warung TM</x-slot:title>

  <div class="mx-auto max-w-7xl">
    <div class="py-6">
      <!-- Header -->
      <div class="mx-auto max-w-none">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Riwayat Transaksi</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Lihat semua transaksi dari seluruh kasir</p>
      </div>

      <!-- Filters -->
      <div class="mx-auto max-w-none mt-8">
        <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-800 mb-6">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Filter & Pencarian
          </h3>

          <form method="GET" action="{{ route('owner.riwayat-transaksi') }}"
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="md:col-span-2 lg:col-span-1">
              <label for="search"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cari Kode
                Transaksi</label>
              <input type="text" name="search" id="search" value="{{ request('search') }}"
                class="mt-1 block w-full px-3 py-1.5 min-w-[200px] rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                placeholder="Masukkan kode transaksi">
            </div>

            <!-- Date From -->
            <div>
              <label for="date_from"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Dari
                Tanggal</label>
              <input type="date" name="date_from" id="date_from"
                value="{{ request('date_from') }}"
                class="mt-1 block w-full px-3 py-1.5 min-w-[160px] rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <!-- Date To -->
            <div>
              <label for="date_to"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sampai
                Tanggal</label>
              <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                class="mt-1 block w-full px-3 py-1.5 min-w-[160px] rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <!-- Submit Button -->
            <div class="flex items-end">
              <button type="submit"
                class="w-full min-w-[120px] bg-blue-600 hover:bg-blue-700 text-white py-1.5 px-3 rounded-md font-medium">
                Filter
              </button>
            </div>
          </form>

          <!-- Quick Filters -->
          <div class="mt-4 flex flex-wrap gap-2">
            <a href="{{ route('owner.riwayat-transaksi', ['date_from' => today()->format('Y-m-d'), 'date_to' => today()->format('Y-m-d')]) }}"
              class="bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 px-3 py-1 rounded text-sm">
              Hari Ini
            </a>
            <a href="{{ route('owner.riwayat-transaksi', ['date_from' => today()->subDays(6)->format('Y-m-d'), 'date_to' => today()->format('Y-m-d')]) }}"
              class="bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 px-3 py-1 rounded text-sm">
              7 Hari Terakhir
            </a>
            <a href="{{ route('owner.riwayat-transaksi', ['date_from' => today()->startOfMonth()->format('Y-m-d'), 'date_to' => today()->format('Y-m-d')]) }}"
              class="bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 px-3 py-1 rounded text-sm">
              Bulan Ini
            </a>
            <a href="{{ route('owner.riwayat-transaksi') }}"
              class="bg-red-100 hover:bg-red-200 dark:bg-red-700 dark:hover:bg-red-600 text-red-700 dark:text-red-300 px-3 py-1 rounded text-sm">
              Reset Filter
            </a>
          </div>
        </div>

        <!-- Statistics Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
          <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-800">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24"
                  stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total
                    Transaksi</dt>
                  <dd class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ $transactions->total() ?? 0 }}</dd>
                </dl>
              </div>
            </div>
          </div>

          <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-800">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24"
                  stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total
                    Pendapatan</dt>
                  <dd class="text-lg font-semibold text-gray-900 dark:text-white">Rp
                    {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</dd>
                </dl>
              </div>
            </div>
          </div>

          <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-800">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <svg class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24"
                  stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                </svg>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                    Rata-rata per Transaksi</dt>
                  <dd class="text-lg font-semibold text-gray-900 dark:text-white">
                    @if (isset($transactions) && $transactions->count() > 0)
                      Rp {{ number_format($totalRevenue / $transactions->count(), 0, ',', '.') }}
                    @else
                      Rp 0
                    @endif
                  </dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <!-- Transaction List -->
        <div class="bg-white shadow rounded-lg dark:bg-gray-800">
          <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Transaksi</h3>
          </div>

          @if (isset($transactions) && $transactions->count() > 0)
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
                      Items
                    </th>
                    <th
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                      Pembayaran
                    </th>
                    <th
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                      Aksi
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
                        <div class="flex items-center">
                          <div class="flex-shrink-0 h-8 w-8">
                            <div
                              class="h-8 w-8 rounded-full bg-{{ $transaction->user->role === 'owner' ? 'purple' : 'blue' }}-500 flex items-center justify-center">
                              <span
                                class="text-xs font-medium text-white">{{ strtoupper(substr($transaction->user->name, 0, 1)) }}</span>
                            </div>
                          </div>
                          <div class="ml-3">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                              {{ $transaction->user->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                              {{ ucfirst($transaction->user->role) }}</div>
                          </div>
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">
                          Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 dark:text-white">
                          {{ $transaction->total_items }}
                          item{{ $transaction->total_items > 1 ? 's' : '' }}
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
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="showTransactionDetail({{ $transaction->id }})"
                          class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                          Detail
                        </button>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
              {{ $transactions->appends(request()->query())->links() }}
            </div>
          @else
            <div class="px-6 py-12 text-center">
              <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0.621 0 1.125-.504 1.125-1.125V9.375c0-.621.504-1.125 1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
              </svg>
              <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada
                transaksi</h3>
              <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Belum ada transaksi yang sesuai dengan kriteria pencarian.
              </p>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Transaction Detail Modal -->
  <div id="detail-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-50" onclick="closeDetailModal()"></div>
      <div
        class="bg-white dark:bg-gray-800 rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto relative">
        <div
          class="sticky top-0 bg-white dark:bg-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
          <div class="flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detail Transaksi</h3>
            <button onclick="closeDetailModal()"
              class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
              <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>

        <div id="modal-content" class="p-6">
          <!-- Content will be loaded here -->
        </div>
      </div>
    </div>
  </div>

  <script>
    function showTransactionDetail(transactionId) {
      document.getElementById('detail-modal').classList.remove('hidden');

      fetch(`/owner/transaksi/${transactionId}/detail`)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            displayTransactionDetail(data.transaction);
          } else {
            document.getElementById('modal-content').innerHTML =
              '<p class="text-red-600">Error loading transaction detail</p>';
          }
        })
        .catch(error => {
          console.error('Error:', error);
          document.getElementById('modal-content').innerHTML =
            '<p class="text-red-600">Error loading transaction detail</p>';
        });
    }

    function displayTransactionDetail(transaction) {
      const modalContent = document.getElementById('modal-content');

      let itemsHTML = '';
      transaction.items.forEach(item => {
        itemsHTML += `
          <tr class="border-b border-gray-200 dark:border-gray-700">
            <td class="py-2 text-gray-900 dark:text-white">${item.menu.name}</td>
            <td class="py-2 text-center text-gray-900 dark:text-white">${item.quantity}</td>
            <td class="py-2 text-right text-gray-900 dark:text-white">Rp ${item.price.toLocaleString()}</td>
            <td class="py-2 text-right font-semibold text-gray-900 dark:text-white">Rp ${item.subtotal.toLocaleString()}</td>
          </tr>
        `;
      });

      modalContent.innerHTML = `
        <div class="space-y-6">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kode Transaksi</label>
              <p class="mt-1 text-sm text-gray-900 dark:text-white font-mono">${transaction.transaction_code}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal</label>
              <p class="mt-1 text-sm text-gray-900 dark:text-white">${new Date(transaction.created_at).toLocaleString('id-ID')}</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kasir</label>
              <p class="mt-1 text-sm text-gray-900 dark:text-white">${transaction.user.name} (${transaction.user.role})</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Metode Pembayaran</label>
              <p class="mt-1 text-sm text-gray-900 dark:text-white capitalize">${transaction.payment_method}</p>
            </div>
          </div>

          <div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Item Transaksi</h4>
            <div class="overflow-x-auto">
              <table class="min-w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                  <tr>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Item</th>
                    <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Qty</th>
                    <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Harga</th>
                    <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  ${itemsHTML}
                </tbody>
              </table>
            </div>
          </div>

          <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
            <div class="space-y-2">
              <div class="flex justify-between">
                <span class="text-gray-600 dark:text-gray-400">Total:</span>
                <span class="font-semibold text-gray-900 dark:text-white">Rp ${transaction.total_amount.toLocaleString()}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-600 dark:text-gray-400">Dibayar:</span>
                <span class="text-gray-900 dark:text-white">Rp ${transaction.paid_amount.toLocaleString()}</span>
              </div>
              <div class="flex justify-between border-t border-gray-200 dark:border-gray-700 pt-2">
                <span class="text-gray-600 dark:text-gray-400">Kembalian:</span>
                <span class="font-semibold text-green-600">Rp ${transaction.change_amount.toLocaleString()}</span>
              </div>
            </div>
          </div>

          ${transaction.notes ? `
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan</label>
                <p class="mt-1 text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 p-3 rounded">${transaction.notes}</p>
              </div>
              ` : ''}
        </div>
      `;
    }

    function closeDetailModal() {
      document.getElementById('detail-modal').classList.add('hidden');
    }
  </script>
</x-sidebar-layout>
