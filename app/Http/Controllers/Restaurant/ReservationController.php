<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $reservations = auth('restaurant')->user()
            ->reservations()
            ->with('customer')
            ->when($request->filled('date'), fn ($q) => $q->whereDate('date', $request->date))
            ->orderBy('date')
            ->orderBy('time')
            ->paginate(20)
            ->withQueryString();

        return view('restaurant.reservations.index', compact('reservations'));
    }
}
