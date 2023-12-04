<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'students';
    public $timestamps = true;

    public function student_details() {
        return $this->hasOne(StudentDetail::class, 'student_id', 'id');
    }

    public function student_ppdb_registration() {
        return $this->hasOne(StudentPpdbRegistration::class, 'student_id', 'id');
    }

    public function user_parent() {
        return $this->hasOne(UserParent::class, 'student_id', 'id');
    }
}
