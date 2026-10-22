<?php

namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Restaurant;
use App\Models\User;
use App\Http\Controllers\restaurant\DashboardController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view("register");
    }
    
    public function register(Request $request): RedirectResponse
    {
        // 1. Validate the form data strictly
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|in:customer,restaurant',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 2. Insert data into the database using the User model
        // (Note: The password will be auto-hashed thanks to the model's casts method!)
        User::create($validatedData);
         if ($validatedData['role'] === 'customer') {
                Customer::create([
                'name' => $validatedData['name'],
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'], // Auto-hashed by User model!
            ]);
            }
        else{
            Restaurant::create([
                'name' => $validatedData['name'],
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'], // Auto-hashed by User model!
            ]);
            }
        

        // 3. Redirect to a method inside another controller
        // This targets the 'index' method inside DashboardController
        //return redirect()->action([DashboardController::class, 'index'])
        return  redirect()->to("/welcome")
            ->with('success', 'Account created successfully!');
    }
     public function showLogin()
    {
        return view("welcome");
    }
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();

        if ($user->role === 'admin') {
            return view('/admin1');
        } elseif ($user->role === 'restaurant') {
            return redirect()->action([DashboardController::class, 'index']);
        } else {
            return redirect('/welcome'); 
        }
    }

    return back()->withErrors(['username' => 'Wrong credentials'])->withInput();
    }
    public function Logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return view("welcome");
    }
        
}
    


