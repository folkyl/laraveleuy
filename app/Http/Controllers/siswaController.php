<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa; // pastikan ini sesuai nama model

class SiswaController extends Controller
{
    public function home()
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('login');
        }

        $siswa = Siswa::all(); // gunakan nama kelas, bukan string
        return view('home', compact('siswa'));
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
