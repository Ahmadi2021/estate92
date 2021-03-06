<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'user_id',

    ];

    public function user(){
       return $this->belongsTo(User::class);
    }

    public function images(){
        return $this-> morphMany(Image::class , 'imageable');
    }

    public function commentabl(){
        return $this->morphMany(Comment::class,'commentable');
     }
}
