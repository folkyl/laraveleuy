<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class siswa extends Model
{
    use HasFactory;
    protected $table = 'datasiswa';
    protected $fillable = [
        'id',
        'nama',
        'tb',
        'bb'
    ];
    protected $primaryKey = 'idsiswa';

    public function admin()
    {
        return $this->belongsTo(admin::class, 'id');
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

        return view('home', compact('guru', 'siswa'));
    }
}
