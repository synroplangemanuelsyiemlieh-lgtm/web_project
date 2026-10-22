<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


class DashboardController extends Controller {
    public function index()
    {
        $loggedInUsername = auth()->user()->username;    

        
        $restaurant = \App\Models\Restaurant::where('username', auth()->user()->username)->firstOrFail();
        
        
        $restaurantId = $restaurant->id;

        $menus = \App\Models\Menu::where('restaurant_id', $restaurantId)
            ->with('category')
            ->latest()
            ->paginate(15);

        $pendingOrders = Order::where('status', 'pending')
            ->whereHas('items.menu', fn ($q) => $q->where('restaurant_id', $restaurantId))
            ->count();

        return view('rest_index', [
            'restaurant'        => $restaurant, // now this is from Restaurant table
            'pendingOrders'     => $pendingOrders,
            'todayReservations' => $restaurant->reservations()->whereDate('date', today())->count(),
            'menuCount'         => $restaurant->menus()->count(),
            'menus'              => $menus,
        ]);
    }

    public function editProfile()
    {
        return view('restaurant.profile.edit', ['restaurant' => auth('restaurant')->user()]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $restaurant = auth('restaurant')->user();

        $data = $request->validate([
            'username'        => ['required', 'string', 'max:255', Rule::unique('restaurants')->ignore($restaurant->id)],
            'name'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'email', Rule::unique('restaurants')->ignore($restaurant->id)],
            'phone_no'        => ['required', 'string', 'max:30'],
            'address'         => ['required', 'string'],
            'no_of_tables'    => ['nullable', 'integer', 'min:0'],
            'operating_hours' => ['nullable', 'string', 'max:255'],
            'description'     => ['nullable', 'string'],
            'password'        => ['nullable', 'string', 'min:8', 'confirmed'],
            'img'             => ['nullable', 'image', 'max:2048'],
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $data['no_of_tables'] = $data['no_of_tables'] ?? 0;

        if ($request->hasFile('img')) {
            if ($restaurant->img) {
                Storage::disk('public')->delete($restaurant->img);
            }
            $data['img'] = $request->file('img')->store('img/restaurants', 'public');
        }

        $restaurant->update($data);

        return redirect()->route('restaurant.dashboard')->with('success', 'Profile updated.');
    }
}
