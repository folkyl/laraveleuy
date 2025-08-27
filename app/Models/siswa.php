<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class siswa extends Model
{
    use HasFactory;
    public function admin()
    {
        return $this->belongsTo(admin::class, 'id','id');
    }
    protected $table = 'datasiswa';
    protected $fillable = [
        'id',
        'nama',
        'tb',
        'bb'
    ];
    protected $primaryKey = 'idsiswa';
}
