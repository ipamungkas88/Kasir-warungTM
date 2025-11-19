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
                        <button type="button"
                          onclick="showTransactionDetail({{ $transaction->id }})"
                          data-transaction-id="{{ $transaction->id }}"
                          class="detail-btn text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 cursor-pointer">
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
      console.log('showTransactionDetail called with ID:', transactionId);

      // Check if modal element exists
      const modal = document.getElementById('detail-modal');
      if (!modal) {
        console.error('Modal element not found');
        alert('Modal tidak ditemukan. Silakan refresh halaman.');
        return;
      }

      modal.classList.remove('hidden');

      // Show loading state
      const modalContent = document.getElementById('modal-content');
      if (!modalContent) {
        console.error('Modal content element not found');
        return;
      }

      modalContent.innerHTML = `
        <div class="flex items-center justify-center p-8">
          <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
          <span class="ml-3 text-gray-600 dark:text-gray-400">Memuat data transaksi...</span>
        </div>
      `;

      console.log('Fetching transaction detail for ID:', transactionId);

      fetch(`/owner/transaksi/${transactionId}/detail`)
        .then(response => {
          console.log('Response status:', response.status);
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          return response.json();
        })
        .then(data => {
          console.log('Response data:', data);
          if (data.success) {
            displayTransactionDetail(data.transaction);
          } else {
            document.getElementById('modal-content').innerHTML = `
              <div class="text-center p-8">
                <svg class="mx-auto h-12 w-12 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Gagal memuat data</h3>
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">${data.message || 'Error loading transaction detail'}</p>
                <button onclick="showTransactionDetail(${transactionId})" class="mt-3 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                  Coba Lagi
                </button>
              </div>
            `;
          }
        })
        .catch(error => {
          console.error('Fetch error:', error);
          document.getElementById('modal-content').innerHTML = `
            <div class="text-center p-8">
              <svg class="mx-auto h-12 w-12 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Koneksi Bermasalah</h3>
              <p class="mt-1 text-sm text-red-600 dark:text-red-400">Tidak dapat terhubung ke server. Silakan coba lagi.</p>
              <p class="mt-1 text-xs text-gray-500">${error.message}</p>
              <button onclick="showTransactionDetail(${transactionId})" class="mt-3 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                Coba Lagi
              </button>
            </div>
          `;
        });
    }

    function displayTransactionDetail(transaction) {
      console.log('displayTransactionDetail called with:', transaction);

      const modalContent = document.getElementById('modal-content');
      if (!modalContent) {
        console.error('Modal content element not found');
        return;
      }

      let itemsHTML = '';
      if (transaction.items && transaction.items.length > 0) {
        transaction.items.forEach(item => {
          const menuName = item.menu?.name || 'Item tidak tersedia';
          const price = parseFloat(item.price) || 0;
          const subtotal = parseFloat(item.subtotal) || (item.quantity * price);

          itemsHTML += `
            <tr class="border-b border-gray-200 dark:border-gray-700">
              <td class="py-3 px-3 text-gray-900 dark:text-white">${menuName}</td>
              <td class="py-3 px-3 text-center text-gray-900 dark:text-white">${item.quantity}</td>
              <td class="py-3 px-3 text-right text-gray-900 dark:text-white">Rp ${price.toLocaleString('id-ID')}</td>
              <td class="py-3 px-3 text-right font-semibold text-gray-900 dark:text-white">Rp ${subtotal.toLocaleString('id-ID')}</td>
            </tr>
          `;
        });
      } else {
        itemsHTML = `
          <tr>
            <td colspan="4" class="py-4 text-center text-gray-500 dark:text-gray-400">
              Tidak ada item dalam transaksi ini
            </td>
          </tr>
        `;
      }

      const transactionCode = transaction.transaction_code || `TRX-${transaction.id}`;
      const createdDate = new Date(transaction.created_at).toLocaleString('id-ID', {
        dateStyle: 'full',
        timeStyle: 'short'
      });
      const kasirName = transaction.user?.name || 'Tidak diketahui';
      const kasirRole = transaction.user?.role || 'kasir';
      const paymentMethod = transaction.payment_method || 'cash';
      const totalAmount = parseFloat(transaction.total_amount) || 0;
      const paidAmount = parseFloat(transaction.paid_amount) || totalAmount;
      const changeAmount = parseFloat(transaction.change_amount) || (paidAmount - totalAmount);

      modalContent.innerHTML = `
        <div class="space-y-6">
          <div class="bg-blue-50 dark:bg-blue-900 rounded-lg p-4">
            <div class="flex justify-between items-center">
              <div>
                <h4 class="text-lg font-semibold text-blue-900 dark:text-blue-100">${transactionCode}</h4>
                <p class="text-sm text-blue-700 dark:text-blue-300">${createdDate}</p>
              </div>
              <div class="text-right">
                <p class="text-sm text-blue-700 dark:text-blue-300">Total Transaksi</p>
                <p class="text-xl font-bold text-blue-900 dark:text-blue-100">Rp ${totalAmount.toLocaleString('id-ID')}</p>
              </div>
            </div>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kasir</label>
              <div class="flex items-center">
                <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center mr-3">
                  <span class="text-xs font-medium text-white">${kasirName.charAt(0).toUpperCase()}</span>
                </div>
                <div>
                  <p class="text-sm font-medium text-gray-900 dark:text-white">${kasirName}</p>
                  <p class="text-xs text-gray-500 dark:text-gray-400 capitalize">${kasirRole}</p>
                </div>
              </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Metode Pembayaran</label>
              <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium ${
                paymentMethod === 'cash' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' :
                paymentMethod === 'qris' ? 'bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100' :
                'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100'
              }">
                ${paymentMethod.toUpperCase()}
              </span>
            </div>
          </div>

          <div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Detail Item Transaksi</h4>
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 overflow-hidden">
              <table class="min-w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                  <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Item</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Qty</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Harga Satuan</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subtotal</th>
                  </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                  ${itemsHTML}
                </tbody>
              </table>
            </div>
          </div>

          <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Ringkasan Pembayaran</h4>
            <div class="space-y-3">
              <div class="flex justify-between items-center">
                <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                <span class="font-medium text-gray-900 dark:text-white">Rp ${totalAmount.toLocaleString('id-ID')}</span>
              </div>
              <div class="flex justify-between items-center">
                <span class="text-gray-600 dark:text-gray-400">Jumlah Dibayar:</span>
                <span class="font-medium text-gray-900 dark:text-white">Rp ${paidAmount.toLocaleString('id-ID')}</span>
              </div>
              <div class="flex justify-between items-center pt-3 border-t border-gray-200 dark:border-gray-600">
                <span class="text-lg font-semibold text-gray-900 dark:text-white">Kembalian:</span>
                <span class="text-lg font-bold ${changeAmount >= 0 ? 'text-green-600' : 'text-red-600'}">Rp ${Math.abs(changeAmount).toLocaleString('id-ID')}</span>
              </div>
            </div>
          </div>

          ${transaction.notes ? `
                    <div>
                      <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Catatan Transaksi</h4>
                      <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg p-4">
                        <p class="text-sm text-yellow-800 dark:text-yellow-200">${transaction.notes}</p>
                      </div>
                    </div>
                    ` : ''}
              
          <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
            <button onclick="closeDetailModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
              Tutup
            </button>
          </div>
        </div>
      `;
    }
    // btton print struk
    //     <button onclick="printTransaction('${transactionCode}')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
    //   <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    //     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
    //   </svg>
    //   Print Struk
    // </button>


    function closeDetailModal() {
      console.log('closeDetailModal called');
      const modal = document.getElementById('detail-modal');
      if (modal) {
        modal.classList.add('hidden');
      } else {
        console.error('Modal element not found for closing');
      }
    }

    function printTransaction(transactionCode) {
      console.log('printTransaction called for:', transactionCode);

      try {
        // Implementasi print struk - bisa dikustomisasi lebih lanjut
        const printWindow = window.open('', '_blank');
        const modalContent = document.getElementById('modal-content');

        if (!modalContent) {
          console.error('Modal content not found for printing');
          alert('Tidak dapat mencetak: konten tidak ditemukan');
          return;
        }

        const content = modalContent.innerHTML;

        printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                  <title>Struk Transaksi - ${transactionCode}</title>
                  <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
                    .content { margin-bottom: 20px; }
                    table { width: 100%; border-collapse: collapse; margin: 10px 0; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    th { background-color: #f5f5f5; }
                    .text-right { text-align: right; }
                    .text-center { text-align: center; }
                    @media print { body { margin: 0; } }
                    button { display: none !important; }
                  </style>
                </head>
                <body>
                  <div class="header">
                    <h2>WARUNG TM</h2>
                    <p>Struk Transaksi</p>
                  </div>
                  <div class="content">
                    ${content.replace(/<button[^>]*>.*?<\/button>/gi, '')}
                  </div>
                  <script>window.onload = function() { window.print(); window.close(); }
  </script>
  </body>

  </html>
  `);

  printWindow.document.close();
  } catch (error) {
  console.error('Print error:', error);
  alert('Terjadi kesalahan saat mencetak: ' + error.message);
  }
  }
  </script>

  <!-- Debug Script -->
  <script>
    // Ensure functions are defined globally
    window.displayTransactionDetail = function(transaction) {
      console.log('displayTransactionDetail called with:', transaction);

      const modalContent = document.getElementById('modal-content');
      if (!modalContent) {
        console.error('Modal content element not found');
        return;
      }

      let itemsHTML = '';
      if (transaction.items && transaction.items.length > 0) {
        transaction.items.forEach(item => {
          const menuName = item.menu?.name || 'Item tidak tersedia';
          const price = parseFloat(item.price) || 0;
          const subtotal = parseFloat(item.subtotal) || (item.quantity * price);

          itemsHTML += `
            <tr class="border-b border-gray-200 dark:border-gray-700">
              <td class="py-3 px-4 text-gray-900 dark:text-white">${menuName}</td>
              <td class="py-3 px-4 text-center text-gray-900 dark:text-white">${item.quantity}</td>
              <td class="py-3 px-4 text-right text-gray-900 dark:text-white">Rp ${price.toLocaleString('id-ID')}</td>
              <td class="py-3 px-4 text-right font-semibold text-gray-900 dark:text-white">Rp ${subtotal.toLocaleString('id-ID')}</td>
            </tr>
          `;
        });
      } else {
        itemsHTML = `
          <tr>
            <td colspan="4" class="py-4 text-center text-gray-500 dark:text-gray-400">
              Tidak ada item dalam transaksi ini
            </td>
          </tr>
        `;
      }

      const transactionCode = transaction.transaction_code || `TRX-${transaction.id}`;
      const createdDate = new Date(transaction.created_at).toLocaleString('id-ID', {
        dateStyle: 'full',
        timeStyle: 'short'
      });
      const kasirName = transaction.user?.name || 'Tidak diketahui';
      const kasirRole = transaction.user?.role || 'kasir';
      const paymentMethod = transaction.payment_method || 'cash';
      const totalAmount = parseFloat(transaction.total_amount) || 0;
      const paidAmount = parseFloat(transaction.paid_amount) || totalAmount;
      const changeAmount = parseFloat(transaction.change_amount) || (paidAmount - totalAmount);

      modalContent.innerHTML = `
        <div class="space-y-6">
          <!-- Header Transaksi -->
          <div class="bg-blue-50 dark:bg-blue-900 rounded-lg p-6">
            <div class="flex justify-between items-center">
              <div>
                <h4 class="text-xl font-bold text-blue-900 dark:text-blue-100">${transactionCode}</h4>
                <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">${createdDate}</p>
              </div>
              <div class="text-right">
                <p class="text-sm text-blue-700 dark:text-blue-300">Total Transaksi</p>
                <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">Rp ${totalAmount.toLocaleString('id-ID')}</p>
              </div>
            </div>
          </div>
          
          <!-- Info Kasir dan Pembayaran -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
              <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Informasi Kasir</h5>
              <div class="flex items-center">
                <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center mr-3">
                  <span class="text-sm font-medium text-white">${kasirName.charAt(0).toUpperCase()}</span>
                </div>
                <div>
                  <p class="text-sm font-medium text-gray-900 dark:text-white">${kasirName}</p>
                  <p class="text-xs text-gray-500 dark:text-gray-400 capitalize">${kasirRole}</p>
                </div>
              </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
              <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Metode Pembayaran</h5>
              <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium ${
                paymentMethod === 'cash' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' :
                paymentMethod === 'qris' ? 'bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100' :
                'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100'
              }">
                ${paymentMethod.toUpperCase()}
              </span>
            </div>
          </div>

          <!-- Detail Items -->
          <div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Detail Item Transaksi</h4>
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 overflow-hidden shadow-sm">
              <table class="min-w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                  <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Item</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Qty</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Harga Satuan</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subtotal</th>
                  </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                  ${itemsHTML}
                </tbody>
              </table>
            </div>
          </div>

          <!-- Ringkasan Pembayaran -->
          <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ringkasan Pembayaran</h4>
            <div class="space-y-3">
              <div class="flex justify-between items-center">
                <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                <span class="font-medium text-gray-900 dark:text-white">Rp ${totalAmount.toLocaleString('id-ID')}</span>
              </div>
              <div class="flex justify-between items-center">
                <span class="text-gray-600 dark:text-gray-400">Jumlah Dibayar:</span>
                <span class="font-medium text-gray-900 dark:text-white">Rp ${paidAmount.toLocaleString('id-ID')}</span>
              </div>
              <div class="flex justify-between items-center pt-3 border-t border-gray-200 dark:border-gray-600">
                <span class="text-lg font-semibold text-gray-900 dark:text-white">Kembalian:</span>
                <span class="text-lg font-bold ${changeAmount >= 0 ? 'text-green-600' : 'text-red-600'}">Rp ${Math.abs(changeAmount).toLocaleString('id-ID')}</span>
              </div>
            </div>
          </div>

          ${transaction.notes ? `
                <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg p-4">
                  <h5 class="text-sm font-semibold text-yellow-800 dark:text-yellow-200 mb-2">Catatan Transaksi</h5>
                  <p class="text-sm text-yellow-700 dark:text-yellow-300">${transaction.notes}</p>
                </div>
                ` : ''}
              
          <!-- Action Buttons -->
          <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
            <button onclick="closeDetailModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md text-sm font-medium transition-colors">
              Tutup
            </button>
          </div>
        </div>
      `;
    };

    // btton print struk
    //     <button onclick="printTransaction('${transactionCode}')" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md text-sm font-medium transition-colors">
    //   <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    //     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
    //   </svg>
    //   Print Struk
    // </button>


    window.showTransactionDetail = function(transactionId) {
      console.log('showTransactionDetail called with ID:', transactionId);

      // Validate input
      if (!transactionId) {
        console.error('No transaction ID provided');
        alert('ID transaksi tidak valid');
        return;
      }

      // Check if modal element exists
      const modal = document.getElementById('detail-modal');
      if (!modal) {
        console.error('Modal element not found');
        alert('Modal tidak ditemukan. Silakan refresh halaman.');
        return;
      }

      modal.classList.remove('hidden');

      // Show loading state
      const modalContent = document.getElementById('modal-content');
      if (!modalContent) {
        console.error('Modal content element not found');
        return;
      }

      modalContent.innerHTML = `
        <div class="flex items-center justify-center p-8">
          <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
          <span class="ml-3 text-gray-600 dark:text-gray-400">Memuat data transaksi...</span>
        </div>
      `;

      console.log('Fetching transaction detail for ID:', transactionId);

      fetch(`/owner/transaksi/${transactionId}/detail`)
        .then(response => {
          console.log('Response status:', response.status);
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          return response.json();
        })
        .then(data => {
          console.log('Response data:', data);
          if (data.success) {
            displayTransactionDetail(data.transaction);
          } else {
            showErrorModal(data.message || 'Error loading transaction detail', transactionId);
          }
        })
        .catch(error => {
          console.error('Fetch error:', error);
          showErrorModal(`Tidak dapat terhubung ke server: ${error.message}`, transactionId);
        });
    };

    window.showErrorModal = function(errorMessage, transactionId) {
      document.getElementById('modal-content').innerHTML = `
        <div class="text-center p-8">
          <svg class="mx-auto h-12 w-12 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Terjadi Kesalahan</h3>
          <p class="mt-1 text-sm text-red-600 dark:text-red-400">${errorMessage}</p>
          <div class="mt-4 space-x-2">
            <button onclick="showTransactionDetail(${transactionId})" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
              Coba Lagi
            </button>
            <button onclick="closeDetailModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm">
              Tutup
            </button>
          </div>
        </div>
      `;
    };

    window.closeDetailModal = function() {
      console.log('closeDetailModal called');
      const modal = document.getElementById('detail-modal');
      if (modal) {
        modal.classList.add('hidden');
      } else {
        console.error('Modal element not found for closing');
      }
    };

    // Debug untuk memastikan semua function tersedia
    document.addEventListener('DOMContentLoaded', function() {
      console.log('=== DEBUGGING MODAL DETAIL TRANSAKSI ===');
      console.log('showTransactionDetail function available:', typeof window
        .showTransactionDetail);
      console.log('displayTransactionDetail function available:', typeof window
        .displayTransactionDetail);
      console.log('closeDetailModal function available:', typeof window.closeDetailModal);

      // Check if modal exists
      const modal = document.getElementById('detail-modal');
      console.log('Modal element found:', modal ? 'Yes' : 'No');

      const modalContent = document.getElementById('modal-content');
      console.log('Modal content element found:', modalContent ? 'Yes' : 'No');

      // Test onclick events
      const detailButtons = document.querySelectorAll('[onclick*="showTransactionDetail"]');
      console.log('Detail buttons found:', detailButtons.length);

      // Add click event listeners as fallback
      const detailBtns = document.querySelectorAll('.detail-btn');
      console.log('Detail buttons with class found:', detailBtns.length);

      detailBtns.forEach(function(btn, index) {
        // Remove any existing event listeners
        btn.removeEventListener('click', handleDetailClick);

        // Add new event listener
        btn.addEventListener('click', handleDetailClick);

        console.log(`Added event listener to button ${index + 1}`);
      });

      function handleDetailClick(e) {
        e.preventDefault();
        e.stopPropagation();

        console.log('Button clicked via event listener');
        const transactionId = this.getAttribute('data-transaction-id');
        console.log('Transaction ID from data attribute:', transactionId);

        if (transactionId) {
          if (typeof window.showTransactionDetail === 'function') {
            window.showTransactionDetail(transactionId);
          } else {
            console.error('showTransactionDetail function not available');
            alert('Function tidak tersedia. Silakan refresh halaman.');
          }
        } else {
          console.error('No transaction ID found');
          alert('ID transaksi tidak ditemukan.');
        }
      }

      // Test manual function call
      window.testDetailFunction = function(id) {
        console.log('Manual test with ID:', id);
        if (typeof window.showTransactionDetail === 'function') {
          window.showTransactionDetail(id);
        } else {
          console.error('showTransactionDetail function not found');
        }
      };
    });

    // Fallback untuk window onload
    window.addEventListener('load', function() {
      console.log('Window loaded');
    });
  </script>
</x-sidebar-layout>
