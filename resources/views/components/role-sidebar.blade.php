<!-- Mobile sidebar -->
<el-disclosure id="mobile-sidebar" hidden class="lg:hidden">
  <div class="fixed inset-0 z-50 flex">
    <div class="fixed inset-0 bg-gray-900/80 transition-opacity duration-300 ease-linear"></div>

    <div class="relative mr-16 flex w-full max-w-xs flex-1">
      <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
        <button type="button" command="--toggle" commandfor="mobile-sidebar" class="-m-2.5 p-2.5">
          <span class="sr-only">Close sidebar</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
            data-slot="icon" aria-hidden="true" class="size-6 text-white">
            <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>
      </div>

      <!-- Sidebar component -->
      <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-2 dark:bg-gray-900">
        <div class="flex h-16 shrink-0 items-center">
          <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600"
            alt="Warung TM" class="h-8 w-auto dark:hidden" />
          <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
            alt="Warung TM" class="hidden h-8 w-auto dark:block" />
        </div>
        <nav class="flex flex-1 flex-col">
          <ul role="list" class="flex flex-1 flex-col gap-y-7">
            <li>
              <ul role="list" class="-mx-2 space-y-1">
                @if (auth()->user()->role === 'owner')
                  <!-- Owner Menu -->
                  <li>
                    <x-nav-link href="{{ route('owner.dashboard') }}" :current="request()->routeIs('owner.dashboard')"
                      class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" data-slot="icon" aria-hidden="true"
                        class="size-6 shrink-0">
                        <path
                          d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
                          stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                      Dashboard Owner
                    </x-nav-link>
                  </li>
                  <li>
                    <x-nav-link href="{{ route('owner.manajemen-menu') }}" :current="request()->routeIs('owner.manajemen-menu')"
                      class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" data-slot="icon" aria-hidden="true"
                        class="size-6 shrink-0">
                        <path
                          d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"
                          stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                      Manajemen Menu
                    </x-nav-link>
                  </li>
                  <li>
                    <x-nav-link href="{{ route('owner.laporan-penjualan') }}" :current="request()->routeIs('owner.laporan-penjualan')"
                      class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" data-slot="icon" aria-hidden="true"
                        class="size-6 shrink-0">
                        <path
                          d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"
                          stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                      Laporan Penjualan
                    </x-nav-link>
                  </li>
                  <li>
                    <x-nav-link href="{{ route('owner.riwayat-transaksi') }}" :current="request()->routeIs('owner.riwayat-transaksi')"
                      class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" data-slot="icon" aria-hidden="true"
                        class="size-6 shrink-0">
                        <path d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                          stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                      Riwayat Transaksi
                    </x-nav-link>
                  </li>
                  <li>
                    <x-nav-link href="{{ route('owner.manajemen-pengguna') }}" :current="request()->routeIs('owner.manajemen-pengguna')"
                      class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" data-slot="icon" aria-hidden="true"
                        class="size-6 shrink-0">
                        <path
                          d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"
                          stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                      Manajemen Pengguna
                    </x-nav-link>
                  </li>
                @elseif(auth()->user()->role === 'kasir')
                  <!-- Kasir Menu -->
                  <li>
                    <x-nav-link href="{{ route('kasir.dashboard') }}" :current="request()->routeIs('kasir.dashboard')"
                      class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" data-slot="icon" aria-hidden="true"
                        class="size-6 shrink-0">
                        <path
                          d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
                          stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                      Dashboard Kasir
                    </x-nav-link>
                  </li>
                  <li>
                    <x-nav-link href="{{ route('kasir.transaksi') }}" :current="request()->routeIs('kasir.transaksi')"
                      class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" data-slot="icon" aria-hidden="true"
                        class="size-6 shrink-0">
                        <path
                          d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"
                          stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                      Transaksi Kasir
                    </x-nav-link>
                  </li>
                  <li>
                    <x-nav-link href="{{ route('kasir.riwayat-transaksi') }}" :current="request()->routeIs('kasir.riwayat-transaksi')"
                      class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" data-slot="icon" aria-hidden="true"
                        class="size-6 shrink-0">
                        <path d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                          stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                      Riwayat Transaksi Kasir
                    </x-nav-link>
                  </li>
                @endif
              </ul>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</el-disclosure>

