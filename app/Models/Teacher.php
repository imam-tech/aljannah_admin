<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'teachers';
    public $timestamps = true;
    protected $guarded = [];

    public function jabatan() {
        return $this->hasOne(Jabatan::class, 'id', 'jabatan_id');
    }
}
