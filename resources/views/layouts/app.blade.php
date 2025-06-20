<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informatika Quest</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> @yield('head')
</head>

<body class="bg-gray-100 min-h-screen antialiased">

    {{-- Header --}}
    <header class="bg-blue-600 text-white shadow">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ url('/dashboard') }}" class="font-bold text-xl tracking-tight">Informatika Quest</a>
            <nav>
                @auth
                    <a href="{{ url('/dashboard') }}" class="hover:underline mr-4">Dashboard</a>
                    <a href="{{ url('/profile') }}" class="hover:underline mr-4">My Profile</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button class="hover:underline">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:underline mr-4">Login</a>
                    <a href="{{ route('register') }}" class="hover:underline">Register</a>
                @endauth
            </nav>
        </div>
    </header>

    {{-- Main --}}
    <main class="py-8">
        <div class="container mx-auto px-4">
            @yield('content')
        </div>
    </main>

    {{-- Footer --}}
    <footer class="mt-12 py-4 bg-gray-200 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} Quiz Web App &middot; All rights reserved.
    </footer>

    @yield('scripts')
</body>

</html>