<!-- Static sidebar for desktop -->
<div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
  <div
    class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6 dark:border-white/10 dark:bg-gray-900">
    <div class="flex h-16 shrink-0 items-center">
      <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600"
        alt="Warung TM" class="h-8 w-auto dark:hidden" />
      <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
        alt="Warung TM" class="hidden h-8 w-auto dark:block" />
    </div>
    <nav class="flex flex-1 flex-col">
      <ul role="list" class="flex flex-1 flex-col gap-y-7">
        <li>
          <ul role="list" class="-mx-2 space-y-1">

            @if (auth()->user()->role === 'owner')
              <!-- Owner Menu -->
              <li>
                <x-nav-link href="{{ route('owner.dashboard') }}" :current="request()->routeIs('owner.dashboard')"
                  class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5" data-slot="icon" aria-hidden="true"
                    class="size-6 shrink-0">
                    <path
                      d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
                      stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  Dashboard Owner
                </x-nav-link>
              </li>
              <li>
                <x-nav-link href="{{ route('owner.manajemen-menu') }}" :current="request()->routeIs('owner.manajemen-menu')"
                  class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5" data-slot="icon" aria-hidden="true"
                    class="size-6 shrink-0">
                    <path
                      d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"
                      stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  Manajemen Menu
                </x-nav-link>
              </li>
              <li>
                <x-nav-link href="{{ route('owner.laporan-penjualan') }}" :current="request()->routeIs('owner.laporan-penjualan')"
                  class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5" data-slot="icon" aria-hidden="true"
                    class="size-6 shrink-0">
                    <path
                      d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"
                      stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  Laporan Penjualan
                </x-nav-link>
              </li>
              <li>
                <x-nav-link href="{{ route('owner.riwayat-transaksi') }}" :current="request()->routeIs('owner.riwayat-transaksi')"
                  class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5" data-slot="icon" aria-hidden="true"
                    class="size-6 shrink-0">
                    <path d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                      stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  Riwayat Transaksi
                </x-nav-link>
              </li>
              <li>
                <x-nav-link href="{{ route('owner.manajemen-pengguna') }}" :current="request()->routeIs('owner.manajemen-pengguna')"
                  class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5" data-slot="icon" aria-hidden="true"
                    class="size-6 shrink-0">
                    <path
                      d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"
                      stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  Manajemen Pengguna
                </x-nav-link>
              </li>
            @elseif(auth()->user()->role === 'kasir')
              <!-- Kasir Menu -->
              <li>
                <x-nav-link href="{{ route('kasir.dashboard') }}" :current="request()->routeIs('kasir.dashboard')"
                  class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5" data-slot="icon" aria-hidden="true"
                    class="size-6 shrink-0">
                    <path
                      d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
                      stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  Dashboard Kasir
                </x-nav-link>
              </li>
              <li>
                <x-nav-link href="{{ route('kasir.transaksi') }}" :current="request()->routeIs('kasir.transaksi')"
                  class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5" data-slot="icon" aria-hidden="true"
                    class="size-6 shrink-0">
                    <path
                      d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"
                      stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  Transaksi Kasir
                </x-nav-link>
              </li>
              <li>
                <x-nav-link href="{{ route('kasir.riwayat-transaksi') }}" :current="request()->routeIs('kasir.riwayat-transaksi')"
                  class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5" data-slot="icon" aria-hidden="true"
                    class="size-6 shrink-0">
                    <path d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                      stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  Riwayat Transaksi Kasir
                </x-nav-link>
              </li>
            @endif
          </ul>
        </li>

        <!-- User Profile Section -->
        <li class="mt-auto">
          <div
            class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-700 dark:text-gray-400">
            <div
              class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border border-gray-200 bg-white text-[0.625rem] font-medium text-gray-400 dark:border-white/10 dark:bg-white/5">
              {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
              <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
              <p class="text-xs text-gray-500">{{ ucfirst(auth()->user()->role) }}</p>
            </div>
          </div>
          <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <button type="submit"
              class="group -mx-2 flex w-full gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-700 hover:bg-gray-50 hover:text-indigo-600 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                data-slot="icon" aria-hidden="true"
                class="size-6 shrink-0 text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-white">
                <path
                  d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"
                  stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              Sign out
            </button>
          </form>
        </li>
      </ul>
    </nav>
  </div>
</div>

<!-- Mobile header -->
<div
  class="sticky top-0 z-40 flex items-center gap-x-6 bg-white px-4 py-4 shadow-sm sm:px-6 lg:hidden dark:bg-gray-900">
  <button type="button" command="--toggle" commandfor="mobile-sidebar"
    class="-m-2.5 p-2.5 text-gray-700 hover:text-gray-900 lg:hidden dark:text-gray-400 dark:hover:text-white">
    <span class="sr-only">Open sidebar</span>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
      data-slot="icon" aria-hidden="true" class="size-6">
      <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round"
        stroke-linejoin="round" />
    </svg>
  </button>
  <div class="flex-1 text-sm/6 font-semibold text-gray-900 dark:text-white">
    Warung TM - {{ ucfirst(auth()->user()->role) }}
  </div>

  <!-- Profile info -->
  <div class="flex items-center gap-x-2">
    <div
      class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-indigo-600 text-sm font-medium text-white">
      {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
    </div>
    <span
      class="text-sm font-medium text-gray-900 dark:text-white">{{ auth()->user()->name }}</span>
  </div>
</div>

<!-- Main content -->
<main class="py-10 lg:pl-72">
  <div class="px-4 sm:px-6 lg:px-8">
    {{ $slot }}
  </div>
</main>
