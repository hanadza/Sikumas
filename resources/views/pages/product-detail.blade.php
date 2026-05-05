@extends('layouts.app')

@section('title', $product->name . ' | SIKUMAS')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl mx-auto">
        <div class="md:flex">
            <div class="md:w-1/2">
                <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover" onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300?text=No+Image';">
            </div>
            <div class="p-8 md:w-1/2">
                <span class="text-sm text-green-600 font-semibold bg-green-50 px-3 py-1 rounded-full">{{ $product->category }}</span>
                <h1 class="text-2xl font-bold text-gray-800 mt-3">{{ $product->name }}</h1>
                <p class="text-3xl font-bold text-green-600 mt-4">Rp {{ number_format($product->price) }}</p>
                <p class="text-gray-500 mt-1">Stok: {{ $product->stock }}</p>

                <hr class="my-6 border-gray-100">

                <h3 class="font-semibold text-gray-700 mb-2">Deskripsi</h3>
                <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>

                <!-- Info Penjual -->
                <div class="mt-6 bg-green-50 border border-green-100 rounded-lg p-4">
                    <h4 class="font-bold text-green-800 text-sm mb-2">🏪 Informasi Penjual</h4>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-200 rounded-full flex items-center justify-center text-green-700 font-bold">
                            {{ strtoupper(substr($product->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 text-sm">{{ $product->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $product->user->address ?? 'Lokasi tidak tersedia' }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                @if($product->user->phone) 📱 {{ $product->user->phone }} @endif
                            </p>
                        </div>
                    </div>
                </div>

                <hr class="my-6 border-gray-100">

                @auth
                    @if($isOwner)
                        <!-- Pemilik produk: tidak bisa beli, hanya edit -->
                        <div class="mt-6 bg-amber-50 border border-amber-200 rounded-lg p-4">
                            <p class="text-amber-800 font-semibold text-sm">⚠️ Ini adalah produk Anda</p>
                            <p class="text-amber-700 text-sm mt-1">Anda tidak dapat membeli produk sendiri.</p>
                            <a href="{{ route('seller.products.edit', $product) }}" class="inline-block mt-2 bg-blue-500 text-white text-sm px-4 py-2 rounded hover:bg-blue-600 transition">
                                ✏️ Edit Produk
                            </a>
                        </div>
                    @else
                        <!-- Bukan pemilik: bisa beli -->
                        <form method="POST" action="{{ route('cart.store') }}" class="mt-6">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="flex items-center gap-4">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Jumlah</label>
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                           class="border border-gray-300 rounded-lg px-3 py-2 w-20 text-center">
                                </div>
                                <button type="submit" class="flex-grow bg-green-500 text-white font-bold py-3 rounded-lg hover:bg-green-600 transition">
                                    🛒 Tambah ke Keranjang
                                </button>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('cart.buynow') }}" class="mt-3">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-full bg-green-700 text-white font-bold py-2 rounded-lg hover:bg-green-800 transition text-sm">
                                ⚡ Beli Sekarang
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="block mt-6 bg-gray-200 text-gray-600 text-center font-bold py-3 rounded-lg hover:bg-gray-300 transition">
                        🔒 Login untuk Membeli
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>
    <!-- ===== REVIEWS SECTION ===== -->
    <div class="mt-12 max-w-4xl mx-auto">
        <h2 class="text-xl font-bold text-gray-800 mb-4">⭐ Ulasan Pembeli ({{ $product->reviews->count() }})</h2>

        @if($product->reviews->count() > 0)
            <div class="flex items-center gap-4 mb-6 bg-green-50 rounded-lg p-4">
                <div class="text-4xl font-bold text-green-700">{{ number_format($product->reviews->avg('rating'), 1) }}</div>
                <div>
                    <div class="text-yellow-400 text-lg">
                        @php $avg = round($product->reviews->avg('rating')); @endphp
                        @for($i=1; $i<=5; $i++)
                            @if($i <= $avg) ★ @else ☆ @endif
                        @endfor
                    </div>
                    <p class="text-sm text-gray-500">Dari {{ $product->reviews->count() }} ulasan</p>
                </div>
            </div>

            <div class="space-y-4">
                @foreach($product->reviews as $review)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold text-sm">
                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                            </div>
                            <span class="font-semibold text-gray-800 text-sm">{{ $review->user->name }}</span>
                        </div>
                        <span class="text-yellow-400 text-sm">
                            @for($i=1; $i<=5; $i++)
                                @if($i <= $review->rating) ★ @else ☆ @endif
                            @endfor
                        </span>
                    </div>
                    <p class="text-gray-600 text-sm">{{ $review->comment }}</p>
                    <p class="text-xs text-gray-400 mt-2">{{ $review->created_at->diffForHumans() }}</p>
                </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center text-gray-500">
                <p>Belum ada ulasan untuk produk ini.</p>
                <p class="text-sm mt-1">Jadilah pembeli pertama yang memberikan review!</p>
            </div>
        @endif
    </div>
@endsection
