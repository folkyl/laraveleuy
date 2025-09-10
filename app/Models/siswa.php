<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class siswa extends Model
{
    use HasFactory;
    public function admin()
    {
        return $this->belongsTo(admin::class, 'id', 'id');
    }
    protected $table = 'datasiswa';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
        'tb',
        'bb',
        'username',
        'password'
    ];
}
