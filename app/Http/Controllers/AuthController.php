<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            // Redirect based on user role
            if (Auth::user()->role === 'owner') {
                return redirect()->route('owner.dashboard');
            } else {
                return redirect()->route('kasir.dashboard');
            }
        }
        
        return view('login.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }

        Auth::login($user, $request->boolean('remember-me'));

        $request->session()->regenerate();

        // Redirect based on user role
        if ($user->role === 'owner') {
            return redirect()->intended(route('owner.dashboard'));
        } else {
            return redirect()->intended(route('kasir.dashboard'));
        }
        
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
