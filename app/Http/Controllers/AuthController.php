<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request) {
        $credentials = $request->validate([
            'full_name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email', 'unique:users'],
            'password' => ['required', 'min:3'],
        ]);

        $user = User::create($credentials);

        Auth::login($user);

        return redirect()->route('home');
    }

    public function login(Request $request) {
        // Xác thực
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:3'],
        ]);


        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            return redirect()->intended(
                $user->role === 'ADMIN' ? route('admin.products.index') : route('home')
            );
        } else {
            return back()->withErrors([
                'email_login' => 'Xin vui lòng kiểm tra lại email hoặc mật khẩu.',
            ])->onlyInput('email_login');
        }
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function index()
    {
        return view('auth.auth-master');
    }
}
