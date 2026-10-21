<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KostController extends Controller
{
    public function index()
    {
        // Ambil data kost milik pengguna yang sedang login
        $id_pengguna = Auth::id() ?? session('id_pengguna');
        $daftarKost = Kost::where('id_pengguna', $id_pengguna)->get();

        return view('kelola_data_kost', compact('daftarKost'));
    }

    public function create()
    {
        return view('tambah_kost');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kost' => 'required',
            'alamat' => 'required',
            'foto_kost' => 'image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_kost')) {
            $fotoPath = $request->file('foto_kost')->store('uploads/kost', 'public');
        }

        Kost::create([
            'id_pengguna' => Auth::id() ?? session('id_pengguna'),
            'nama_kost' => $request->nama_kost,
            'alamat' => $request->alamat,
            'deskripsi' => $request->deskripsi,
            'foto_kost' => $fotoPath,
            'fasilitas' => is_array($request->fasilitas) ? implode(', ', $request->fasilitas) : $request->fasilitas,
        ]);

        return redirect()->route('kost.index')->with('success', 'Data kost berhasil ditambahkan');
    }
}