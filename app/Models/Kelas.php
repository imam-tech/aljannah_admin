<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    
    protected $table = 'kelas';
    public $timestamps = false;

    public function level() {
        return $this->hasOne(Level::class, 'id', 'level_id');
    }

    public function jenjang() {
        return $this->hasOne(Jenjang::class, 'id', 'jenjang_id');
    }

    public function wali_kelas() {
        return $this->hasOne(WaliKelas::class, 'id', 'wali_kelas_id');
    }
}
