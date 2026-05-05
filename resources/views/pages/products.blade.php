@extends('layouts.app')

@section('title', 'Products | SIKUMAS')

@section('content')
    <div class="bg-green-500 py-8">
        <div class="container mx-auto px-4 text-center text-white">
            <h1 class="text-3xl font-bold mb-2">Browse All Products</h1>
            <p class="text-green-100">Find the best coconut waste management products</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">

        <!-- Search & Filter -->
        <form method="GET" action="{{ route('products.index') }}"
            class="bg-white p-4 rounded-lg shadow-sm mb-6 flex flex-col md:flex-row gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..."
                class="flex-grow border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-500">

            <select name="category"
                class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-500">
                <option value="all" {{ request('category') === 'all' || !request('category') ? 'selected' : '' }}>All
                    Categories</option>
                <option value="Raw Materials" {{ request('category') === 'Raw Materials' ? 'selected' : '' }}>Raw Materials
                </option>
                <option value="Processed Products" {{ request('category') === 'Processed Products' ? 'selected' : '' }}>
                    Processed Products</option>
                <option value="Equipment" {{ request('category') === 'Equipment' ? 'selected' : '' }}>Equipment</option>
                <option value="Services" {{ request('category') === 'Services' ? 'selected' : '' }}>Services</option>
            </select>

            <select name="sort"
                class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-500">
                <option value="">Default</option>
                <option value="low-high" {{ request('sort') === 'low-high' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="high-low" {{ request('sort') === 'high-low' ? 'selected' : '' }}>Price: High to Low</option>
            </select>

            <button type="submit"
                class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition">Filter</button>

            @if (request('search') || request('category') || request('sort'))
                <a href="{{ route('products.index') }}"
                    class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition text-center">Reset</a>
            @endif
        </form>

        <!-- Product Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($products as $product)
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition">
                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}"
                        class="w-full h-48 object-cover"
                        onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300?text=No+Image';">
                    <div class="p-4">
                        @if (Auth::check() && Auth::id() === $product->user_id)
                            <span class="text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded font-semibold">Produk
                                Anda</span>
                        @endif
                        <span
                            class="text-xs text-green-600 font-semibold bg-green-50 px-2 py-1 rounded">{{ $product->category }}</span>

                        <!-- NAMA PENJUAL -->
                        <div class="flex items-center gap-1 mt-2 mb-1">
                            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="text-xs text-gray-500">{{ $product->user->name }}</span>
                        </div>

                        <h3 class="font-bold text-gray-800">{{ $product->name }}</h3>
                        <p class="text-green-700 font-bold mt-1">Rp {{ number_format($product->price) }}</p>
                        <div class="flex justify-between items-center mt-3">
                            <span class="text-sm text-gray-500">Stok: {{ $product->stock }}</span>
                            <a href="{{ route('products.show', $product) }}"
                                class="bg-green-500 text-white px-4 py-1 rounded-lg text-sm hover:bg-green-600">Detail</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-gray-500">
                    <p>Belum ada produk tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
