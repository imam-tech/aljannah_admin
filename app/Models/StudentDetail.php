<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'student_details';
    public $timestamps = true;
}
