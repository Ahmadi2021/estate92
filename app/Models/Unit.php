<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Floor;

class Unit extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'size',
        'status',
        'unit_number',
        'floor_id',
    ];

    public function floor(){
        return $this->belongsTo(Floor::class);
    }

    public function images(){
        return $this->morphMany(Image::class , 'imageable');
    }
}
