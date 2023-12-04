<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PpdbRegistration extends Model
{
    use HasFactory;
    
    protected $table = 'ppdb_registrations';
    protected $guarded = [];

    public function proven_pendaftaran() {
        return $this->hasOne(PpdbRegistrationProvenFile::class, 'ppdb_registration_id', 'id');
    }

    public function proven_bpms() {
        return $this->hasOne(PpdbBpmsProvenFile::class, 'ppdb_registration_id', 'id');
    }

    public function student_ppdb_registration() {
        return $this->hasOne(StudentPpdbRegistration::class, 'ppdb_registration_id', 'id');
    }
}
