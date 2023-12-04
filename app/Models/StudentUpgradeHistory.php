<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentUpgradeHistory extends Model
{
    use HasFactory;
    
    protected $table = 'student_upgrade_histories';
    public $timestamps = false;
}
