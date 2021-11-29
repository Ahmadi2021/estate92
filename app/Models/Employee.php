<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    
    use HasFactory;
    protected $fillable = [
        'user_id',
        'agency_id',
        'parent_id',
        'name',
        'gender',
        'dob',
        'level',
        'phone_ext',
        'phone_number',
        'slug',
        'address',
        'zip_code',
        'cnic',
    ];

     public function user(){
        return $this->belongsTo(User::class);
    }
     public function agency(){
        return $this->belongsTo(Agency::class);
    }
     
     public function properties(){
        return $this->hasMany(Property::class);
    }

     public function projects(){
        return $this->hasMany(Project::class);
    }

    
    

}
