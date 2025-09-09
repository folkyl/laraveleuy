<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class siswa extends Model
{
    use HasFactory;

    protected $table = 'datasiswa';
    protected $primaryKey = 'idsiswa';

    protected $fillable = [
        'nama',
        'tb',
        'bb'
    ];

    public function admin()
    {
        return $this->belongsTo(admin::class, 'idadmin', 'idadmin');
    }
}
