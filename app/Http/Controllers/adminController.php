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
            session([
                'admin_id' => $admin->id,
                'admin_username' => $admin->username,
                'admin_role' => $admin->role
            ]);
            return redirect()->route('home');
        }
        return back()->with('error', 'Username atau password salah.');
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

             // Kalau role guru → simpan juga ke tabel dataguru
             if ($request->role === 'guru') {
                $request->validate([
                    'nama_guru'  => 'required|string|max:100',
                    'mapel_guru' => 'required|string|max:100',
                ]);
            
                Guru::create([
                    'id'    => $admin->id,
                    'nama'  => $request->nama_guru,
                    'mapel' => $request->mapel_guru,
                ]);
            }
            
            if ($request->role === 'siswa') {
                $request->validate([
                    'nama_siswa' => 'required|string|max:100',
                    'tb_siswa'   => 'required|numeric',
                    'bb_siswa'   => 'required|numeric',
                ]);
            
                Siswa::create([
                    'id'   => $admin->id,
                    'nama' => $request->nama_siswa,
                    'tb'   => $request->tb_siswa,
                    'bb'   => $request->bb_siswa,
                ]);
            }

            return redirect()->back()->with('success', 'Registrasi berhasil!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Registrasi gagal: ' . $e->getMessage());
        }
    }
    public function logout()
    {
        //hapus session
        session()->forget(['admin_id', 'admin_username']);
        return redirect()->route('landing');
    }
}
