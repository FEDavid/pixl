<x-base-layout>
    <nav class="bg-red-500">
            {{-- Login logic
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif --}}
            @include('layouts.navigation')
    </nav>
    <section id="content" class="h-[2000px]">

        {{-- Admin test --}}
        {{-- @Auth checks to see if there's a user logged in --}}
        @auth
            @if (auth()->user()->is_admin)
                <h1 class="text-white">You're an admin mate</h1>
            @endif
        @endauth

    </section>
</x-base-layout>