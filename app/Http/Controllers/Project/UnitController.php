<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnitStoreRequest;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unit =auth()->user()->projects()->with(['floors.units'])->get();
        return response()->json(['message', $unit]);
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
    public function store(UnitStoreRequest $request)
    {    
        $project = auth()->user()->projects->find($request->project_id);
        if(!$project){
             return response()->json(['message'=> 'Project Not Found']);
        }
         $floor = $project->floors()->find($request->floor_id);
         if(!$floor){
             return response()->json(['message'=> 'Floor Not Found']);
        }

         $unit = $floor->units()->create($request->only((new Unit())->getFillable()));
         
          if(!$unit){
             return response()->json(['message'=> 'floor Not Found']);
            }

         
         
         return response()->json(['message'=> 'created successfuly']);
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $project = auth()->user()->projects()->find($request->project_id);
        if(!$project){
            return response()->json(['message'=> 'Project Not Found']);
        }
        //implement check here for project.
        $floors = $project->floors()->find($request->floor_id);

         if(!$floors){
            return response()->json(['message'=> 'Floor Not Found']);
        }
        $unit = $floors->units()->find($id);
    
        if(!$unit){
            return response()->json(['message'=> ' Unit Not found']);
        }
         return response()->json(['message'=> $unit]);
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
    public function update(Request $request, $id)
    {
        $project = auth()->user()->projects()->find($request->project_id);
        if(!$project){
            return response()->json(['message'=> 'Project Not Found']);
        }
        //implement check here for project.
        $floor = $project->floors()->find($request->floor_id);

         if(!$floor){
            return response()->json(['message'=> 'Floor Not Found']);
        }
          $unit = $floor->units()->find($id);
          if(!$unit){
              return response()->json(['message'=> 'Unit Not Found']);
          }
          $unit->update($request->only((new User())->getFillable()));
          
          return response()->json(['message'=> 'Successfuly Added']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {   
        $project= auth()->user()->projects()->find($request->project_id);
        if(!$project){
            return response()->json(['message'=> 'Project Not Found']);
        }
        $floors = $project->floors()->find($request->floor_id);
        if(!$floors){
            return response()->json(['message'=>'Floor Not Found']);
        }
        $units = $floors->units()->find($id);
    
        if(!$units){
          return response()->json(['message'=> 'Unit Not found']);
      }
      $units->delete();
      return response()->json(['message'=> 'Deleted successfully']);

        
    }
}
