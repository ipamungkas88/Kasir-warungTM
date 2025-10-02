<x-layout title="login">

  <div class="flex min-h-full">
    <div
      class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
      <div class="mx-auto w-full max-w-sm lg:w-96">
        <div>
          <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
            alt="Warung TM" class="h-10 w-auto" />
          <h2 class="mt-8 text-2xl/9 font-bold tracking-tight text-white">LOGIN
          </h2>
          <p class="mt-2 text-sm/6 text-gray-400">
            Welcome to Kasir Warung TM System
          </p>
          <div class="mt-4 p-4 bg-gray-800 rounded-lg">
            <h3 class="text-sm font-semibold text-white mb-2">Demo Accounts:</h3>
            <div class="space-y-2 text-xs text-gray-300">
              <div class="flex justify-between">
                <span><strong>Owner:</strong> owner / owner123</span>
              </div>
              <div class="flex justify-between">
                <span><strong>Kasir:</strong> kasir / kasir123</span>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-10">
          <div>
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
              @csrf
              <div>
                <label for="username" class="block text-sm/6 font-medium text-gray-100">
                  Username</label>
                <div class="mt-2">
                  <input id="username" type="text" name="username" value="{{ old('username') }}"
                    required autocomplete="username"
                    class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6 @error('username') border-red-500 @enderror" />
                </div>
                @error('username')
                  <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
              </div>

              <div>
                <label for="password"
                  class="block text-sm/6 font-medium text-gray-100">Password</label>
                <div class="mt-2">
                  <input id="password" type="password" name="password" required
                    autocomplete="current-password"
                    class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6 @error('password') border-red-500 @enderror" />
                </div>
                @error('password')
                  <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
              </div>

              <div class="flex items-center justify-between">
                <div class="flex gap-3">
                  <div class="flex h-6 shrink-0 items-center">
                    <div class="group grid size-4 grid-cols-1">
                      <input id="remember-me" type="checkbox" name="remember-me"
                        class="col-start-1 row-start-1 appearance-none rounded-sm border border-white/10 bg-white/5 checked:border-indigo-500 checked:bg-indigo-500 indeterminate:border-indigo-500 indeterminate:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                      <svg viewBox="0 0 14 14" fill="none"
                        class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25">
                        <path d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round" class="opacity-0 group-has-checked:opacity-100" />
                        <path d="M3 7H11" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round"
                          class="opacity-0 group-has-indeterminate:opacity-100" />
                      </svg>
                    </div>
                  </div>
                  <label for="remember-me" class="block text-sm/6 text-gray-300">Remember me</label>
                </div>

                <div class="text-sm/6">
                  <a href="#"
                    class="font-semibold text-indigo-400 hover:text-indigo-300">Forgot
                    password?</a>
                </div>
              </div>

              <div>
                <button type="submit"
                  class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Sign
                  in</button>
              </div>
            </form>
          </div>

          <div class="mt-10">
          </div>
        </div>
      </div>
    </div>
    <div class="relative hidden w-0 flex-1 lg:block">
      <img
        src="https://images.unsplash.com/photo-1496917756835-20cb06e75b4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1908&q=80"
        alt="" class="absolute inset-0 size-full object-cover" />
    </div>
  </div>
</x-layout>
