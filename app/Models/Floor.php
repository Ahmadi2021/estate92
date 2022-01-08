<?php

namespace App\Models;

use App\Models\Project;
use App\Models\Unit;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class Floor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'project_id',
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function units(){
        return $this->hasMany(Unit::class);
    }
}
