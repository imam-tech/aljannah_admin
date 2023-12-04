<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PpdbBpmsProvenFile extends Model
{
    use HasFactory;
    
    protected $table = 'ppdb_bpms_proven_files';
    protected $guarded = [];
}
