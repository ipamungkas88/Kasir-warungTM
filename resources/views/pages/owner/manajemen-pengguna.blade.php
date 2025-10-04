<x-sidebar-layout>
  <x-slot:title>Manajemen Pengguna - Warung TM</x-slot:title>

  <div class="mx-auto max-w-7xl">
    <div class="py-6">
      <!-- Header -->
      <div class="mx-auto max-w-none">
        <div class="flex justify-between items-center">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Manajemen Pengguna</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Kelola akun kasir dan administrator
              sistem</p>
          </div>
          <button onclick="showAddUserModal()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            <span>Tambah Pengguna</span>
          </button>
        </div>
      </div>

      <!-- Success/Error Messages -->
      <div id="alert-container" class="mx-auto max-w-none mt-6"></div>

      <!-- Search and Filter -->
      <div class="mx-auto max-w-none mt-8">
        <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-800 mb-6">
          <form method="GET" action="{{ route('owner.manajemen-pengguna') }}"
            class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <!-- Search -->
            <div class="md:col-span-2">
              <label for="search"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cari
                Pengguna</label>
              <input type="text" name="search" id="search" value="{{ request('search') }}"
                class="mt-1 block w-full px-3 py-1.5 min-w-[250px] rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                placeholder="Nama atau username...">
            </div>

            <!-- Role Filter -->
            <div>
              <label for="role"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role</label>
              <select name="role" id="role"
                class="mt-1 block w-full px-3 py-1.5 min-w-[120px] rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="">Semua Role</option>
                <option value="owner" {{ request('role') === 'owner' ? 'selected' : '' }}>Owner
                </option>
                <option value="kasir" {{ request('role') === 'kasir' ? 'selected' : '' }}>Kasir
                </option>
              </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2">
              <button type="submit"
                class="flex-1 min-w-[80px] bg-gray-600 hover:bg-gray-700 text-white py-1.5 px-3 rounded-md font-medium">
                Filter
              </button>
              <a href="{{ route('owner.manajemen-pengguna') }}"
                class="flex-1 min-w-[80px] bg-red-600 hover:bg-red-700 text-white py-1.5 px-3 rounded-md text-center font-medium">
                Reset
              </a>
            </div>
          </form>
        </div>

        <!-- Users Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
          <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-800">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <svg class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24"
                  stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total
                    Pengguna</dt>
                  <dd class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ $users->total() ?? 0 }}</dd>
                </dl>
              </div>
            </div>
          </div>

          <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-800">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24"
                  stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Kasir
                    Aktif</dt>
                  <dd class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ $kasirCount ?? 0 }}</dd>
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
                    d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.623 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                </svg>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Owner
                  </dt>
                  <dd class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ $ownerCount ?? 0 }}</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white shadow rounded-lg dark:bg-gray-800">
          <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Pengguna</h3>
          </div>

          @if (isset($users) && $users->count() > 0)
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                  <tr>
                    <th
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                      Pengguna
                    </th>
                    <th
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                      Username
                    </th>
                    <th
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                      Role
                    </th>
                    <th
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                      Bergabung
                    </th>
                    <th
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                      Status
                    </th>
                    <th
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                      Aksi
                    </th>
                  </tr>
                </thead>
                <tbody
                  class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                  @foreach ($users as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                          <div class="flex-shrink-0 h-10 w-10">
                            <div
                              class="h-10 w-10 rounded-full bg-{{ $user->role === 'owner' ? 'purple' : 'blue' }}-500 flex items-center justify-center">
                              <span
                                class="text-sm font-medium text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                          </div>
                          <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                              {{ $user->name }}</div>
                            @if ($user->id === auth()->id())
                              <div class="text-sm text-blue-600 dark:text-blue-400">(Anda)</div>
                            @endif
                          </div>
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 dark:text-white font-mono">
                          {{ $user->username }}</div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <span
                          class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                          {{ $user->role === 'owner'
                              ? 'bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100'
                              : 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100' }}">
                          {{ ucfirst($user->role) }}
                        </span>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 dark:text-white">
                          {{ $user->created_at->format('d/m/Y') }}
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <span
                          class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                          Aktif
                        </span>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <button onclick="editUser({{ json_encode($user) }})"
                          class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                          Edit
                        </button>
                        @if ($user->id !== auth()->id())
                          <button
                            onclick="confirmDeleteUser({{ $user->id }}, '{{ $user->name }}')"
                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                            Hapus
                          </button>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
              {{ $users->appends(request()->query())->links() }}
            </div>
          @else
            <div class="px-6 py-12 text-center">
              <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
              </svg>
              <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada pengguna
              </h3>
              <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Belum ada pengguna yang sesuai dengan kriteria pencarian.
              </p>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Add/Edit User Modal -->
  <div id="user-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
      <div class="fixed inset-0 bg-transparent backdrop-blur-sm" onclick="closeUserModal()"></div>
      <div class="bg-white dark:bg-gray-800 rounded-lg max-w-xl w-full relative">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
          <div class="flex justify-between items-center">
            <h3 id="modal-title" class="text-lg font-semibold text-gray-900 dark:text-white">
              Tambah Pengguna Baru</h3>
            <button onclick="closeUserModal()"
              class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
              <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>

        <form id="user-form" action="{{ route('owner.users.store') }}" method="POST"
          class="p-6">
          @csrf
          <input type="hidden" id="user-id" name="user_id">

          <div class="space-y-5">
            <div>
              <label for="name"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama
                Lengkap</label>
              <input type="text" name="name" id="name" required
                class="mt-1 block w-full px-3 py-1.5 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                placeholder="Masukkan nama lengkap">
              <div class="text-red-500 text-sm mt-1 hidden" id="name-error"></div>
            </div>

            <div>
              <label for="username"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Username</label>
              <input type="text" name="username" id="username" required
                class="mt-1 block w-full px-3 py-1.5 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                placeholder="Masukkan username">
              <div class="text-red-500 text-sm mt-1 hidden" id="username-error"></div>
            </div>

            <div>
              <label for="role"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role</label>
              <select name="role" id="role" required
                class="mt-1 block w-full px-3 py-1.5 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="">Pilih Role</option>
                <option value="kasir">Kasir</option>
                <option value="owner">Owner</option>
              </select>
              <div class="text-red-500 text-sm mt-1 hidden" id="role-error"></div>
            </div>

            <div id="password-section">
              <label for="password"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
              <input type="password" name="password" id="password"
                class="mt-1 block w-full px-3 py-1.5 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                placeholder="Masukkan password">
              <div class="text-red-500 text-sm mt-1 hidden" id="password-error"></div>
              <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" id="password-help">
                Minimal 8 karakter. Kosongkan jika tidak ingin mengubah password (untuk edit).
              </p>
            </div>

            <div>
              <label for="password_confirmation"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Konfirmasi
                Password</label>
              <input type="password" name="password_confirmation" id="password_confirmation"
                class="mt-1 block w-full px-3 py-1.5 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                placeholder="Ulangi password">
              <div class="text-red-500 text-sm mt-1 hidden" id="password_confirmation-error">
              </div>
            </div>
          </div>

          <div class="mt-6 flex justify-end space-x-3">
            <button type="button" onclick="closeUserModal()"
              class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">
              Batal
            </button>
            <button type="submit" id="submit-btn"
              class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
              Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div id="delete-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
      <div class="fixed inset-0 bg-transparent backdrop-blur-sm" onclick="closeDeleteModal()">
      </div>
      <div class="bg-white dark:bg-gray-800 rounded-lg max-w-sm w-full relative">
        <div class="p-6 text-center">
          <svg class="mx-auto mb-4 h-14 w-14 text-red-600" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
          </svg>
          <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Hapus Pengguna</h3>
          <p class="text-gray-500 dark:text-gray-400 mb-6">
            Apakah Anda yakin ingin menghapus pengguna <span id="delete-user-name"
              class="font-semibold"></span>?
            Tindakan ini tidak dapat dibatalkan.
          </p>
          <div class="flex justify-center space-x-3">
            <button onclick="closeDeleteModal()"
              class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">
              Batal
            </button>
            <button onclick="deleteUser()" id="delete-btn"
              class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">
              Hapus
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    let currentUserId = null;
    let isEditMode = false;

    function showAddUserModal() {
      isEditMode = false;
      document.getElementById('modal-title').textContent = 'Tambah Pengguna Baru';
      document.getElementById('user-form').action = '{{ route('owner.users.store') }}';
      document.getElementById('submit-btn').textContent = 'Simpan';
      document.getElementById('password-help').textContent = 'Minimal 8 karakter.';

      // Reset form
      document.getElementById('user-form').reset();
      document.getElementById('user-id').value = '';
      document.getElementById('password').required = true;

      // Clear errors
      clearFormErrors();

      document.getElementById('user-modal').classList.remove('hidden');
    }

    function editUser(user) {
      isEditMode = true;
      currentUserId = user.id;

      document.getElementById('modal-title').textContent = 'Edit Pengguna';
      document.getElementById('user-form').action = '{{ route('owner.users.update') }}';
      document.getElementById('submit-btn').textContent = 'Update';
      document.getElementById('password-help').textContent =
        'Minimal 8 karakter. Kosongkan jika tidak ingin mengubah password.';

      // Fill form
      document.getElementById('user-id').value = user.id;
      document.getElementById('name').value = user.name;
      document.getElementById('username').value = user.username;
      document.getElementById('role').value = user.role;
      document.getElementById('password').required = false;

      // Clear password fields
      document.getElementById('password').value = '';
      document.getElementById('password_confirmation').value = '';

      // Clear errors
      clearFormErrors();

      document.getElementById('user-modal').classList.remove('hidden');
    }

    function closeUserModal() {
      document.getElementById('user-modal').classList.add('hidden');
      clearFormErrors();
    }

    function confirmDeleteUser(userId, userName) {
      currentUserId = userId;
      document.getElementById('delete-user-name').textContent = userName;
      document.getElementById('delete-modal').classList.remove('hidden');
    }

    function closeDeleteModal() {
      document.getElementById('delete-modal').classList.add('hidden');
      currentUserId = null;
    }

    function deleteUser() {
      if (!currentUserId) return;

      const formData = new FormData();
      formData.append('_token', '{{ csrf_token() }}');
      formData.append('user_id', currentUserId);

      fetch('{{ route('owner.users.delete') }}', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            closeDeleteModal();
            showAlert(data.message, 'success');
            setTimeout(() => location.reload(), 1000);
          } else {
            showAlert('Error: ' + (data.message || 'Gagal menghapus pengguna'), 'error');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          showAlert('Terjadi kesalahan saat menghapus pengguna', 'error');
        });
    }

    function clearFormErrors() {
      const errorElements = document.querySelectorAll('[id$="-error"]');
      errorElements.forEach(el => {
        el.classList.add('hidden');
        el.textContent = '';
      });
    }

    function showFormErrors(errors) {
      clearFormErrors();

      Object.keys(errors).forEach(field => {
        const errorElement = document.getElementById(field + '-error');
        if (errorElement) {
          errorElement.textContent = errors[field][0];
          errorElement.classList.remove('hidden');
        }
      });
    }

    // Handle form submission
    document.getElementById('user-form').addEventListener('submit', function(e) {
      e.preventDefault();

      const formData = new FormData(this);

      fetch(this.action, {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            closeUserModal();
            showAlert(data.message, 'success');
            setTimeout(() => location.reload(), 1000);
          } else {
            if (data.errors) {
              showFormErrors(data.errors);
            } else {
              showAlert('Error: ' + (data.message || 'Gagal menyimpan pengguna'), 'error');
            }
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Terjadi kesalahan saat menyimpan data');
        });
    });

    // Function to show alert messages
    function showAlert(message, type) {
      const alertContainer = document.getElementById('alert-container');
      const alertId = 'alert-' + Date.now();

      const alertHtml = `
        <div id="${alertId}" class="mx-auto max-w-none">
          <div class="${type === 'success' ? 'bg-green-50 border border-green-200 text-green-700 dark:bg-green-900/20 dark:border-green-800 dark:text-green-300' : 'bg-red-50 border border-red-200 text-red-700 dark:bg-red-900/20 dark:border-red-800 dark:text-red-300'} px-4 py-3 rounded flex justify-between items-center">
            <span>${message}</span>
            <button onclick="closeAlert('${alertId}')" class="ml-4 ${type === 'success' ? 'text-green-500 hover:text-green-700' : 'text-red-500 hover:text-red-700'}">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
              </svg>
            </button>
          </div>
        </div>
      `;

      alertContainer.innerHTML = alertHtml;

      // Auto-hide after 10 seconds
      setTimeout(function() {
        closeAlert(alertId);
      }, 10000);
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
  </script>
</x-sidebar-layout>
