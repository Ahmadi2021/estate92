<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Floors\FloorIndexRequest;
use App\Http\Requests\FloorStoreRequest;
use App\Http\Requests\FloorUpdateRequest;
use App\Models\Agency;
use App\Models\Floor;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FloorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FloorIndexRequest $request)
    {  
         //////////////////// Agency//////////////////
       if(auth()->user()->hasRole('agency')){
            $agency = auth()->user()->agency;
            if(!$agency){
                return  response()->json(['message'=>'Agency Not Found']);
            }
           $floors = $agency->projects()->with(['floors'])->get();
           
       }
       ///////////// Sale-head , Sale-manager , Csr ////////////////

       elseif(auth()->user()->hasRole('sale-head') || auth()->user()->hasRole('sale-manager')
       || auth()->user()->hasRole('csr')){
           $employee = auth()->user()->employee;

           if(!$employee){
                return  response()->json(['message'=>'Employee Not Found']);
            }
            $floors = $employee->projects()->with(['floors'])->get();
            

       }
       //////////////// Customer /////////////////////////////
       else{
         $floors = Project::with(['floors'])->get();  
       }
        
        return response()
                ->json([
                    'data' => $floors
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
    public function store(FloorStoreRequest $request)
    {
        DB::beginTransaction();

        // return auth()->user()->getRoleNames();
      //////////////////////////////////// Agency ////////////////////


        if(auth()->user()->hasRole('agency')){
            
         $agency = auth()->user()->agency;
            if(!$agency){
                DB::rollBack();
                return  response()->json(['message'=>'Agency Not Found']);
            }

         $project = $agency->projects()->find($request->project_id);
             if(!$project){
                 DB::rollBack();
             return response()->json(['message' => 'No project found with the provided id.']);
            } 
            
            


        }
        ///////////////////////// Sale-head , Sale-manager  , csr ////////////////////////

        else{
            
          
            $employee = auth()->user()->employee;
            
            if(!$employee){
                return  response()->json(['message'=>'Employee Not Found']);
            }

            // return auth()->user()->employee;
            $project =  $employee->projects()->find($request->project_id);
            if(!$project){
                 DB::rollBack();
                return response()->json(['message' => 'No project found with the provided id.']);
            } 
            
            
        }
      
        $project->floors()->create($request->only((new Floor)->getFillable()));
        DB::commit();
        return response()->json(['message' => 'Created Successfully']);
        
        
        
        
           
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        //////////////////// Agency//////////////////
       if(auth()->user()->('agency')){
            $agency = auth()->user()->agency;
            if(!$agency){
                return  response()->json(['message'=>'Agency Not Found']);
            }
           $floors = $agency->projects()->with(['floors'])->find($id);
           
       }
       ///////////// Sale-head , Sale-manager , Csr ////////////////

       elseif(auth()->user()->hasRole('sale-head') || auth()->user()->hasRole('sale-manager')
       || auth()->user()->hasRole('csr')){
           $employee = auth()->user()->employee;

           if(!$employee){
                return  response()->json(['message'=>'Employee Not Found']);
            }
            $floors = $employee->projects()->with(['floors'])->find($id);
            

       }
       //////////////// Customer /////////////////////////////
       else{
         $floors = Project::with(['floors'])->find($id);  
       }
        
        return response()
                ->json([
                    'data' => $floors
                ]);
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
