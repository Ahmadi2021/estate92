<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;

/**
 * @mixin Builder
 */
class Image extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',


    ];

    public function imageable(){
        return $this->morphTo();

    }
}
