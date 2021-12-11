<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Http\Requests\Floors\FloorDeleteRequest;
use App\Http\Requests\Floors\FloorIndexRequest;
use App\Http\Requests\Floors\FloorShowRequest;
use App\Http\Requests\FloorStoreRequest;
use App\Http\Requests\FloorUpdateRequest;
use App\Models\Agency;
use App\Models\Floor;
use App\Models\Project;
use App\Traits\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FloorController extends Controller
{
    use UserRole;

    public $owner;
  
    public function __construct()
    {
    
        $this->middleware(function($request, $next){
            $this->owner = $this->check_role(auth()->user()->getRoleNames()->first());
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FloorIndexRequest $request)
    {  
        
        if(!$this->owner)
            return  response()->json(['message'=>'No User found']);
        $project = $this->owner->projects()->find($request->project_id);
        if(!$project)
            return  response()->json(['message' => 'No Project Found']);
        $floor = $project->floors()->get();
        if(!$floor)
            return  response()->json(['message' => 'No project floors found']);
        return response()->json(['data' => $floor]);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FloorStoreRequest $request)
    {   
       
        DB::beginTransaction();
        if(!$this->owner){
            
            return response()->json(['message'=>' User Not Found']);
        }

            
         $project = $this->owner->projects()->find($request->project_id);
             if(!$project){
                return response()->json(['message' => 'No project found with the provided id.']);
            } 
      
        $project_floor = $project->floors()->create($request->only((new Floor)->getFillable()));
        if($project_floor){
            DB::commit();
            return response()->json(['message' => 'Created Successfully']);
        }
        else {
            DB::rollBack();
            return response()->json(['message' => 'Error Occure']);
        }
           
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FloorShowRequest $request  , $floor_id  )
    {   
       if(!$this->owner){
           return  response()->json(['message'=>'User Not Found']);
       }
         
        $project = $this->owner->projects()->find($request->project_id);
        if(!$project)
        {
            return  response()->json(['message'=>'Project Not Found']);
        }
        $floor = $project->floors()->find($floor_id);

        if(!$floor)
        {
            return response()->json(['message'=>'Project floor Not Found']);
        }
         return response()->json(['data'=>$floor]);
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
    public function update(FloorUpdateRequest $request, $floor_id)
    {
        DB::beginTransaction();
        if(!$this->owner){
            return response()->json(['message' => 'User Not Found']);
        }
            
      $project = $this->owner->projects()->find($request->project_id);
           if(!$project){
               return  response()->json(['message'=>'Project Not Found']);
           }
      $floor = $project->floors()->find($floor_id);
           
       
       $floor->update($request->only((new Floor)->getFillable()));
       if($floor){
        DB::commit();
       return  response()->json(['message'=>'Updated Successfuly']);
       }
       
       else{

         DB::rollBack();
         return  response()->json(['message'=>'Updated Successfuly']);
       }
       
       
          
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FloorDeleteRequest $request, $floor_id)
    {
        
 
       if(!$this->owner){
            return response()->json(['message'=> 'Not Found']);
       }
           $project = $this->owner->projects()->find($request->project_id);
           if(!$project){
               return  response()->json(['message'=>'Project Not Found']);
           }
          $floor = $project->floors()->find($floor_id);
        $delete = $floor->delete();
        if(!$delete)
            return response()->json(['message' => 'Failed to delete the floor']);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
