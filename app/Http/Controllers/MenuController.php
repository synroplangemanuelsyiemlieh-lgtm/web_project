<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $menus = Menu::with(['restaurant', 'category'])
            ->withAvg('ratings', 'rate')
            ->where('is_avail', true)
            ->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%'.$request->q.'%'))
            ->when($request->filled('category_id'), fn ($q) => $q->where('category_id', $request->category_id))
            ->when($request->filled('restaurant_id'), fn ($q) => $q->where('restaurant_id', $request->restaurant_id))
            ->when($request->boolean('veg'), fn ($q) => $q->where('is_veg', true))
            ->paginate(12)
            ->withQueryString();

        return view('menus.index', [
            'menus'      => $menus,
            'categories' => Category::all(),
        ]);
    }

    public function show(Menu $menu)
    {
        $menu->load(['restaurant', 'category'])->loadAvg('ratings', 'rate');
        $ratings = $menu->ratings()->with('customer')->latest()->paginate(10);

        return view('menus.show', compact('menu', 'ratings'));
    }
}
