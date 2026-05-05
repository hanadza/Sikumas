<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderController extends Controller
{
  // Buyer: Riwayat pesanan saya
  public function myOrders()
  {
    $orders = Order::where('user_id', Auth::id())
      ->with('items.product')
      ->latest()
      ->get();
    return view('orders.index', compact('orders'));
  }

  // Buyer: Detail pesanan + upload bayar + review
  public function show(Order $order)
  {
    if ($order->user_id !== Auth::id()) {
      abort(403);
    }
    $order->load('items.product', 'reviews');
    return view('orders.show', compact('order'));
  }

  // Seller: Monitoring pesanan masuk
  public function sellerOrders()
  {
    $productIds = Product::where('user_id', Auth::id())->pluck('id');
    $orderIds = OrderItem::whereIn('product_id', $productIds)
      ->pluck('order_id')
      ->unique();

    $orders = Order::whereIn('id', $orderIds)
      ->with(['items.product', 'user'])
      ->latest()
      ->get();

    return view('seller.orders', compact('orders'));
  }

  // Seller: Update status pesanan
  public function updateStatus(Request $request, Order $order)
  {
    $request->validate([
      'status' => 'required|in:pending,paid,processing,shipped,completed,cancelled'
    ]);

    $oldStatus = $order->status;
    $newStatus = $request->status;

    // Verifikasi seller punya produk di order ini
    $productIds = Product::where('user_id', Auth::id())->pluck('id');
    $hasProduct = $order->items()->whereIn('product_id', $productIds)->exists();

    if (!$hasProduct) {
      abort(403);
    }

    $order->update(['status' => $newStatus]);

    // =============================
    // FIX: Kurangi stok jika status berubah ke "completed"
    // =============================
    if ($newStatus === 'completed' && $oldStatus !== 'completed') {
      foreach ($order->items as $item) {
        $product = $item->product;
        if ($product) {
          // Pastikan stok tidak negatif
          $newStock = max(0, $product->stock - $item->quantity);
          $product->update(['stock' => $newStock]);
        }
      }
    }

    return back()->with('success', 'Status pesanan diperbarui menjadi: ' . ucfirst($newStatus));
  }
}
