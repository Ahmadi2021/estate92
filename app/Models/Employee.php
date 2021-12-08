<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
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
        return $this->belongsTo(User::class,'user_id');
    }
     public function agency(){
        return $this->belongsTo(Agency::class,'agency_id');
    }

     public function properties(){
        return $this->hasMany(Property::class);
    }

    //  public function projects(){
    //     return $this->hasMany(Project::class);
    // }

    public function childs(){
        return $this->hasMany(Employee::class, 'parent_id');
    }

     public function projects(){
        return $this->morphMany(Project::class,'ownerable');
     }







}
