<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /** Orders that contain at least one item from the logged-in restaurant. */
    private function ownOrders()
    {
        $restaurantId = auth('restaurant')->id();

        return Order::whereHas('items.menu', fn ($q) => $q->where('restaurant_id', $restaurantId));
    }

    public function index(Request $request)
    {
        $orders = $this->ownOrders()
            ->with(['customer', 'payment'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('restaurant.orders.index', compact('orders'));
    }

    public function show(int $order)
    {
        $order = $this->ownOrders()
            ->with(['customer', 'items.menu', 'payment'])
            ->findOrFail($order);

        return view('restaurant.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, int $order): RedirectResponse
    {
        $order = $this->ownOrders()->findOrFail($order);

        $data = $request->validate([
            'status' => ['required', Rule::in(['pending', 'preparing', 'completed', 'cancelled'])],
        ]);

        $order->update($data);

        return back()->with('success', 'Order status updated.');
    }

    public function markPaid(int $order): RedirectResponse
    {
        $order = $this->ownOrders()->with('payment')->findOrFail($order);

        if (! $order->payment) {
            return back()->withErrors(['payment' => 'This order has no payment record.']);
        }

        $order->payment->update([
            'status'      => 'paid',
            'amount_paid' => $order->amount,
            'settled_at'  => now(),
        ]);

        return back()->with('success', 'Payment marked as paid.');
    }
}
