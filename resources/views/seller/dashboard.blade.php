@extends('layouts.app')

@section('title', 'Seller Dashboard | SIKUMAS')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-green-700 mb-6">Seller Dashboard</h1>

    @if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
        {{ session('success') }}
    </div>
    @endif

    <!-- Form Add / Edit Product -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
        <h2 class="text-lg font-bold mb-4">
            {{ isset($product) ? 'Edit Produk' : 'Add Product' }}
        </h2>

        <form method="POST"
              action="{{ isset($product) ? route('seller.products.update', $product) : route('seller.products.store') }}"
              enctype="multipart/form-data">
            @csrf
            @if(isset($product))
                @method('PUT')
            @endif

            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Nama Produk</label>
                    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Kategori</label>
                    <select name="category" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-500">
                        <option value="">Pilih Kategori</option>
                        <option value="Raw Materials" {{ (old('category', $product->category ?? '') == 'Raw Materials') ? 'selected' : '' }}>Raw Materials</option>
                        <option value="Processed Products" {{ (old('category', $product->category ?? '') == 'Processed Products') ? 'selected' : '' }}>Processed Products</option>
                        <option value="Equipment" {{ (old('category', $product->category ?? '') == 'Equipment') ? 'selected' : '' }}>Equipment</option>
                        <option value="Services" {{ (old('category', $product->category ?? '') == 'Services') ? 'selected' : '' }}>Services</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock ?? '') }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-500">
                </div>

                <!-- Upload Gambar (HANYA SATU) -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold mb-1">Upload Gambar Produk</label>
                    <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp"
                          {{ isset($product) ? '' : 'required' }}
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-500 file:bg-green-50 file:border-0 file:rounded file:px-4 file:py-2 file:text-green-700 file:font-semibold hover:file:bg-green-100">
                    @isset($product)
                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengganti gambar.</p>
                        <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover" onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300?text=No+Image';">
                    @endisset
                </div>

                <!-- Deskripsi Produk (TAMBAH INI) -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold mb-1">Deskripsi Produk</label>
                    <textarea name="description" rows="3" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-500">{{ old('description', $product->description ?? '') }}</textarea>
                </div>
            </div>
            <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition">
                {{ isset($product) ? 'Update Produk' : 'Tambah Produk' }}
            </button>
            @if(isset($product))
            <a href="{{ route('seller.dashboard') }}" class="ml-2 text-gray-500 hover:text-gray-700">Batal</a>
            @endif
        </form>
    </div>

        <!-- Link ke Monitoring Penjualan -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-green-700">Seller Dashboard</h1>
        <a href="{{ route('seller.orders') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition text-sm font-bold flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            Monitoring Penjualan
        </a>
    </div>

    <!-- Table Products -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <h2 class="text-lg font-bold p-6 border-b border-gray-100">Daftar Produk Anda</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-4 font-semibold text-gray-600">Gambar</th>
                        <th class="p-4 font-semibold text-gray-600">Nama</th>
                        <th class="p-4 font-semibold text-gray-600">Kategori</th>
                        <th class="p-4 font-semibold text-gray-600">Harga</th>
                        <th class="p-4 font-semibold text-gray-600">Stok</th>
                        <th class="p-4 font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $item)
                    <tr class="border-t border-gray-100 hover:bg-gray-50">
                        <td class="p-4">
                            <img<img src="{{ asset($item->image_url) }}" alt="{{ $item->name }}" class="w-16 h-16 object-cover rounded">                     </td>
                        <td class="p-4 font-medium">{{ $item->name }}</td>
                        <td class="p-4 text-sm text-gray-500">{{ $item->category }}</td>
                        <td class="p-4 text-green-600 font-semibold">Rp {{ number_format($item->price) }}</td>
                        <td class="p-4">{{ $item->stock }}</td>
                        <td class="p-4">
                            <div class="flex gap-2">
                                <a href="{{ route('seller.products.edit', $item) }}" class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">Edit</a>
                                <form method="POST" action="{{ route('seller.products.destroy', $item) }}" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500">Belum ada produk. Silakan tambah produk pertama Anda!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
