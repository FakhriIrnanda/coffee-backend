<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Midtrans\Transaction;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createToken(Request $request, int $orderId)
    {
        $order = Order::with(['user', 'items.product'])
            ->where('user_id', $request->user()->id)
            ->findOrFail($orderId);

        $params = [
    'transaction_details' => [
        'order_id' => $order->order_number,
        'gross_amount' => (int) $order->total_amount,
    ],
    'customer_details' => [
        'first_name' => $order->user->name,
        'email' => $order->user->email,
    ],
    'item_details' => $order->items->map(function ($item) {
        return [
            'id' => $item->product_id,
            'price' => (int) $item->price,
            'quantity' => $item->quantity,
            'name' => $item->product->name,
        ];
    })->toArray(),
    'callbacks' => [
        'finish' => config('services.frontend_url') . '/orders/' . $order->id,
    ],
];

        $snapToken = Snap::getSnapToken($params);

        $order->update(['midtrans_token' => $snapToken]);

        return response()->json([
            'snap_token' => $snapToken,
            'client_key' => config('services.midtrans.client_key'),
        ]);
    }

    public function notification(Request $request)
    {
        $notification = new Notification();

        $orderId = $notification->order_id;
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;

        $order = Order::where('order_number', $orderId)->firstOrFail();

        if ($status == 'capture') {
            if ($type == 'credit_card') {
                $order->payment_status = $fraud == 'challenge' ? 'challenge' : 'paid';
                $order->status = $fraud == 'challenge' ? 'pending' : 'processing';
            }
        } elseif ($status == 'settlement') {
            $order->payment_status = 'paid';
            $order->status = 'processing';
        } elseif ($status == 'pending') {
            $order->payment_status = 'pending';
            $order->status = 'pending';
        } elseif (in_array($status, ['deny', 'expire', 'cancel'])) {
            $order->payment_status = 'failed';
            $order->status = 'cancelled';
        }

        $order->save();

        return response()->json(['message' => 'OK']);
    }

    public function markAsPaid(Request $request, int $id)
{
    $order = Order::where('user_id', $request->user()->id)
        ->findOrFail($id);

    /** @var \stdClass $status */
    $status = Transaction::status($order->order_number);
    $transactionStatus = $status->transaction_status;
    $fraudStatus = $status->fraud_status ?? null;

    $isPaid = $transactionStatus === 'settlement'
        || ($transactionStatus === 'capture' && $fraudStatus !== 'challenge');

    if (!$isPaid) {
        return response()->json([
            'message' => 'Payment not verified yet.',
        ], 422);
    }

    $order->update([
        'payment_status' => 'paid',
        'status' => 'processing',
    ]);

    return response()->json([
        'message' => 'Payment confirmed',
        'order' => $order,
    ]);
}
}