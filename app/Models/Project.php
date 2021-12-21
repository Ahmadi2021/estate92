<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class Project extends Model
{
    use HasFactory;

    // protected $fillable = [
    //    'name'
    // ];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'code',
        'phone_number',
        'ownerable_id',
        'ownerable_type',
        'address',
    ];

    public function floors(){
        return $this->hasMany(Floor::class);
    }

    public function comments(){
        return $this->morphMany(Comment::class,'commentable');
    }

    public function images(){
       return $this->morphMany(Image::class,'imageable');
    }

   public function agency(){
        return $this->belongsTo(Agency::class);
    }
    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    public function ownerable(){
        return $this->morphTo();
    }

    public function units(){
        return $this->hasManyThrough(Unit::class,Floor::class);
    }




    public function scopeActive(){
        return $this->where('is_active', 1);
    }


    public function scopeSelectProjects(){

         return $this->with(['images', 'user','floors'=>function($q){
                            $q->with(['units' =>function($q){
                                  $q->with(['images'=>function($q){
                                      $q->select('id','imageable_id','image');
                                  }])
                                //   Select For Unit
                                ->select('id','name','floor_id');
                            }])
                            // Select For Floors
                            ->select('id','name','project_id');

                           }])
                        //  Select For Project
                           ->select('id','name','description','user_id');

    }

}
