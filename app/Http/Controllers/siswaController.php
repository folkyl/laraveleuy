<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\siswa; // pastikan ini sesuai nama model
use App\Models\guru;
use App\Models\kelas;
use App\Models\walas;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin; // pastikan ini sesuai dengan namespace model Admin

class SiswaController extends Controller
{
    public function home()
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('login');
        }

        $role = session('admin_role');
        $username = session('admin_username');
        $profilGuru = null;
        $profilSiswa = null;
        $listSiswa = null;
        $listGuru = null;

        if ($role === 'guru') {
            // cari akun admin/guru berdasarkan username
            $admin = Admin::where('username', $username)->first();

            if ($admin) {
                // ambil guru yang FK id = id admin
                $profilGuru = Guru::where('id', $admin->id)->first();
            }
        } elseif ($role === 'siswa') {
            // cari akun admin siswa berdasarkan username
            $admin = Admin::where('username', $username)->first();

            if ($admin) {
                // kalau tabel datasiswa punya kolom username
                $profilSiswa = Siswa::where('username', $username)->first();

                // kalau tabel datasiswa FK ke id admin, ganti dengan ini:
                // $profilSiswa = Siswa::where('id', $admin->id)->first();
            }
        } elseif ($role === 'admin') {
            $listSiswa = Siswa::all();
            $listGuru  = Guru::all();
        }

        return view('home', [
            'profilGuru'  => $profilGuru,
            'profilSiswa' => $profilSiswa,
            'listSiswa'   => $listSiswa,
            'listGuru'    => $listGuru,
        ]);
    }



    public function create()
    {
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'tb' => 'required|numeric',
            'bb' => 'required|numeric',
            'username' => 'required|unique:datasiswa,username', // ganti di sini
            'password' => 'required|min:6',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Siswa::create($validated);

        return redirect()->route('home')->with('success', 'Siswa berhasil ditambahkan!');
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
