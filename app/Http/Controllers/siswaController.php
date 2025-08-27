<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\siswa; // pastikan ini sesuai nama model
use App\Models\guru;

class SiswaController extends Controller
{
    public function home()
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('login');
        }
    
        // Daftar semua siswa (untuk tabel)
        $listSiswa = siswa::all();
    
        // Daftar semua guru (misalnya untuk admin yang lihat data guru)
        $listGuru = guru::all();
    
        // Profil sesuai role login
        $profilSiswa = null;
        $profilGuru = null;
    
        if (session('admin_role') === 'siswa') {
            $profilSiswa = siswa::where('id', session('admin_id'))->first();
        }
    
        if (session('admin_role') === 'guru') {
            $profilGuru = guru::where('id', session('admin_id'))->first();
        }
    
        return view('home', compact('listSiswa', 'listGuru', 'profilSiswa', 'profilGuru'));
    } 

    public function create()
    {
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        Siswa::create($request->only('nama', 'tb', 'bb'));
        return redirect()->route('home');
    }

    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->update($request->only('nama', 'tb', 'bb'));
        return redirect()->route('home');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();
        return redirect()->route('home');
    }
}
