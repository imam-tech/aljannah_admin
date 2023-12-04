<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPpdbRegistration extends Model
{
    use HasFactory;
    
    protected $table = 'student_ppdb_registrations';
    public $timestamps = false;

    public function student() {
        return $this->hasOne(Student::class, 'id', 'student_id');
    }

    public function ppdb_registration() {
        return $this->hasOne(PpdbRegistration::class, 'id', 'ppdb_registration_id');
    }
}
