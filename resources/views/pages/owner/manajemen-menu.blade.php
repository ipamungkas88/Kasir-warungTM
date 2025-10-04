<x-sidebar-layout>
  <x-slot:title>Manajemen Menu - Warung TM</x-slot:title>

  <div class="mx-auto max-w-7xl">
    <div class="py-6">
      <!-- Header -->
      <div class="mx-auto max-w-none">
        <div class="flex justify-between items-center">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Manajemen Menu</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Kelola menu dan stok warung</p>
          </div>
          <button onclick="openAddModal()"
            class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-semibold">
            + Tambah Menu
          </button>
        </div>
      </div>

      <!-- Success/Error Messages -->
      @if (session('success'))
        <div id="success-alert" class="mx-auto max-w-none mt-6">
          <div
            class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded dark:bg-green-900/20 dark:border-green-800 dark:text-green-300 flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="closeAlert('success-alert')"
              class="ml-4 text-green-500 hover:text-green-700">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                  clip-rule="evenodd"></path>
              </svg>
            </button>
          </div>
        </div>
      @endif

      @if (session('error'))
        <div id="error-alert" class="mx-auto max-w-none mt-6">
          <div
            class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded dark:bg-red-900/20 dark:border-red-800 dark:text-red-300 flex justify-between items-center">
            <span>{{ session('error') }}</span>
            <button onclick="closeAlert('error-alert')"
              class="ml-4 text-red-500 hover:text-red-700">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                  clip-rule="evenodd"></path>
              </svg>
            </button>
          </div>
        </div>
      @endif

      <!-- Menu Table -->
      <div class="mx-auto max-w-none mt-8">
        <div class="bg-white shadow rounded-lg dark:bg-gray-800">
          <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Menu</h3>
          </div>

          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
              <thead class="bg-gray-50 dark:bg-gray-900">
                <tr>
                  <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    Menu
                  </th>
                  <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    Kategori
                  </th>
                  <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    Harga
                  </th>
                  <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    Stok
                  </th>
                  <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    Status
                  </th>
                  <th
                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                    Aksi
                  </th>
                </tr>
              </thead>
              <tbody
                class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                @forelse($menus as $menu)
                  <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4">
                      <div>
                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                          {{ $menu->name }}</div>
                        @if ($menu->description)
                          <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ Str::limit($menu->description, 50) }}</div>
                        @endif
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span
                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $menu->category === 'Makanan'
                            ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100'
                            : ($menu->category === 'Minuman'
                                ? 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100'
                                : 'bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100') }}">
                        {{ $menu->category }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm font-semibold text-gray-900 dark:text-white">
                        Rp {{ number_format($menu->price, 0, ',', '.') }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900 dark:text-white">
                        <span
                          class="font-medium {{ $menu->stock <= 10 ? 'text-red-600' : 'text-gray-900 dark:text-white' }}">
                          {{ $menu->stock }}
                        </span>
                        @if ($menu->stock <= 10)
                          <span class="ml-1 text-xs text-red-500">(Low!)</span>
                        @endif
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span
                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $menu->is_available ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' }}">
                        {{ $menu->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                      </span>
                    </td>
                    <td
                      class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                      <button onclick="openEditModal({{ $menu }})"
                        class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                        Edit
                      </button>
                      <button onclick="deleteMenu({{ $menu->id }}, '{{ $menu->name }}')"
                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                        Hapus
                      </button>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                      </svg>
                      <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Belum ada
                        menu</h3>
                      <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Mulai dengan menambahkan menu pertama.
                      </p>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          @if ($menus->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
              {{ $menus->links() }}
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Add/Edit Menu Modal -->
  <div id="menu-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
      <div class="fixed inset-0 bg-transparent backdrop-blur-sm" onclick="closeModal()"></div>
      <div class="bg-white dark:bg-gray-800 rounded-lg max-w-md w-full relative">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
          <h3 id="modal-title" class="text-lg font-semibold text-gray-900 dark:text-white">Tambah
            Menu</h3>
        </div>

        <form id="menu-form" method="POST">
          @csrf
          <div id="method-field"></div>

          <div class="p-6 space-y-5">
            <!-- Name -->
            <div>
              <label for="name"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama
                Menu</label>
              <input type="text" name="name" id="name" required
                class="mt-1 block w-full px-3 py-1.5 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <!-- Description -->
            <div>
              <label for="description"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi</label>
              <textarea name="description" id="description" rows="3"
                class="mt-1 block w-full px-3 py-1.5 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
            </div>

            <!-- Category -->
            <div>
              <label for="category"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori</label>
              <select name="category" id="category" required
                class="mt-1 block w-full px-3 py-1.5 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="">Pilih kategori</option>
                <option value="Makanan">Makanan</option>
                <option value="Minuman">Minuman</option>
                <option value="Snack">Snack</option>
              </select>
            </div>

            <!-- Price and Stock Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <!-- Price -->
              <div>
                <label for="price"
                  class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Harga</label>
                <input type="number" name="price" id="price" min="0"
                  step="100" required
                  class="mt-1 block w-full px-3 py-1.5 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
              </div>

              <!-- Stock -->
              <div>
                <label for="stock"
                  class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Stok</label>
                <input type="number" name="stock" id="stock" min="0" required
                  class="mt-1 block w-full px-3 py-1.5 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
              </div>
            </div>

            <!-- Availability (only for edit) -->
            <div id="availability-field" class="hidden">
              <label class="flex items-center">
                <input type="checkbox" name="is_available" id="is_available" value="1"
                  class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Menu tersedia</span>
              </label>
            </div>
          </div>

          <div
            class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3">
            <button type="button" onclick="closeModal()"
              class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
              Batal
            </button>
            <button type="submit"
              class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
              Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    function openAddModal() {
      document.getElementById('modal-title').textContent = 'Tambah Menu';
      document.getElementById('menu-form').action = '{{ route('owner.store-menu') }}';
      document.getElementById('method-field').innerHTML = '';
      document.getElementById('availability-field').classList.add('hidden');

      // Clear form
      document.getElementById('menu-form').reset();

      document.getElementById('menu-modal').classList.remove('hidden');
    }

    function openEditModal(menu) {
      document.getElementById('modal-title').textContent = 'Edit Menu';
      document.getElementById('menu-form').action = `/owner/menu/${menu.id}`;
      document.getElementById('method-field').innerHTML = '@method('PUT')';
      document.getElementById('availability-field').classList.remove('hidden');

      // Populate form
      document.getElementById('name').value = menu.name;
      document.getElementById('description').value = menu.description || '';
      document.getElementById('category').value = menu.category;
      document.getElementById('price').value = menu.price;
      document.getElementById('stock').value = menu.stock;
      document.getElementById('is_available').checked = menu.is_available;

      document.getElementById('menu-modal').classList.remove('hidden');
    }

    function closeModal() {
      document.getElementById('menu-modal').classList.add('hidden');
    }

    let currentMenuId = null;
    let currentMenuName = null;

    function deleteMenu(menuId, menuName = 'item ini') {
      currentMenuId = menuId;
      currentMenuName = menuName;
      document.getElementById('delete-menu-name').textContent = menuName;
      document.getElementById('delete-modal').classList.remove('hidden');
    }

    function closeDeleteModal() {
      document.getElementById('delete-modal').classList.add('hidden');
      currentMenuId = null;
      currentMenuName = null;
    }

    function confirmDeleteMenu() {
      if (!currentMenuId) return;

      const form = document.createElement('form');
      form.method = 'POST';
      form.action = `/owner/menu/${currentMenuId}`;
      form.innerHTML = `
        @csrf
        @method('DELETE')
      `;
      document.body.appendChild(form);
      form.submit();
    }

    // Close modal when clicking outside
    document.getElementById('menu-modal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeModal();
      }
    });

    // Auto-hide alerts after 10 seconds
    function autoHideAlerts() {
      const successAlert = document.getElementById('success-alert');
      const errorAlert = document.getElementById('error-alert');

      if (successAlert) {
        setTimeout(function() {
          closeAlert('success-alert');
        }, 10000); // 10 seconds
      }

      if (errorAlert) {
        setTimeout(function() {
          closeAlert('error-alert');
        }, 10000); // 10 seconds
      }
    }

    // Function to close alert manually or automatically
    function closeAlert(alertId) {
      const alert = document.getElementById(alertId);
      if (alert) {
        alert.style.transition = 'opacity 0.3s ease-out';
        alert.style.opacity = '0';
        setTimeout(function() {
          alert.remove();
        }, 300);
      }
    }

    // Initialize auto-hide on page load
    document.addEventListener('DOMContentLoaded', function() {
      autoHideAlerts();
    });
  </script>

  <!-- Delete Confirmation Modal -->
  <div id="delete-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
      <div class="fixed inset-0 bg-transparent backdrop-blur-sm" onclick="closeDeleteModal()">
      </div>
      <div class="bg-white dark:bg-gray-800 rounded-lg max-w-md w-full relative shadow-xl">
        <div class="p-6 text-center">
          <div
            class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24"
              stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Hapus Menu</h3>
          <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
            Apakah Anda yakin ingin menghapus menu <span id="delete-menu-name"
              class="font-semibold text-gray-900 dark:text-white"></span>?
            Tindakan ini tidak dapat dibatalkan.
          </p>
          <div class="flex gap-3 justify-center">
            <button onclick="closeDeleteModal()"
              class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md font-medium">
              Batal
            </button>
            <button onclick="confirmDeleteMenu()" id="delete-btn"
              class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md font-medium">
              Hapus
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-sidebar-layout>
