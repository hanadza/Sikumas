<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>@yield('title', 'SIKUMAS')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
        {{-- Sementara pakai CDN Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-green-50 text-gray-800 font-sans min-h-screen flex flex-col">

    {{-- Navbar --}}
<nav class="fixed top-0 left-0 right-0 z-[999] bg-green-500 text-white shadow-md">
    <div class="container mx-auto px-4 py-3 relative">
        <div class="flex justify-between items-center relative z-10">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-xl relative z-10">
                <img src="{{ asset('images/sikumas-logo.png') }}" alt="SIKUMAS" class="h-8 w-auto">
                <span>SIKUMAS</span>
            </a>

            <!-- Hamburger Button (Mobile only) -->
            <button id="mobile-menu-btn" class="md:hidden text-white focus:outline-none p-1 relative z-10" aria-label="Menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" id="icon-hamburger">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg class="w-6 h-6 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" id="icon-close">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Desktop Menu -->
                        <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-1 text-sm relative" id="nav-desktop">
                <!-- The gliding pill background -->
                <div id="nav-pill" class="absolute h-9 rounded-full bg-green-700/60 transition-all duration-300 ease-out pointer-events-none opacity-0"></div>

                <a href="{{ route('products.index') }}" class="nav-link relative z-10 px-4 py-2 rounded-full transition-colors">Products</a>
                <a href="{{ route('education') }}" class="nav-link relative z-10 px-4 py-2 rounded-full transition-colors">Edukasi</a>
                <a href="{{ route('cart.index') }}" class="nav-link relative z-10 px-4 py-2 rounded-full transition-colors">Keranjang</a>

                @auth
                    <a href="{{ route('orders.my') }}" class="nav-link relative z-10 px-4 py-2 rounded-full transition-colors">Pesanan</a>

                    @if(in_array(Auth::user()->type, ['penjual', 'dual']))
                    <a href="{{ route('seller.dashboard') }}" class="nav-link relative z-10 px-4 py-2 rounded-full transition-colors">Seller</a>
                    <a href="{{ route('seller.orders') }}" class="nav-link relative z-10 px-4 py-2 rounded-full transition-colors">Jualan</a>
                    @endif

                    <a href="{{ route('profile') }}" class="nav-link relative z-10 px-4 py-2 rounded-full transition-colors">
                        {{ Auth::user()->first_name }}
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="m-0 p-0 inline-flex">
                        @csrf
                        <button type="submit" class="nav-link relative z-10 px-4 py-2 rounded-full transition-colors bg-transparent border-none text-white cursor-pointer font-normal text-sm">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link relative z-10 px-4 py-2 rounded-full transition-colors bg-white text-green-700 font-semibold hover:bg-green-50">
                        Login
                    </a>
                @endauth
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden mt-3 pb-3 space-y-1 border-t border-green-400/50 pt-3 relative z-10">
            <a href="{{ route('products.index') }}" class="block hover:bg-green-600 transition rounded-lg px-3 py-2.5">Products</a>
            <a href="{{ route('education') }}" class="block hover:bg-green-600 transition rounded-lg px-3 py-2.5">Edukasi</a>
            <a href="{{ route('cart.index') }}" class="block hover:bg-green-600 transition rounded-lg px-3 py-2.5">Keranjang</a>

            @auth
                <a href="{{ route('orders.my') }}" class="block hover:bg-green-600 transition rounded-lg px-3 py-2.5">Pesanan Saya</a>

                @if(in_array(Auth::user()->type, ['penjual', 'dual']))
                <a href="{{ route('seller.dashboard') }}" class="block hover:bg-green-600 transition rounded-lg px-3 py-2.5">Seller Dashboard</a>
                <a href="{{ route('seller.orders') }}" class="block hover:bg-green-600 transition rounded-lg px-3 py-2.5">Monitoring Penjualan</a>
                @endif

                <a href="{{ route('profile') }}" class="block hover:bg-green-600 transition rounded-lg px-3 py-2.5">Profil</a>

                <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                    @csrf
                    <button type="submit" class="block w-full text-left hover:bg-green-600 transition rounded-lg px-3 py-2.5 bg-transparent border-none text-white cursor-pointer">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block hover:bg-green-600 transition rounded-lg px-3 py-2.5">Login</a>
                <a href="{{ route('register') }}" class="block hover:bg-green-600 transition rounded-lg px-3 py-2.5">Daftar</a>
            @endauth
        </div>
    </div>
</nav>

    {{-- Content --}}
    <main class="pt-20 flex-grow container mx-auto p-4">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-800 text-green-100 py-6 text-center text-sm">
        <div class="flex justify-center items-center gap-2 mb-2">
            <img src="{{ asset('images/sikumas-logo.png') }}" alt="SIKUMAS" class="h-8 w-auto">
            <span class="font-bold">SIKUMAS</span>
        </div>
        <p class="text-gray-400">Transformasi limbah kelapa menjadi nilai ekonomi berkelanjutan</p>
        <p class="text-gray-500 mt-1 text-xs">&copy; 2026 SIKUMAS. All rights reserved.</p>
    </footer>
<script>
// Mobile Menu Toggle
const mobileBtn = document.getElementById('mobile-menu-btn');
const mobileMenu = document.getElementById('mobile-menu');
const iconHamburger = document.getElementById('icon-hamburger');
const iconClose = document.getElementById('icon-close');

if (mobileBtn && mobileMenu) {
    mobileBtn.addEventListener('click', function() {
        mobileMenu.classList.toggle('hidden');
        iconHamburger.classList.toggle('hidden');
        iconClose.classList.toggle('hidden');
    });
}

// ===== NAVBAR HOVER PILL EFFECT =====
const navDesktop = document.getElementById('nav-desktop');
const pill = document.getElementById('nav-pill');
const links = document.querySelectorAll('.nav-link');

if (navDesktop && pill) {
    links.forEach(link => {
        link.addEventListener('mouseenter', function() {
            const rect = this.getBoundingClientRect();
            const navRect = navDesktop.getBoundingClientRect();

            pill.style.width = rect.width + 'px';
            pill.style.height = rect.height + 'px';
            pill.style.left = (rect.left - navRect.left) + 'px';
            pill.style.top = (rect.top - navRect.top) + 'px';
            pill.style.opacity = '1';
        });
    });

    navDesktop.addEventListener('mouseleave', function() {
        pill.style.opacity = '0';
    });
}
</script>
</body>

</html>
