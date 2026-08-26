<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function exportCSV(Request $request)
    {
        $request->validate([
            'period' => 'required|in:daily,weekly,monthly,custom',
            'start_date' => 'required_if:period,custom|date',
            'end_date' => 'required_if:period,custom|date',
        ]);

        $query = Order::with(['user', 'items.product']);

        switch ($request->period) {
            case 'daily':
                $query->whereDate('created_at', today());
                break;
            case 'weekly':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'monthly':
                $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
                break;
            case 'custom':
                $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
                break;
        }

        $orders = $query->latest()->get();

        $filename = 'orders_' . $request->period . '_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($orders) {
            $file = fopen('php://output', 'w');

            // Header CSV
            fputcsv($file, [
                'Order Number',
                'Customer',
                'Email',
                'Items',
                'Total',
                'Status',
                'Payment Status',
                'Date',
            ]);

            foreach ($orders as $order) {
                $items = $order->items->map(fn($item) => $item->product->name . ' x' . $item->quantity)->join(', ');

                fputcsv($file, [
                    $order->order_number,
                    $order->user->name,
                    $order->user->email,
                    $items,
                    $order->total_amount,
                    $order->status,
                    $order->payment_status,
                    $order->created_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function summary(Request $request)
    {
        $request->validate([
            'period' => 'required|in:daily,weekly,monthly,custom',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $query = Order::with(['items.product']);

        switch ($request->period) {
            case 'daily':
                $query->whereDate('created_at', today());
                break;
            case 'weekly':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'monthly':
                $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
                break;
            case 'custom':
                $query->whereBetween('created_at', [$request->start_date, $request->end_date . ' 23:59:59']);
                break;
        }

        $orders = $query->get();

        return response()->json([
            'total_orders' => $orders->count(),
            'total_revenue' => $orders->sum('total_amount'),
            'completed_orders' => $orders->where('status', 'completed')->count(),
            'pending_orders' => $orders->where('status', 'pending')->count(),
            'cancelled_orders' => $orders->where('status', 'cancelled')->count(),
            'orders' => $orders->map(fn($order) => [
                'order_number' => $order->order_number,
                'customer' => $order->user?->name,
                'total' => $order->total_amount,
                'status' => $order->status,
                'payment_status' => $order->payment_status,
                'date' => $order->created_at->format('d/m/Y H:i'),
                'items' => $order->items->map(fn($item) => [
                    'name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]),
            ]),
        ]);
    }
}