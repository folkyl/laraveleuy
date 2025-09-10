<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\siswa; // pastikan ini sesuai nama model
use App\Models\guru;
use App\Models\kelas;
use App\Models\walas;

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
        $walasInfo = null;
        $kelasInfo = null;
    
        if (session('admin_role') === 'siswa') {
            $profilSiswa = siswa::where('idsiswa', session('admin_id'))->first();
                        // Cari kelas siswa berdasarkan idsiswa
            if ($profilSiswa) {
                $kelas = Kelas::with('walas')->where('idsiswa', $profilSiswa->idsiswa)->first();
                if ($kelas) {
                    $kelasInfo = $kelas;
                    // Cari info wali kelas
                    if ($kelas->walas) {
                        $walasInfo = guru::where('idguru', $kelas->walas->idguru)->first();
                    }
                }
            }
        }
    
        if (session('admin_role') === 'guru') {
            $profilGuru = guru::where('idguru', session('admin_id'))->first();


                        // Cari kelas yang diajar guru (jika guru adalah wali kelas)
            if ($profilGuru) {
                $walasGuru = Walas::where('idguru', $profilGuru->idguru)->first();
                if ($walasGuru) {
                    // Ambil semua siswa di kelas yang diajar guru ini
                    $siswaDiKelas = Kelas::with('siswa')->where('idwalas', $walasGuru->idwalas)->get();
                    $kelasInfo = $walasGuru;
                    $walasInfo = $siswaDiKelas;
                }
            }
        }
    
        return view('home', compact('listSiswa', 'listGuru', 'profilSiswa', 'profilGuru', 'walasInfo', 'kelasInfo'));
    } 

    public function create()
    {
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        Siswa::create([
            'nama' => $request->nama,
            'tb' => $request->tb,
            'bb' => $request->bb,
            'id' => session('admin_id') // Foreign key ke dataadmin
        ]);
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
