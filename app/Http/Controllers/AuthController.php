<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

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

        // Redirect based on user role
        if (Auth::user()->role === 'customer') {
            return redirect()->intended(route('customer.dashboard'));
        }

        return redirect()->intended(route('dashboard'));
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(Str::random(32)),
                    'role' => 'customer',
                    'provider' => 'google',
                    'provider_id' => $googleUser->getId(),
                ]);
            }

            Auth::login($user);

            return redirect()->intended(route('customer.dashboard'));

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors('Login dengan Google gagal: '.$e->getMessage());
        }
    }

    // Facebook Login
    // public function redirectToFacebook()
    // {
    //     return Socialite::driver('facebook')->redirect();
    // }

    // public function handleFacebookCallback()
    // {
    //     try {
    //         $facebookUser = Socialite::driver('facebook')->user();

    //         $user = User::where('email', $facebookUser->getEmail())->first();

    //         if (!$user) {
    //             $user = User::create([
    //                 'name' => $facebookUser->getName(),
    //                 'email' => $facebookUser->getEmail(),
    //                 'password' => bcrypt(Str::random(32)),
    //                 'role' => 'customer',
    //                 'provider' => 'facebook',
    //                 'provider_id' => $facebookUser->getId(),
    //             ]);
    //         }

    //         Auth::login($user);

    //         return redirect()->intended('/customer/dashboard');

    //     } catch (\Exception $e) {
    //         return redirect()->route('login')->withErrors('Login dengan Facebook gagal: '.$e->getMessage());
    //     }
    // }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20|unique:users',
        ]);

        $user = User::update([
            'phone' => $request->phone,
        ]);

        Auth::login($user);

        return redirect()->route('customer.dashboard');
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
