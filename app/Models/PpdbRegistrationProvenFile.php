<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PpdbRegistrationProvenFile extends Model
{
    use HasFactory;
    
    protected $table = 'ppdb_registration_proven_files';
    protected $guarded = [];
}
