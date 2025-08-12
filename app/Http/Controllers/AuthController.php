<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Show admin/operator login form
    public function showLogin()
    {
        return view('auth.login', ['isCustomer' => false]);
    }

    // Show customer login form
    public function showLoginForm()
    {
        return view('auth.login', ['isCustomer' => true]);
    }

    // Handle login for both admin/operator and customer
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $field = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (!Auth::attempt([
            $field => $request->login,
            'password' => $request->password,
        ], $request->remember)) {
            throw ValidationException::withMessages([
                'login' => __('auth.failed'),
            ]);
        }

        $request->session()->regenerate();

        // Redirect based on user type
        if (Auth::user()->type === 'customer') {
            return redirect()->intended(route('customer.dashboard'));
        }

        return redirect()->intended(route('dashboard'));
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
