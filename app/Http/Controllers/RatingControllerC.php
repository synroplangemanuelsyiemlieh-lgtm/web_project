<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuRating;
use App\Models\Order;
use App\Models\Restaurant as RestaurantModel;
use App\Models\RestaurantRating;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    private function rules(): array
    {
        return [
            'rate'    => ['required', 'integer', 'between:1,5'],
            'content' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function storeMenu(Request $request, Menu $menu): RedirectResponse
    {
        $data = $request->validate($this->rules());
        $customerId = auth('customer')->id();

        $hasOrdered = Order::where('customer_id', $customerId)
            ->where('status', 'completed')
            ->whereHas('items', fn ($q) => $q->where('menu_id', $menu->id))
            ->exists();

        if (! $hasOrdered) {
            return back()->withErrors(['rate' => 'You can only rate items from your completed orders.']);
        }

        // One rating per customer per item; rating again updates it
        MenuRating::updateOrCreate(
            ['customer_id' => $customerId, 'menu_id' => $menu->id],
            $data
        );

        return back()->with('success', 'Thanks for your rating.');
    }

    public function storeRestaurant(Request $request, RestaurantModel $restaurant): RedirectResponse
    {
        $data = $request->validate($this->rules());
        $customerId = auth('customer')->id();

        $hasOrdered = Order::where('customer_id', $customerId)
            ->where('status', 'completed')
            ->whereHas('items.menu', fn ($q) => $q->where('restaurant_id', $restaurant->id))
            ->exists();

        if (! $hasOrdered) {
            return back()->withErrors(['rate' => 'You can only rate restaurants you have ordered from.']);
        }

        RestaurantRating::updateOrCreate(
            ['customer_id' => $customerId, 'restaurant_id' => $restaurant->id],
            $data
        );

        return back()->with('success', 'Thanks for your rating.');
    }
}
