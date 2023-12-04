<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WaliKelas extends Model
{
    use HasFactory;
    
    protected $table = 'wali_kelas';
    public $timestamps = true;
    protected $guarded = [];

    public function teacher() {
        return $this->hasOne(Teacher::class, 'id', 'teacher_id');
    }

    public function kelas() {
        return $this->hasOne(Kelas::class, 'id', 'kelas_id');
    }
}
