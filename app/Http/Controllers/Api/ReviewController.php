<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index($productId)
    {
        $reviews = Review::with('user')
            ->where('product_id', $productId)
            ->latest()
            ->get();

        $avgRating = $reviews->avg('rating');

        return response()->json([
            'reviews' => $reviews,
            'avg_rating' => round($avgRating, 1),
            'total' => $reviews->count(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Cek apakah order milik user dan statusnya completed
        $order = Order::where('id', $request->order_id)
            ->where('user_id', $request->user()->id)
            ->where('status', 'completed')
            ->firstOrFail();

        // Cek apakah sudah pernah review produk ini di order ini
        $existing = Review::where('user_id', $request->user()->id)
            ->where('product_id', $request->product_id)
            ->where('order_id', $request->order_id)
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'Kamu sudah memberikan ulasan untuk produk ini',
            ], 422);
        }

        $review = Review::create([
            'user_id' => $request->user()->id,
            'product_id' => $request->product_id,
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'message' => 'Ulasan berhasil ditambahkan!',
            'review' => $review->load('user'),
        ], 201);
    }

    public function destroy(Request $request, $id)
    {
        $review = Review::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $review->delete();

        return response()->json(['message' => 'Ulasan berhasil dihapus']);
    }

    public function featured()
{
    $reviews = Review::with(['user', 'product'])
        ->whereNotNull('comment')
        ->where('rating', '>=', 4)
        ->latest()
        ->get()
        ->unique('user_id')
        ->take(6)
        ->values();

    return response()->json($reviews);
}
}