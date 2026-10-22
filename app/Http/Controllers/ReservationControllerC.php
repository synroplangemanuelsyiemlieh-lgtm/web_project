<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Restaurant as RestaurantModel;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = auth('customer')->user()
            ->reservations()
            ->with('restaurant')
            ->orderByDesc('date')
            ->orderByDesc('time')
            ->paginate(10);

        return view('customer.reservations.index', compact('reservations'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'restaurant_id' => ['required', 'exists:restaurants,id'],
            'date'          => ['required', 'date', 'after_or_equal:today'],
            'time'          => ['required', 'date_format:H:i'],
        ]);

        $data['time'] = Carbon::createFromFormat('H:i', $data['time'])->format('H:i:s');

        $restaurant = RestaurantModel::findOrFail($data['restaurant_id']);

        // Don't book more reservations at one time slot than the restaurant has tables
        $taken = Reservation::where('restaurant_id', $restaurant->id)
            ->whereDate('date', $data['date'])
            ->where('time', $data['time'])
            ->count();

        if ($restaurant->no_of_tables > 0 && $taken >= $restaurant->no_of_tables) {
            return back()->withErrors(['time' => 'No tables left at that time. Please choose another.'])->withInput();
        }

        auth('customer')->user()->reservations()->create($data);

        return redirect()->route('customer.reservations.index')->with('success', 'Reservation booked.');
    }

    public function destroy(Reservation $reservation): RedirectResponse
    {
        abort_unless($reservation->customer_id === auth('customer')->id(), 403);

        $reservation->delete();

        return back()->with('success', 'Reservation cancelled.');
    }
}
