<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone_number',
        'phone_ext',
        'address',
        'zip_code',
        'area_id',
        'website',
        'gender',
        'dob',
        'user_id'
    ];

     public function user(){
        return $this->belongsTo(User::class);
    }
     public function properties(){
        return $this->hasMany(User::class);
    }
}
