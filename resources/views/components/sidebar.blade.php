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
            alt="Your Company" class="h-8 w-auto dark:hidden" />
          <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
            alt="Your Company" class="hidden h-8 w-auto dark:block" />
        </div>
        <nav class="flex flex-1 flex-col">
          <ul role="list" class="flex flex-1 flex-col gap-y-7">
            <li>
              <ul role="list" class="-mx-2 space-y-1">
                <li>
                  <x-nav-link href="/dashboard" :current="request()->is('dashboard')"
                    class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                      data-slot="icon" aria-hidden="true" class="size-6 shrink-0">
                      <path
                        d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
                        stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Dashboard
                  </x-nav-link>
                </li>
                <li>
                  <x-nav-link href="/blog" :current="request()->is('blog')"
                    class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                      data-slot="icon" aria-hidden="true" class="size-6 shrink-0">
                      <path
                        d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z"
                        stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Blog
                  </x-nav-link>
                </li>
                <li>
                  <x-nav-link href="/aboute" :current="request()->is('aboute')"
                    class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                      data-slot="icon" aria-hidden="true" class="size-6 shrink-0">
                      <path
                        d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"
                        stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    About
                  </x-nav-link>
                </li>
                <li>
                  <x-nav-link href="/contact" :current="request()->is('contact')"
                    class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                      data-slot="icon" aria-hidden="true" class="size-6 shrink-0">
                      <path
                        d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"
                        stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Contact
                  </x-nav-link>
                </li>
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
        alt="Your Company" class="h-8 w-auto dark:hidden" />
      <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
        alt="Your Company" class="hidden h-8 w-auto dark:block" />
    </div>
    <nav class="flex flex-1 flex-col">
      <ul role="list" class="flex flex-1 flex-col gap-y-7">
        <li>
          <ul role="list" class="-mx-2 space-y-1">
            <li>
              <x-nav-link href="/dashboard" :current="request()->is('dashboard')"
                class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                  data-slot="icon" aria-hidden="true" class="size-6 shrink-0">
                  <path
                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
                    stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Dashboard
              </x-nav-link>
            </li>

            <li>
              <x-nav-link href="/blog" :current="request()->is('blog')"
                class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                  data-slot="icon" aria-hidden="true" class="size-6 shrink-0">
                  <path
                    d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z"
                    stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Blog
              </x-nav-link>
            </li>
            <li>
              <x-nav-link href="/aboute" :current="request()->is('aboute')"
                class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                  data-slot="icon" aria-hidden="true" class="size-6 shrink-0">
                  <path
                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"
                    stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                About
              </x-nav-link>
            </li>
            <li>
              <x-nav-link href="/contact" :current="request()->is('contact')"
                class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                  data-slot="icon" aria-hidden="true" class="size-6 shrink-0">
                  <path
                    d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"
                    stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Contact
              </x-nav-link>
            </li>
          </ul>
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
  <div class="flex-1 text-sm/6 font-semibold text-gray-900 dark:text-white">Warung TM</div>

  <!-- Profile dropdown -->
  <el-dropdown class="relative">
    <button
      class="relative flex max-w-xs items-center rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
      <span class="absolute -inset-1.5"></span>
      <span class="sr-only">Open user menu</span>
      <img
        src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
        alt=""
        class="size-8 rounded-full bg-gray-50 outline-1 -outline-offset-1 outline-black/5 dark:bg-gray-800 dark:outline-white/10" />
    </button>

    <el-menu anchor="bottom end" popover
      class="w-48 origin-top-right rounded-md bg-white py-1 shadow-lg outline-1 outline-black/5 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in dark:bg-gray-800 dark:shadow-none dark:-outline-offset-1 dark:outline-white/10">
      <a href="#"
        class="block px-4 py-2 text-sm text-gray-700 focus:bg-gray-100 focus:outline-hidden dark:text-gray-300 dark:focus:bg-white/5">Your
        profile</a>
      <a href="#"
        class="block px-4 py-2 text-sm text-gray-700 focus:bg-gray-100 focus:outline-hidden dark:text-gray-300 dark:focus:bg-white/5">Settings</a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
          class="block w-full text-left px-4 py-2 text-sm text-gray-700 focus:bg-gray-100 focus:outline-hidden dark:text-gray-300 dark:focus:bg-white/5">Sign
          out</button>
      </form>
    </el-menu>
  </el-dropdown>
</div>

<!-- Main content -->
<main class="py-10 lg:pl-72">
  <div class="px-4 sm:px-6 lg:px-8">
    {{ $slot }}
  </div>
</main>
