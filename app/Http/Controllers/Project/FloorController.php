<?php

namespace App\Http\Controllers\Project;

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
    // public function __construct()
    // {
    //     $this->middleware(function($request, $next){
    //         $this->owner = $this->check_roles(auth()->user()->getRoleNames()->first());
    //         return $next($request);
    //     });
    // }

    public function __construct()
    {
    
        $this->middleware(function($request, $next){
            $this->owner = $this->check_roles(auth()->user()->getRoleNames()->first());
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
        return response()->json(['data' => $floor]);
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
    

        if(){
            
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
    public function show(FloorShowRequest $request  , $floor_id  )
    {   
        //////////////////// Agency//////////////////
        // return auth()->user()->getRoleNames();
       if(auth()->user()->hasRole('agency')){
            $agency = auth()->user()->agency;
            if(!$agency){
                return  response()->json(['message'=>'Agency Not Found']);
            }
           $project = $agency->projects()->find($request->project_id);
           if(!$project){
               return  response()->json(['message'=>'Project Not Found']);
           }
          $floor = $project->floors()->find($floor_id);
           
       }
       ///////////// Sale-head , Sale-manager , Csr ////////////////

       elseif(auth()->user()->hasRole('sale-head') || auth()->user()->hasRole('sale-manager')
       || auth()->user()->hasRole('csr')){
           $employee = auth()->user()->employee;

           if(!$employee){
                return  response()->json(['message'=>'Employee Not Found']);
            }
            $project = $employee->projects()->find($request->project_id);
            if(!$project){
               return  response()->json(['message'=>'Project Not Found']);
           }
           $floor = $project->floors()->find($floor_id);

       }
    
          $floor = $project->floors()->find($floor_id);
        
       }
        
    //     return response()
    //             ->json([
    //                 'data' => $floor
    //             ]);
    // }

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

        //////////////////// Agency//////////////////
        // return auth()->user()->getRoleNames();
       if(auth()->user()->hasRole('agency')){
            $agency = auth()->user()->agency;
            if(!$agency){
                DB::rollBack();
                return  response()->json(['message'=>'Agency Not Found']);
            }
           $project = $agency->projects()->find($request->project_id);
           if(!$project){
               DB::rollBack();
               return  response()->json(['message'=>'Project Not Found']);
           }
          $floor = $project->floors()->find($floor_id);
           
       }
       ///////////// Sale-head , Sale-manager , Csr ////////////////

       elseif(auth()->user()->hasRole('sale-head') || auth()->user()->hasRole('sale-manager')
       || auth()->user()->hasRole('csr')){
           $employee = auth()->user()->employee;

           if(!$employee){
               DB::rollBack();
                return  response()->json(['message'=>'Employee Not Found']);
            }
            $project = $employee->projects()->find($request->project_id);
            if(!$project){
                DB::rollBack();
               return  response()->json(['message'=>'Project Not Found']);
           }
           $floor = $project->floors()->find($floor_id);

       }

       $floor->update($request->only((new Floor)->getFillable()));
       DB::commit();
       return  response()->json(['message'=>'Updated Successfuly']);
       
          
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FloorDeleteRequest $request, $floor_id)
    {
        
    //////////////////// Agency//////////////////
        // return auth()->user()->getRoleNames();
       if(auth()->user()->hasRole('agency')){
            $agency = auth()->user()->agency;
            if(!$agency){
                return  response()->json(['message'=>'Agency Not Found']);
            }
           $project = $agency->projects()->find($request->project_id);
           if(!$project){
               return  response()->json(['message'=>'Project Not Found']);
           }
          $floor = $project->floors()->find($floor_id);
           
       }
       ///////////// Sale-head , Sale-manager , Csr ////////////////

       elseif(auth()->user()->hasRole('sale-head') || auth()->user()->hasRole('sale-manager')
       || auth()->user()->hasRole('csr')){
           $employee = auth()->user()->employee;

           if(!$employee){
                return  response()->json(['message'=>'Employee Not Found']);
            }
            $project = $employee->projects()->find($request->project_id);
            if(!$project){
               return  response()->json(['message'=>'Project Not Found']);
           }
           $floor = $project->floors()->find($floor_id);

       }
        
       
        $floor->delete();
            return response()->json(['message' => 'Deleted successfully']);
    }
}
