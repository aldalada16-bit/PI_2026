<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = DB::table('pengguna')
            ->where('email', $request->email)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['login' => 'Email atau password salah.'])
                ->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        $request->session()->put([
            'id_pengguna' => $user->id_pengguna,
            'nama' => $user->nama,
            'role' => $user->role,
        ]);

        if ($user->role === 'Pemilik Kost') {
            return redirect('/dashboard/pemilik');
        }

        return redirect('/login')
            ->withErrors(['login' => 'Role akun ini belum diarahkan ke dashboard.']);
    }
}
