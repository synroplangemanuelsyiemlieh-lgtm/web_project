<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth('customer')->user()
            ->orders()
            ->with('payment')
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'type'              => ['required', Rule::in(['dine-in', 'pickup'])],
            'method'            => ['required', Rule::in(['cash', 'card', 'online'])],
            'items'             => ['required', 'array', 'min:1'],
            'items.*.menu_id'   => ['required', 'integer', 'exists:menus,id'],
            'items.*.quantity'  => ['required', 'integer', 'min:1', 'max:50'],
        ]);

        // Merge duplicate lines: [menu_id => total quantity]
        $quantities = collect($data['items'])
            ->groupBy('menu_id')
            ->map(fn ($rows) => $rows->sum('quantity'));

        $menus = Menu::whereIn('id', $quantities->keys())->get();

        if ($menus->pluck('restaurant_id')->unique()->count() > 1) {
            return back()->withErrors(['items' => 'An order can only contain items from one restaurant.'])->withInput();
        }

        if ($menus->contains(fn ($menu) => ! $menu->is_avail)) {
            return back()->withErrors(['items' => 'One or more items are not available.'])->withInput();
        }

        // Price is always calculated on the server, never trusted from the form
        $amount = $menus->sum(fn ($menu) => $menu->price * $quantities[$menu->id]);

        $order = DB::transaction(function () use ($data, $menus, $quantities, $amount) {
            $order = Order::create([
                'customer_id' => auth('customer')->id(),
                'status'      => 'pending',
                'type'        => $data['type'],
                'amount'      => round($amount, 2),
            ]);

            foreach ($menus as $menu) {
                $order->items()->create([
                    'menu_id'         => $menu->id,
                    'quantity'        => $quantities[$menu->id],
                    'bought_at_price' => $menu->price,
                ]);
            }

            $order->payment()->create([
                'method'      => $data['method'],
                'status'      => 'pending',
                'amount_paid' => 0,
            ]);

            return $order;
        });

        return redirect()->route('customer.orders.show', $order)->with('success', 'Order placed.');
    }

    public function show(Order $order)
    {
        abort_unless($order->customer_id === auth('customer')->id(), 403);

        $order->load(['items.menu.restaurant', 'payment']);

        return view('customer.orders.show', compact('order'));
    }

    public function cancel(Order $order): RedirectResponse
    {
        abort_unless($order->customer_id === auth('customer')->id(), 403);

        if ($order->status !== 'pending') {
            return back()->withErrors(['status' => 'Only pending orders can be cancelled.']);
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Order cancelled.');
    }
}
