<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Http\Requests\Floors\FloorIndexRequest;
use App\Http\Requests\Units\UnitDeleteRequest;
use App\Http\Requests\Units\UnitIndexRequest;
use App\Http\Requests\Units\UnitShowRequest;
use App\Http\Requests\Units\UnitStoreRequest;
use App\Http\Requests\Units\UnitUpdateRequest;

use App\Models\Unit;
use App\Models\User;
use App\Traits\UserRole;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    use UserRole;
    public $owner;
    
    public function __construct()
    {
        $this->middleware(function( $request, $next){
            $this->owner = $this->check_role(auth()->user()->getRoleNames()->first());
            return  $next($request);
      
        });
        
    }
    public function index(UnitIndexRequest $request)
    {
        // return auth()->user()->getRoleNames()->first();
       if(!$this->owner){
            return response()->json(['message'=> 'User Not Found']);
       } 
       $project = $this->owner->projects->find($request->project_id);
        if(!$project){

            return response()->json(['message'=> 'Project Not Found']);
       } 
       $floor = $project->floors()->with('units')->find($request->floor_id);
       
       if(!$floor){
            return response()->json(['message'=> 'Floor Not Found']);
       } 

    
        return response()->json(['data'=> $floor]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitStoreRequest  $request)
    {    
         
        if(!$this->owner){

            return response()->json(['message'=> 'User Not Found']);
       } 
        $project = $this->owner->projects->find($request->project_id);
        
        if(!$project){
             return response()->json(['message'=> 'Project Not Found']);
        }
         $floor = $project->floors()->find($request->floor_id);
         if(!$floor){
             return response()->json(['message'=> 'Floor Not Found']);
        }

         $unit = $floor->units()->create($request->only((new Unit())->getFillable()));
         
        if(!$unit){
             return response()->json(['message'=> 'Unit Not Found']);
            }

         
         
         return response()->json(['message'=> 'created successfuly']);
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(UnitShowRequest $request, $id)
    {
        if(!$this->owner){
            return response()->json(['message'=> 'User Not Found']);
       } 
       $project = $this->owner->projects->find($request->project_id);
        if(!$project){

            return response()->json(['message'=> 'Project Not Found']);
       } 
       $unit = $project->floors()->with(['units'=> function($query) use($id){
            $query->find($id);
       }])->find($request->floor_id);
       if(!$unit){
            return response()->json(['message'=> 'Floor Not Found']);
       } 
       
        return response()->json(['data'=> $unit]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UnitUpdateRequest $request, $id)
    {
        if(!$this->owner){
            return response()->json(['message'=> 'User Not Found']);
       } 
       $project = $this->owner->projects->find($request->project_id);
        if(!$project){

            return response()->json(['message'=> 'Project Not Found']);
       } 
       $floor = $project->floors()->find($request->floor_id);
       if(!$floor){
            return response()->json(['message'=> 'Floor Not Found']);
       } 

       $unit = $floor->units()->find($unit_id);
        return response()->json(['data'=> $unit]);
          $unit->update($request->only((new User())->getFillable()));
          
          return response()->json(['message'=> 'Successfuly Added']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(UnitDeleteRequest $request,$unit_id)
    {   
        if(!$this->owner){
            return response()->json(['message'=> 'User Not Found']);
       } 
       $project = $this->owner->projects->find($request->project_id);
        if(!$project){

            return response()->json(['message'=> 'Project Not Found']);
       } 
       $floor = $project->floors()->find($request->floor_id);
       if(!$floor){
            return response()->json(['message'=> 'Floor Not Found']);
       } 

       $unit = $floor->units()->find($unit_id);
       $unit->delete();
       return response()->json(['message'=> 'Deleted Successfully']);
        
    }
}
