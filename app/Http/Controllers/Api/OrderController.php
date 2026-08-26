<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['items.product', 'reviews'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $request->validate([
            'notes' => 'nullable|string',
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', $request->user()->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Keranjang kosong'], 400);
        }

        // Cek stok
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return response()->json([
                    'message' => 'Stok ' . $item->product->name . ' tidak mencukupi',
                ], 400);
            }
        }

        // Hitung subtotal
        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Buat order
        $order = Order::create([
            'user_id' => $request->user()->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'status' => 'pending',
            'total_amount' => $subtotal,
            'notes' => $request->notes,
        ]);

        // Buat order items & kurangi stok
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
            $item->product->decrement('stock', $item->quantity);
        }

        // Hapus cart
        Cart::where('user_id', $request->user()->id)->delete();

        return response()->json([
            'message' => 'Order berhasil dibuat',
            'order' => $order->load('items.product'),
        ], 201);
    }

    public function show(Request $request, int $id)
    {
        $order = Order::with(['items.product'])
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        return response()->json($order);
    }
}