<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Menampilkan halaman registrasi.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Memproses registrasi pengguna baru.
     * PRD 4.1: nama, email, telepon, password+konfirmasi
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:150',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|string|max:20',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        // Password otomatis di-hash via cast atau model method
        $user = User::createCustomer($data); 
        
        Auth::login($user);
        
        return redirect()->route('home')->with('success', 'Registrasi berhasil!');
    }

    /**
     * Memproses login pengguna.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            // Pesan umum, tidak bocorkan detail (NFR-01)
            return back()->withErrors(['email' => 'Email atau kata sandi salah.']);
        }

        $request->session()->regenerate();

        /** 
         * @var \App\Models\User $currentUser 
         * PHPDoc di atas wajib ada untuk memberi tahu IDE tipe data eksak, 
         * sehingga error "Undefined method" pada Auth::user() atau isAdmin() akan hilang.
         */
        $currentUser = Auth::user();

        return $currentUser->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('home');
    }

    /**
     * Memproses logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home');
    }
}