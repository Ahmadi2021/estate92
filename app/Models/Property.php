<?php

namespace App\Models;

use App\Casts\NameCast;
use App\Casts\PriceCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'property_type',
        'address',
        'description',
        'size',
        'price',
        'state',
        'no_of_bed',
        'no_of_bathroom',
        'user_id',
    ];

    protected $casts = [
       'price' => PriceCast::class,
       'name' => NameCast::class,
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
     }

     public function images(){
        return $this->morphMany(Image::class,'imageable'); 
     }

     public function commentabl(){
        return $this->morphMany(Comment::class,'commentable'); 
     }

   

      public function empolyee(){
        return $this->belongsTo(Employee::class);
     }
      public function customer(){
        return $this->belongsTo(Customer::class);
     }



}
