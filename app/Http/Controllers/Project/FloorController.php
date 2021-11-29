<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\FloorUpdateRequest;
use App\Models\Floor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FloorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return $floor = auth()
                    ->user()
                    ->projects()->with('floors')
                    ->get();
        return response()
                ->json([
                    'message' => $floor
                ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    public function store(Request $request)
    {
        DB::beginTransaction();
        $project = auth()->user()->projects()->find($request->project_id);

        
        if(!$project){
             return response()->json(['message' => 'No project found with the provided id.']);
        }
           

        $floors = $project->floors()->create($request->only((new Floor())->getFillable()));
        if(!$floors){
            DB::rollBack();
            return response()->json(['message' => 'Failed to create floors.']);
        }
        else {
            DB::commit();
            return response()->json(['message' => 'created  successfully']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $floor = auth()->user()->projects()->with('floors')->find($id);
        if(!$floor){
            return response()->json(['message' => 'Not found']);
        }
        return response()->json(['message' => $floor]);
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
    public function update(FloorUpdateRequest $request, $id)
    {   
        DB::beginTransaction();
        $project = auth()->user()->projects()->find($request->project_id);
        
        $floor = $project->floors()->find($id);
        if(!$floor){
            DB::rollBack();
            return response()->json(['message' => 'Not found']);

        }else{
            DB::commit();
            $floor ->update($request->all());
            return response()->json(['message' => 'Updated successfully']); 
        }
       
          
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        return $id;
        $project = auth()->user()->projects()->find($request->project_id);
        $floor = $project->floors()->find($id);
        if(!$floor){
            return response()->json(['message' => 'Not found']);
        }
        $floor ->delete();
            return response()->json(['message' => 'Deleted successfully']);
    }
}
