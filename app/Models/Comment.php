<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;

/**
 * @mixin Builder
 */
class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'body',
        'email',
        'rate',
        'commentable_type',
        'commentable_id'


    ];

    public function commentable(){
           return $this->morphTo();
    }
}
