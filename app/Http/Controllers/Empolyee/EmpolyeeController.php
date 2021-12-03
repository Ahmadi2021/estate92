<?php

namespace App\Http\Controllers\Empolyee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Empolyee\EmpolyeeDeleteRequest;
use App\Http\Requests\Empolyee\EmpolyeeIndexRequest;
use App\Http\Requests\Empolyee\EmpolyeeShowRequest;
use App\Http\Requests\Empolyee\EmpolyeeStoreRequest;
use App\Http\Requests\Empolyee\EmpolyeeUpdateRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\Agency;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Null_;
use SebastianBergmann\Type\NullType;

class EmpolyeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EmpolyeeIndexRequest $request)
    {
        if(auth()->user()->hasRole('agency')){
            // $employees = auth()->user()->agency->employees()->find(10)->childs()->get();
            $agency = auth()->user()->agency;
            if(!$agency)
                return response()->json(['message' => 'No agency found.']);


            $employees = $agency->employees()->get();
            if(!$employees)
                return response()->json(['message' => 'No employees found.']);


            return response()->json(['data' => $employees]);

        }elseif(auth()->user()->hasRole('sale-head') || auth()->user()->hasRole('sale-manager') ){
         
            $employees = auth()->user()->employee;
            
            if(!$employees)
                return response()->json(['message' => 'No employees found.']);


            $childs = $employees->childs()->get();
            if(!$childs){
                 return response()->json(['message' => 'Not  found.']);
            }
               

            return response()->json(['data' => $childs]);
        }
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
    public function store(EmpolyeeStoreRequest $request)
    { 
        DB::beginTransaction();
        $request->merge([
                'password' => Hash::make($request->password),
            ]);
            
        $user = User::create($request->only((new User)->getFillable()));

     ////////////////////////////////Create Sale Head /////////////////////////

        if(auth()->user()->hasRole('agency')){
            $agency = auth()->user()->agency;
            if(!$agency)
                return response()->json(['message' => 'Agency Not Found']);
            
            $user->syncRoles('sale-head');
            $request->merge([
                'agency_id' =>$agency->id,
                'level' => 1,
            ]);
           
            
    
///////////////////////////////////// Sale Head  Create Sale Manager/////////////////////////////////////////       
        
        }
        elseif(auth()->user()->hasRole('sale-head')){
        // Here we create Sale Manager
            $employee = auth()->user()->employee;
            // return $employee_agen->agency_id;
     
            $user->syncRoles('sale-manager');
            $request->merge([
                'parent_id' => $employee->id,
                'agency_id' => $employee->agency_id,
                'level' => 2,
            ]);
        }

///////////////////////////////////// Sale Manager  Create CSR/////////////////////////////////////////

        elseif(auth()->user()->hasRole('sale-manager')){
            $emp = auth()->user()->employee;
             
            $user->syncRoles('csr');
          
            $request->merge([
                'parent_id' => $emp->id,
                'agency_id' => $emp->agency_id,
                'level' => 3,
            ]);
           
        }
        $user->employee()->create($request->only((new Employee)->getFillable()));
        DB::commit();
        return response()->json(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */




/////////////////////   Show Function


public function show( EmpolyeeShowRequest $request , $id)
    {
        if(auth()->user()->hasRole('agency')){
           $agency = auth()->user()->agency;
           if(!$agency){
                return response()->json(['message' => 'Agency Not Found']);
           }
            $employee = $agency->employees()->find($id);
            if(!$employee){
                return response()->json(['message' => 'Employee Not Found']);
            }
            return response()->json(['message' => $employee]);
        }
        elseif(auth()->user()->hasRole('sale-head') || auth()->user()->hasRole('sale-manager')){

            $employee =  auth()->user()->employee;
              if(!$employee){
                return response()->json(['message' => 'Not Found']);
               }
               $child = $employee->childs()->find($id);
               if(!$child){
                   return response()->json(['message' => 'Child Not Found']);
               }
            return response()->json(['message' => $child]);
        }
      
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




    /////////////////////   Update Function 
    public function update(EmpolyeeUpdateRequest $request, $id)
    {   
        if(auth()->user()->hasRole('agency')){
            $agency = auth()->user()->agency;
            if(!$agency){
                return response()->json(['data' => 'Agency Not Found']);
                
            }
            $employee = $agency->employees()->find($id);
            if(!$employee){
                return response()->json(['data' => 'Employee  Not Found']);
            }
            $employee->update($request->only((new Employee)->getFillable()));
            return response()->json(['message' => 'Updated Successfully']);

        }elseif(auth()->user()->hasRole('sale-head') || auth()->user()->hasRole('sale-manager')){

            $employee = auth()->user()->employee;
            if(!$employee){
                return response()->json(['message' => 'Employee  Not Found']);
            }
            $emp_child =  $employee->childs();
            if(!$emp_child){
                return response()->json(['message' => '  Not Found']);
            }
            $emp_child->update($request->only((new Employee)->getFillable()));
            return response()->json(['message' => '  Not Found']);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */




/////////////////////   Delete Function 
    public function destroy(EmpolyeeDeleteRequest $request, $id)
    {   
    
        if(auth()->user()->hasRole('agency')){
             $agency = auth()->user()->agency;
             
           if(!$agency){
                return response()->json(['message' => 'Agency Not Found']);
           }

            $employee = $agency->employees()->find($id);
            if(!$employee){
                return response()->json(['message' => 'Employee Not Found']);
            
            }

            $employee->delete();
            return response()->json(['message' => 'Deleted Successfully']);


        }elseif(auth()->user()->hasRole('sale-head') || auth()->user()->hasRole('sale-manager')){
            $employee =  auth()->user()->employee;
              if(!$employee){
                return response()->json(['message' => 'Not Found']);
               }
               $child = $employee->childs()->find($id);
               if(!$child){
                   return response()->json(['message' => 'Child Not Found']);
               }
             
            $employee->delete();
            return response()->json(['message' => 'Deleted Successfully']);
        } 
        
    }
 }

