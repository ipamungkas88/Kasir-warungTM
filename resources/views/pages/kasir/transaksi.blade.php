<x-sidebar-layout>
  <x-slot:title>Transaksi - Warung TM</x-slot:title>

  <div class="mx-auto max-w-7xl">
    <div class="py-6">
      <!-- Header -->
      <div class="mx-auto max-w-none">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Transaksi Penjualan</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Pilih menu dan buat transaksi baru</p>
      </div>

      <!-- Main Content -->
      <div class="mx-auto max-w-none mt-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

          <!-- Menu List -->
          <div class="lg:col-span-2">
            <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-800">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Daftar Menu</h3>

              <!-- Category Tabs -->
              <div class="border-b border-gray-200 dark:border-gray-700 mb-4">
                <nav class="-mb-px flex space-x-8">
                  @foreach ($menus as $category => $items)
                    <button onclick="showCategory('{{ strtolower($category) }}')"
                      class="category-tab py-2 px-1 border-b-2 font-medium text-sm {{ $loop->first ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                      data-category="{{ strtolower($category) }}">
                      {{ $category }}
                    </button>
                  @endforeach
                </nav>
              </div>

              <!-- Menu Items -->
              @foreach ($menus as $category => $items)
                <div id="category-{{ strtolower($category) }}"
                  class="category-content {{ !$loop->first ? 'hidden' : '' }}">
                  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($items as $menu)
                      <div
                        class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow cursor-pointer menu-item"
                        onclick="addToCart({{ $menu->id }}, '{{ $menu->name }}', {{ $menu->price }})">
                        <div class="flex flex-col h-full">
                          <div class="flex-1">
                            <h4 class="font-semibold text-gray-900 dark:text-white">
                              {{ $menu->name }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                              {{ $menu->description }}</p>
                          </div>
                          <div class="mt-3 flex justify-between items-center">
                            <span class="text-lg font-bold text-green-600">Rp
                              {{ number_format($menu->price, 0, ',', '.') }}</span>
                            <button
                              class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                              + Tambah
                            </button>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <!-- Cart / Order Summary -->
          <div class="lg:col-span-1">
            <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-800 sticky top-4">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pesanan</h3>

              <!-- Cart Items -->
              <div id="cart-items" class="space-y-3 max-h-64 overflow-y-auto">
                <p class="text-gray-500 dark:text-gray-400 text-center py-4" id="empty-cart">Belum
                  ada item</p>
              </div>

              <!-- Order Summary -->
              <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center mb-2">
                  <span class="text-gray-600 dark:text-gray-400">Total Item:</span>
                  <span class="font-semibold text-gray-900 dark:text-white"
                    id="total-items">0</span>
                </div>
                <div class="flex justify-between items-center mb-4">
                  <span class="text-lg font-semibold text-gray-900 dark:text-white">Total:</span>
                  <span class="text-lg font-bold text-green-600" id="total-amount">Rp 0</span>
                </div>

                <!-- Payment Method -->
                <div class="mb-4">
                  <label
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Metode
                    Pembayaran</label>
                  <select id="payment-method"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="cash">Tunai</option>
                    <option value="card">Kartu</option>
                    <option value="digital">Digital</option>
                  </select>
                </div>

                <!-- Paid Amount -->
                <div class="mb-4">
                  <label
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jumlah
                    Bayar</label>
                  <input type="number" id="paid-amount"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    placeholder="0" min="0" step="1000">
                </div>

                <!-- Change -->
                <div class="mb-4 hidden" id="change-section">
                  <div
                    class="flex justify-between items-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <span class="text-green-700 dark:text-green-300">Kembalian:</span>
                    <span class="font-bold text-green-700 dark:text-green-300" id="change-amount">Rp
                      0</span>
                  </div>
                </div>

                <!-- Notes -->
                <div class="mb-4">
                  <label
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan
                    (Opsional)</label>
                  <textarea id="notes" rows="2"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                    placeholder="Tambahkan catatan..."></textarea>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-2">
                  <button id="process-order"
                    class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg font-semibold disabled:bg-gray-400 disabled:cursor-not-allowed"
                    disabled onclick="processOrder()">
                    Proses Pesanan
                  </button>
                  <button onclick="clearCart()"
                    class="w-full bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg">
                    Bersihkan
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Success Modal -->
  <div id="success-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-50"></div>
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full relative">
        <div class="text-center">
          <svg class="mx-auto h-12 w-12 text-green-600 mb-4" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Transaksi Berhasil!
          </h3>
          <p class="text-gray-600 dark:text-gray-400 mb-4" id="transaction-code"></p>
          <button onclick="closeModal()"
            class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg">
            OK
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    let cart = [];
    let totalAmount = 0;
    let totalItems = 0;

    function showCategory(category) {
      // Hide all category contents
      document.querySelectorAll('.category-content').forEach(el => el.classList.add('hidden'));
      // Show selected category
      document.getElementById(`category-${category}`).classList.remove('hidden');

      // Update tab states
      document.querySelectorAll('.category-tab').forEach(tab => {
        tab.classList.remove('border-blue-500', 'text-blue-600');
        tab.classList.add('border-transparent', 'text-gray-500');
      });
      document.querySelector(`[data-category="${category}"]`).classList.add('border-blue-500',
        'text-blue-600');
      document.querySelector(`[data-category="${category}"]`).classList.remove('border-transparent',
        'text-gray-500');
    }

    function addToCart(menuId, menuName, menuPrice) {
      const existingItem = cart.find(item => item.menu_id === menuId);

      if (existingItem) {
        existingItem.quantity += 1;
        existingItem.subtotal = existingItem.quantity * menuPrice;
      } else {
        cart.push({
          menu_id: menuId,
          menu_name: menuName,
          menu_price: menuPrice,
          quantity: 1,
          subtotal: menuPrice
        });
      }

      updateCartDisplay();
    }

    function removeFromCart(menuId) {
      cart = cart.filter(item => item.menu_id !== menuId);
      updateCartDisplay();
    }

    function updateQuantity(menuId, change) {
      const item = cart.find(item => item.menu_id === menuId);
      if (item) {
        item.quantity += change;
        if (item.quantity <= 0) {
          removeFromCart(menuId);
        } else {
          item.subtotal = item.quantity * item.menu_price;
          updateCartDisplay();
        }
      }
    }

    function updateCartDisplay() {
      const cartContainer = document.getElementById('cart-items');
      const emptyCart = document.getElementById('empty-cart');

      if (cart.length === 0) {
        cartContainer.innerHTML =
          '<p class="text-gray-500 dark:text-gray-400 text-center py-4" id="empty-cart">Belum ada item</p>';
        totalAmount = 0;
        totalItems = 0;
      } else {
        let cartHTML = '';
        totalAmount = 0;
        totalItems = 0;

        cart.forEach(item => {
          totalAmount += item.subtotal;
          totalItems += item.quantity;

          cartHTML += `
            <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded">
              <div class="flex-1">
                <h4 class="font-medium text-gray-900 dark:text-white text-sm">${item.menu_name}</h4>
                <p class="text-xs text-gray-600 dark:text-gray-400">Rp ${item.menu_price.toLocaleString()}</p>
              </div>
              <div class="flex items-center space-x-2">
                <button onclick="updateQuantity(${item.menu_id}, -1)" class="bg-red-500 hover:bg-red-600 text-white w-6 h-6 rounded text-xs">-</button>
                <span class="text-sm font-semibold min-w-[20px] text-center">${item.quantity}</span>
                <button onclick="updateQuantity(${item.menu_id}, 1)" class="bg-green-500 hover:bg-green-600 text-white w-6 h-6 rounded text-xs">+</button>
              </div>
            </div>
          `;
        });

        cartContainer.innerHTML = cartHTML;
      }

      document.getElementById('total-items').textContent = totalItems;
      document.getElementById('total-amount').textContent = `Rp ${totalAmount.toLocaleString()}`;
      document.getElementById('process-order').disabled = cart.length === 0;

      calculateChange();
    }

    function calculateChange() {
      const paidAmount = parseFloat(document.getElementById('paid-amount').value) || 0;
      const change = paidAmount - totalAmount;

      const changeSection = document.getElementById('change-section');
      const changeAmountEl = document.getElementById('change-amount');

      if (paidAmount > 0 && change >= 0) {
        changeSection.classList.remove('hidden');
        changeAmountEl.textContent = `Rp ${change.toLocaleString()}`;
      } else {
        changeSection.classList.add('hidden');
      }
    }

    function clearCart() {
      cart = [];
      updateCartDisplay();
      document.getElementById('paid-amount').value = '';
      document.getElementById('notes').value = '';
      document.getElementById('change-section').classList.add('hidden');
    }

    function processOrder() {
      const paidAmount = parseFloat(document.getElementById('paid-amount').value) || 0;
      const paymentMethod = document.getElementById('payment-method').value;
      const notes = document.getElementById('notes').value;

      if (paidAmount < totalAmount) {
        alert('Jumlah bayar tidak cukup!');
        return;
      }

      const orderData = {
        items: cart,
        payment_method: paymentMethod,
        paid_amount: paidAmount,
        notes: notes,
        _token: '{{ csrf_token() }}'
      };

      fetch('{{ route('kasir.store-transaction') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify(orderData)
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            document.getElementById('transaction-code').textContent =
              `Kode Transaksi: ${data.transaction.transaction_code}`;
            document.getElementById('success-modal').classList.remove('hidden');
            clearCart();
          } else {
            alert('Gagal menyimpan transaksi: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Terjadi kesalahan saat menyimpan transaksi');
        });
    }

    function closeModal() {
      document.getElementById('success-modal').classList.add('hidden');
    }

    // Event listeners
    document.getElementById('paid-amount').addEventListener('input', calculateChange);
  </script>
</x-sidebar-layout>
