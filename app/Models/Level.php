<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    
    protected $table = 'levels';
    public $timestamps = false;

    public function kelas() {
        return $this->hasMany(Kelas::class, 'level_id', 'id');
    }

    public function jenjang() {
        return $this->hasOne(Jenjang::class, 'id', 'jenjang_id');
    }
}
