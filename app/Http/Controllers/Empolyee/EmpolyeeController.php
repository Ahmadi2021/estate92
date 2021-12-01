<?php

namespace App\Http\Controllers\Empolyee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Empolyee\EmpolyeeIndexRequest;
use App\Http\Requests\Empolyee\EmpolyeeStoreRequest;
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
//////////////////GET ALL SALE HEAD  ////////////////////////////////
        if(auth()->user()->hasRole('agency')){
           $employees = auth()->user()->agency->employee()->get();
           
           return response()->json(['message'=>$employees]);
        }
///////// Get ALL SALE MANAGER////////////////////////////////////

        elseif(auth()->user()->hasRole('sale-head')){
            $employees = Employee::where('level','=', 2)->get();
                 return response()->json(['message'=>$employees]);

        }
///////// Get ALL CSR/////////////////////////////////////////////
        elseif(auth()->user()->hasRole('sale-manager')){
             $employees = Employee::where('level','=', 3)->get();
           return response()->json(['message'=>$employees]);
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
    public function show($id)
    {
        if(auth()->user()->hasRole('agency')){
            return auth()->user()->agency->employees()->get();
        }
        elseif(auth()->user()->hasRole('sale-head') || auth()->user()->hasRole('sale-manager')){
            return auth()->user()->employee->with('childs.childs')->get();
        }
        // $request_emp = Employee::find($id);
        // if(!$request_emp){
        //     return response()->json(['message'=> 'NOt Found']);
        // }
        // $auth_emp = auth()->user()->empolyee;
        // if($auth_emp->level == $request_emp->level ){
        //     return response()->json(['message'=> $request_emp]);
        // }else{
        //     return response()->json(['message'=> 'NO autherization']);
        // }
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
