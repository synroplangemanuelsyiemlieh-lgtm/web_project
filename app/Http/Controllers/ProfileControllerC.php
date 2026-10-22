<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        return view('customer.profile.show', ['customer' => auth('customer')->user()]);
    }

    public function edit()
    {
        return view('customer.profile.edit', ['customer' => auth('customer')->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $customer = auth('customer')->user();

        $data = $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('customers')->ignore($customer->id)],
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', Rule::unique('customers')->ignore($customer->id)],
            'phone_no' => ['required', 'string', 'max:30'],
            'address'  => ['required', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'img'      => ['nullable', 'image', 'max:2048'],
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        if ($request->hasFile('img')) {
            if ($customer->img) {
                Storage::disk('public')->delete($customer->img);
            }
            $data['img'] = $request->file('img')->store('img/customers', 'public');
        }

        $customer->update($data);

        return redirect()->route('customer.profile.show')->with('success', 'Profile updated.');
    }
}
