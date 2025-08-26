<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\admin;
use Illuminate\Support\Facades\Hash;
use Exception;
use App\Models\siswa;
use App\Models\guru;


class adminController extends Controller
{

    public function formLogin()

    {
        return view('login');
    }

    public function prosesLogin(Request $request)
    {

        $admin = admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            // simpan ke session
            session(['admin_id' => $admin->id, 'admin_username' => $admin->username, 'admin_role' => $admin->role]);
            return redirect()->route('home');
        }
        return back()->with('error', 'Username atau password salah.');
    }

    public function logout()
    {
        //hapus session
        session()->forget(['admin_id', 'admin_username']);
        return redirect()->route('landing');
    }

    public function formRegister()
    {
        return view('register');
    }

    public function prosesRegister(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string|max:50|unique:dataadmin,username',
                'password' => 'required|string|min:8',
                'role'     => 'required|string|in:admin,guru,siswa',
            ]);

            // simpan ke dataadmin
            $admin = admin::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role'     => $request->role,
            ]);

            // insert detail kalau guru
            if ($request->role === 'guru') {
                \App\Models\guru::create([
                    'id'    => $admin->id,
                    'nama'  => $request->nama,
                    'mapel' => $request->mapel,
                ]);
            }

            // insert detail kalau siswa
            if ($request->role === 'siswa') {
                \App\Models\siswa::create([
                    'id'   => $admin->id,
                    'nama' => $request->nama,
                    'tb'   => $request->tb,
                    'bb'   => $request->bb,
                ]);
            }

            return redirect()->back()->with('success', 'Registrasi berhasil!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Registrasi gagal: ' . $e->getMessage());
        }
    }


    public function home()
    {
        $adminId = session('admin_id');
        $adminRole = session('admin_role');

        $guru = null;
        $siswa = null;

        if ($adminRole === 'guru') {
            $guru = guru::where('id', $adminId)->first();
        } elseif ($adminRole === 'siswa') {
            $siswa = siswa::where('id', $adminId)->first();
        }

        // Cek jika ingin menampilkan daftar semua siswa:
        $listSiswa = siswa::all(); // atau Siswa::all()

        return view('home', compact('guru', 'siswa', 'listSiswa'));
    }
}
