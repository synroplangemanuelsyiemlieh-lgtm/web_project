<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        $restaurants = Restaurant::withAvg('ratings', 'rate')
            ->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%'.$request->q.'%'))
            ->paginate(12)
            ->withQueryString();

        return view('restaurants.index', compact('restaurants'));
    }

    public function show(Restaurant $restaurant)
    {
        $restaurant->loadAvg('ratings', 'rate');
        $menus = $restaurant->menus()->with('category')->where('is_avail', true)->get();
        $ratings = $restaurant->ratings()->with('customer')->latest()->paginate(10);

        return view('restaurants.show', compact('restaurant', 'menus', 'ratings'));
    }
    
}
