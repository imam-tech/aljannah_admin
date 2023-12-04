<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subdistrict extends Model
{
    use HasFactory;
    
    protected $table = 'subdistricts';
    public $timestamps = false;

    public function city() {
        return $this->hasOne(City::class, 'id', 'city_id');
    }
}
