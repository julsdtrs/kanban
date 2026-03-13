<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required',
        ]);

        $login = $credentials['login'];
        $password = $credentials['password'];

        $user = \App\Models\User::where('email', $login)
            ->orWhere('username', $login)
            ->first();

        if (!$user || !$user->is_active || !\Illuminate\Support\Facades\Hash::check($password, $user->password_hash)) {
            throw ValidationException::withMessages(['login' => __('auth.failed')]);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
