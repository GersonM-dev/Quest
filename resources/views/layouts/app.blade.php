<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informatika Quest</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @yield('head')
</head>

<body class="bg-gray-100 min-h-screen antialiased">

    {{-- Header (Brand Only) --}}
    <header class="bg-blue-600 text-white shadow">
        <div class="container mx-auto px-4 py-4 flex items-center justify-center">
            <a href="{{ url('/dashboard') }}" class="font-bold text-xl tracking-tight">Informatika Quest</a>
        </div>
    </header>

    {{-- Main --}}
    <main class="py-8">
        <div class="container mx-auto px-4">
            @yield('content')
        </div>
    </main>

    {{-- Footer --}}
    <footer class="fixed bottom-0 left-0 w-full z-30 bg-white/90 backdrop-blur border-t border-blue-100 py-4 text-center text-sm text-gray-500 shadow-2xl
    sm:rounded-t-2xl sm:max-w-md sm:mx-auto sm:left-1/2 sm:-translate-x-1/2 sm:mb-0">

        <div class="flex items-center justify-center gap-2">
            <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <circle cx="12" cy="12" r="10" stroke-width="2" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h8M12 8v8" />
            </svg>
            <span>
                &copy; {{ date('Y') }} <span class="font-bold text-blue-600">Informatika Quest App</span> &middot; All rights
                reserved.
            </span>
        </div>
    </footer>


    {{-- Floating Navigation (Bottom Navbar) --}}
    <nav
        class="sticky bottom-0 z-50 mx-auto flex w-full justify-between gap-8 border-t bg-white px-5 py-2 text-xs sm:max-w-md sm:rounded-t-xl sm:border-transparent sm:text-sm sm:shadow-2xl">
        <a href="{{ url('/dashboard') }}"
            class="flex flex-col items-center gap-1 {{ request()->is('dashboard') ? 'text-indigo-500' : 'text-gray-400' }} transition duration-100 hover:text-gray-500 active:text-gray-600">
            <!-- Home Icon -->
            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z" />
                <path
                    d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z" />
            </svg>
            <span>Home</span>
        </a>

        <a href="{{ route('quiz.history') }}"
            class="flex flex-col items-center gap-1 {{ request()->is('quiz/history') ? 'text-indigo-500' : 'text-gray-400' }} transition duration-100 hover:text-gray-500 active:text-gray-600">
            <!-- History Icon -->
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
            </svg>
            <span>History</span>
        </a>


        @auth
            <a href="{{ url('/profile') }}"
                class="flex flex-col items-center gap-1 {{ request()->is('profile') ? 'text-indigo-500' : 'text-gray-400' }} transition duration-100 hover:text-gray-500 active:text-gray-600">
                <!-- Profile Icon -->
                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z"
                        clip-rule="evenodd" />
                </svg>
                <span>Profile</span>
            </a>
            <form action="{{ route('logout') }}" method="POST" class="flex flex-col items-center gap-1">
                @csrf
                <button class="text-gray-400 hover:text-gray-500 active:text-gray-600 transition duration-100"
                    type="submit">
                    <!-- Logout Icon -->
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15" />
                        <path d="M18 15l3-3m0 0l-3-3m3 3H9" />
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        @else
            <a href="{{ route('login') }}"
                class="flex flex-col items-center gap-1 {{ request()->is('login') ? 'text-indigo-500' : 'text-gray-400' }} transition duration-100 hover:text-gray-500 active:text-gray-600">
                <!-- Login Icon -->
                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15" />
                    <path d="M18 15l3-3m0 0l-3-3m3 3H9" />
                </svg>
                <span>Login</span>
            </a>
            <a href="{{ route('register') }}"
                class="flex flex-col items-center gap-1 {{ request()->is('register') ? 'text-indigo-500' : 'text-gray-400' }} transition duration-100 hover:text-gray-500 active:text-gray-600">
                <!-- Register Icon -->
                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M16.5 7.5a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zm-4.5 6.75A7.485 7.485 0 003.6 18.56c-.125.166-.205.365-.224.577A.75.75 0 004.125 20.25h15.75a.75.75 0 00.749-.864 7.485 7.485 0 00-8.124-6.136z" />
                </svg>
                <span>Register</span>
            </a>
        @endauth
    </nav>

    @yield('scripts')
</body>

</html>