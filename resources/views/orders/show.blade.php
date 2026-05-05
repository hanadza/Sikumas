@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->id . ' | SIKUMAS')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-3xl">
        <h1 class="text-2xl font-bold text-green-700 mb-2">Detail Pesanan #{{ $order->id }}</h1>

        <!-- Status Timeline -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
            <div class="flex items-center justify-between text-sm">
                @php
                    $steps = [
                        'pending' => 'Pesanan Dibuat',
                        'paid' => 'Dibayar',
                        'processing' => 'Diproses',
                        'shipped' => 'Dikirim',
                        'completed' => 'Selesai',
                    ];
                    $currentStep = array_search($order->status, array_keys($steps));
                    if ($currentStep === false) {
                        $currentStep = -1;
                    }
                @endphp
                @foreach ($steps as $key => $label)
                    <div class="flex flex-col items-center flex-1">
                        <div
                            class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold mb-1
                        {{ array_search($key, array_keys($steps)) <= $currentStep ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                            {{ array_search($key, array_keys($steps)) + 1 }}
                        </div>
                        <span
                            class="text-xs {{ array_search($key, array_keys($steps)) <= $currentStep ? 'text-green-700 font-semibold' : 'text-gray-400' }}">{{ $label }}</span>
                    </div>
                    @if (!$loop->last)
                        <div
                            class="flex-1 h-1 bg-gray-200 mx-2 mt-4 {{ array_search($key, array_keys($steps)) < $currentStep ? 'bg-green-500' : '' }}">
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <!-- Info Pesanan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-bold text-gray-800 mb-3">Info Pesanan</h3>
                <p class="text-sm text-gray-600 mb-1"><strong>Status:</strong>
                    <span
                        class="px-2 py-0.5 rounded text-xs font-semibold
                    @if ($order->status == 'completed') bg-green-100 text-green-700
                    @elseif($order->status == 'cancelled') bg-red-100 text-red-700
                    @elseif($order->status == 'shipped') bg-blue-100 text-blue-700
                    @else bg-gray-100 text-gray-700 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
                <p class="text-sm text-gray-600 mb-1"><strong>Tanggal:</strong>
                    {{ $order->created_at->format('d M Y H:i') }}</p>
                <p class="text-sm text-gray-600 mb-1"><strong>Total:</strong> Rp {{ number_format($order->total_price) }}
                </p>
                @if ($order->tracking_number)
                    <p class="text-sm text-gray-600 mb-1"><strong>No. Resi:</strong> {{ $order->tracking_number }}</p>
                @endif
            </div>

            <!-- Alamat -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-bold text-gray-800 mb-3">Alamat Pengiriman</h3>
                <p class="text-sm text-gray-600 whitespace-pre-line">{{ $order->shipping_address }}</p>
            </div>
        </div>

        <!-- Produk Dibeli -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mt-6">
            <h3 class="font-bold text-gray-800 mb-3">Produk Dibeli</h3>
            @foreach ($order->items as $item)
                <div class="flex items-center gap-4 py-3 border-b border-gray-50 last:border-0">
                    <img src="{{ asset($item->product->image_url ?? '') }}" alt="{{ $item->product->name ?? 'Produk' }}"
                        class="w-16 h-16 rounded object-cover"
                        onerror="this.onerror=null; this.src='https://via.placeholder.com/100x100?text=No+Image';">
                    <div class="flex-grow">
                        <p class="font-medium">{{ $item->product->name }}</p>
                        <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price) }}</p>
                    </div>
                    <p class="font-bold">Rp {{ number_format($item->price * $item->quantity) }}</p>
                </div>
            @endforeach
        </div>

        <!-- Upload Bukti Bayar via QRIS Penjual -->
        <!-- Upload Bukti Bayar via QRIS Penjual -->
        @if ($order->status == 'pending')

            <div class="bg-white rounded-xl shadow-sm border-2 border-green-200 p-6 mt-6">
                <h3 class="font-bold text-green-800 text-lg mb-1">💳 Pembayaran via QRIS</h3>

                @if (isset($seller) && $seller)
                    <div class="bg-green-50 rounded-lg p-4 mb-4 flex items-center gap-3">
                        <div
                            class="w-12 h-12 bg-green-200 rounded-full flex items-center justify-center text-green-700 font-bold text-lg">
                            {{ strtoupper(substr($seller->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">{{ $seller->name }}</p>
                            <p class="text-xs text-gray-500">{{ $seller->address ?? 'Alamat tidak tersedia' }}</p>
                            @if ($seller->phone)
                                <p class="text-xs text-green-600 font-medium">📱 {{ $seller->phone }}</p>
                            @endif
                        </div>
                    </div>

                    @if (isset($seller->qris_image) && $seller->qris_image)
                        <div class="flex flex-col items-center bg-gray-50 rounded-lg p-6 mb-4">
                            <img src="{{ asset($seller->qris_image) }}" alt="QRIS {{ $seller->name }}"
                                class="w-64 h-64 object-contain border-2 border-white rounded-lg shadow-sm">
                            <p class="text-sm text-green-700 font-semibold mt-3">Total: Rp
                                {{ number_format($order->total_price) }}</p>
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4 text-center">
                            <p class="text-yellow-700 font-semibold">⚠️ Penjual belum mengatur QRIS</p>
                            <p class="text-sm text-yellow-600">Hubungi penjual:
                                <strong>{{ $seller->phone ?? '-' }}</strong></p>
                        </div>
                    @endif
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4 text-center">
                        <p class="text-yellow-700 font-semibold">⚠️ Informasi penjual tidak ditemukan</p>
                    </div>
                @endif

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <h4 class="font-bold text-blue-800 text-sm mb-1">📋 Cara Pembayaran:</h4>
                    <ol class="list-decimal pl-5 text-sm text-blue-700 space-y-1">
                        <li>Buka aplikasi e-wallet atau mobile banking Anda.</li>
                        <li>Pilih menu <strong>Scan QRIS / Bayar</strong>.</li>
                        <li>Scan gambar QRIS (jika tersedia) atau transfer manual.</li>
                        <li>Masukkan nominal: <strong>Rp {{ number_format($order->total_price) }}</strong>.</li>
                        <li>Selesaikan pembayaran dan screenshot bukti sukses.</li>
                    </ol>
                </div>

                <form method="POST" action="{{ route('orders.payment', $order) }}" enctype="multipart/form-data"
                    class="border-t border-green-100 pt-4">
                    @csrf
                    <label class="block text-sm font-bold text-gray-700 mb-2">📤 Upload Screenshot Bukti Pembayaran</label>
                    <div class="flex gap-3">
                        <input type="file" name="payment_proof" accept="image/*" required
                            class="flex-grow border border-gray-300 rounded-lg px-3 py-2 text-sm file:bg-green-50 file:border-0 file:rounded file:px-4 file:py-2 file:text-green-700 file:font-semibold">
                        <button type="submit"
                            class="bg-green-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-green-700 transition">Konfirmasi</button>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Pastikan screenshot menunjukkan status "Berhasil / Sukses".</p>
                </form>
            </div>
        @elseif($order->status == 'paid')
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mt-6">
                <h3 class="font-bold text-gray-800 mb-3">✅ Bukti Pembayaran</h3>
                <img src="{{ asset($order->payment_proof) }}" class="max-w-xs rounded border"
                    onerror="this.onerror=null; this.src='https://via.placeholder.com/300x200?text=Bukti+Tidak+Tersedia';">
                <p class="text-sm text-gray-500 mt-2">Diupload pada: {{ $order->updated_at->format('d M Y H:i') }}</p>
            </div>
        @endif

        <!-- Review Section (khusus completed & belum direview) -->
        @if ($order->status == 'completed')
            @php
                $reviewedIds = $order->reviews->pluck('product_id')->toArray();
            @endphp

            @foreach ($order->items as $item)
                @if (!in_array($item->product_id, $reviewedIds))
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mt-6">
                        <h3 class="font-bold text-gray-800 mb-3">⭐ Review Produk: {{ $item->product->name }}</h3>
                        <form method="POST" action="{{ route('reviews.store', $order) }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item->product_id }}">

                            <div class="mb-3">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Rating</label>
                                <div class="flex gap-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="rating" value="{{ $i }}" required
                                                class="peer sr-only">
                                            <span
                                                class="text-2xl peer-checked:text-yellow-400 text-gray-300 hover:text-yellow-300 transition">★</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Komentar</label>
                                <textarea name="comment" rows="3" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-green-500"
                                    placeholder="Bagaimana kualitas produknya?"></textarea>
                            </div>

                            <button type="submit"
                                class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition text-sm font-bold">
                                Kirim Review
                            </button>
                        </form>
                    </div>
                @endif
            @endforeach

            <!-- Reviews yang sudah dikirim -->
            @if ($order->reviews->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mt-6">
                    <h3 class="font-bold text-gray-800 mb-3">Review Anda</h3>
                    @foreach ($order->reviews as $review)
                        <div class="border-b border-gray-50 py-3 last:border-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-yellow-400 text-lg">
                                    @for ($i = 0; $i < $review->rating; $i++)
                                        ★
                                    @endfor
                                </span>
                                <span class="text-sm text-gray-500">untuk {{ $review->product->name }}</span>
                            </div>
                            <p class="text-gray-700 text-sm">{{ $review->comment }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif

        <div class="mt-6 flex gap-3">
            <a href="{{ route('orders.my') }}" class="text-green-600 hover:underline text-sm">← Kembali ke Riwayat</a>
        </div>
    </div>
@endsection
