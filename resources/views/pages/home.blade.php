@extends('layouts.app')

@section('title', 'Home | SIKUMAS')

@section('content')
<!-- Hero Section -->
<div class="bg-green-500 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <span class="bg-green-600 text-green-100 px-4 py-1 rounded-full text-sm font-semibold inline-block mb-4">
            Sustainable Coconut Solutions
        </span>
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">
            Transform Coconut Waste into Value
        </h1>
        <p class="text-green-100 text-lg max-w-2xl mx-auto mb-8">
            Your trusted marketplace for waste coconut management products, equipment, and services.
        </p>
        <div class="flex justify-center gap-4">
            <a href="{{ route('products.index') }}" class="bg-white text-green-700 px-6 py-3 rounded-lg font-semibold hover:bg-green-50 transition">
                Browse Products
            </a>
            <a href="{{ route('register') }}" class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-green-700 transition">
                Become a Seller
            </a>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="container mx-auto px-4 py-12">
    <div class="grid md:grid-cols-3 gap-8 text-center">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-green-100">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h3 class="font-bold text-lg mb-2">Eco-Friendly Products</h3>
            <p class="text-gray-600 text-sm">Sustainable solutions for coconut waste management</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-green-100">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="font-bold text-lg mb-2">Quality Guaranteed</h3>
            <p class="text-gray-600 text-sm">Verified sellers and premium products</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-green-100">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <h3 class="font-bold text-lg mb-2">Easy Shopping</h3>
            <p class="text-gray-600 text-sm">Seamless buying and selling experience</p>
        </div>
    </div>
</div>

<!-- Featured Products Section -->
<div class="container mx-auto px-4 py-12">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Featured Products</h2>
    <div class="grid md:grid-cols-3 gap-6">
        @forelse($featured as $product)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
            <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover" onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300?text=No+Image';">
            <div class="p-4">
                <div class="flex justify-between items-start mb-2">
                  @if(Auth::check() && Auth::id() === $product->user_id)
                      <span class="text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded font-semibold">Produk Anda</span>
                  @endif
                    <span class="text-xs text-green-600 font-semibold bg-green-50 px-2 py-1 rounded">{{ $product->category }}</span>
                    <!-- NAMA PENJUAL -->
                    <span class="text-xs text-gray-500 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        {{ $product->user->name }}
                    </span>
                </div>
                    <!-- Tambah rating -->
                    @if($product->reviews->count() > 0)
                    <div class="flex items-center gap-1 mt-1 mb-1">
                        <span class="text-yellow-400 text-xs">★ {{ number_format($product->reviews->avg('rating'), 1) }}</span>
                        <span class="text-xs text-gray-400">({{ $product->reviews->count() }})</span>
                    </div>
                    @endif
                <h3 class="font-bold text-gray-800">{{ $product->name }}</h3>
                <p class="text-green-700 font-bold mt-1">Rp {{ number_format($product->price) }}</p>
                <a href="{{ route('products.show', $product) }}" class="block mt-3 text-center bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 transition">Detail</a>
            </div>
        </div>
        @empty
        <p class="text-gray-500 col-span-3">Belum ada produk unggulan.</p>
        @endforelse
    </div>
</div>
@endsection
