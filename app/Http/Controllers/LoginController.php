<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function index()
    {
        return view('login');
    }

    // Memproses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $pengguna = Pengguna::where(
            'email',
            $credentials['email']
        )->first();

        if (
            !$pengguna ||
            !Hash::check(
                $credentials['password'],
                $pengguna->password
            )
        ) {
            return back()
                ->withErrors([
                    'login' => 'Email atau password salah.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        $request->session()->put([
            'id_pengguna' => $pengguna->id_pengguna,
            'nama' => $pengguna->nama,
            'email' => $pengguna->email,
            'role' => $pengguna->role,
        ]);

        if ($pengguna->role === 'Pemilik Kost') {
            return redirect('/dashboard/pemilik');
        }

        if ($pengguna->role === 'Pencari Kost') {
            return redirect('/dashboard/pencari');
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')
            ->withErrors([
                'login' => 'Role akun tidak dikenali.',
            ]);
    }

    // Logout
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('success', 'Kamu berhasil logout.');
    }
}
