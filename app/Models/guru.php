<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class guru extends Model
{
    use HasFactory;
    public function admin() {
        return $this->belongsTo(admin::class, "id","id");
    }
    protected $table = 'dataguru';
    protected $primaryKey = 'idguru';
    protected $fillable = ['id', 'nama', 'mapel'];
}
