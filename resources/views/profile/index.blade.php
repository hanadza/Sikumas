@extends('layouts.app')

@section('title', 'Profil | SIKUMAS')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <h1 class="text-2xl font-bold text-green-700 mb-6">Informasi Akun</h1>

    @if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-500">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" required
                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-500">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-500">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">Nomor Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-500">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">Alamat</label>
                <textarea name="address" rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-500">{{ old('address', $user->address) }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-1">Tipe Akun</label>
                <select name="type" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-500">
                    <option value="pembeli" {{ (old('type', $user->type) == 'pembeli') ? 'selected' : '' }}>Pembeli</option>
                    <option value="penjual" {{ (old('type', $user->type) == 'penjual') ? 'selected' : '' }}>Penjual</option>
                    <option value="dual" {{ (old('type', $user->type) == 'dual') ? 'selected' : '' }}>Pembeli & Penjual</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Anda dapat mengubah tipe akun kapan saja.</p>
            </div>

            <!-- QRIS Upload (khusus penjual/dual) -->
            @if(in_array($user->type, ['penjual', 'dual']))
            <div class="mb-6 bg-green-50 border border-green-100 rounded-lg p-4">
                <h4 class="font-bold text-green-800 mb-2">💳 QRIS Pembayaran</h4>
                <p class="text-sm text-gray-600 mb-3">Upload gambar QRIS Anda. Pembeli akan melihat QRIS ini saat checkout.</p>

            @if($user->qris_image)
                <img src="{{ asset($user->qris_image) }}"
                    class="w-48 h-48 object-contain border rounded bg-white"
                    onerror="this.onerror=null; this.src='https://via.placeholder.com/200x200?text=QRIS+Belum+Ada';">
            @endif

                <input type="file" name="qris_image" accept="image/*"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm file:bg-green-100 file:border-0 file:rounded file:px-4 file:py-2 file:text-green-700">
                <p class="text-xs text-gray-500 mt-1">Format: PNG/JPG. Maksimal 2MB.</p>
            </div>
            @endif

            <div class="flex gap-4">
                <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition">
                    Simpan Perubahan
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition">
                        Logout
                    </button>
                </form>
            </div>
        </form>
    </div>
</div>
@endsection
