<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'name',
        'logo',
        'phone_number',
        'phone_ext',
        'qr_code',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

     public function employees(){
          return $this->hasMany(Employee::class,'agency_id');
    }

    //  public function projects(){
    //       return $this->hasMany(Project::class);
    // }

    public function projects(){

        return $this->morphMany(Project::class,'projectable');
    }
}
