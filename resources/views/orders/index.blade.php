@extends('layouts.app')

@section('title', 'Pesanan Saya | SIKUMAS')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <h1 class="text-2xl font-bold text-green-700 mb-6">📋 Riwayat Pesanan</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">{{ session('error') }}</div>
        @endif

        <div class="space-y-4">
            @forelse($orders as $order)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500">Order #{{ $order->id }}</p>
                            <p class="text-sm text-gray-400">{{ $order->created_at->diffForHumans() }}
                                ({{ $order->created_at->format('d M Y H:i') }})</p>
                        </div>
                        <span
                            class="px-3 py-1 rounded-full text-sm font-semibold
                    @if ($order->status == 'completed') bg-green-100 text-green-700
                    @elseif($order->status == 'cancelled') bg-red-100 text-red-700
                    @elseif($order->status == 'shipped') bg-blue-100 text-blue-700
                    @elseif($order->status == 'paid') bg-yellow-100 text-yellow-700
                    @elseif($order->status == 'processing') bg-purple-100 text-purple-700
                    @else bg-gray-100 text-gray-700 @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div class="p-4">
                        @foreach ($order->items as $item)
                            <div class="flex items-center gap-3 mb-2">
                                <img src="{{ asset($item->product->image_url) }}" alt="{{ $item->product->name }}" class="w-full h-48 object-cover" onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300?text=No+Image';">
                                <div class="flex-grow">
                                    <p class="font-medium text-gray-800">{{ $item->product->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp
                                        {{ number_format($item->price) }}</p>
                                </div>
                            </div>
                        @endforeach
                        <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-50">
                            <p class="font-bold text-gray-800">Total: Rp {{ number_format($order->total_price) }}</p>
                            <a href="{{ route('orders.show', $order) }}"
                                class="text-green-600 font-semibold hover:underline text-sm">Detail →</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white p-8 rounded-xl text-center text-gray-500">
                    <p>Belum ada pesanan.</p>
                    <a href="{{ route('products.index') }}" class="text-green-600 hover:underline mt-2 inline-block">Mulai
                        Belanja</a>
                </div>
            @endforelse
        </div>
    </div>
@endsection
