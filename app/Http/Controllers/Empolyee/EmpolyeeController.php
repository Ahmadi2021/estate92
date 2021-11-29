<?php

namespace App\Http\Controllers\Empolyee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Empolyee\EmpolyeeStoreRequest;
use App\Models\Agency;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmpolyeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return auth()->user()->agency();
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
        
        if(auth()->user()->hasRole('agency')){
            $agency = auth()->user()->agency;
            
            if(!$agency)
                return response()->json(['message' => 'Agency Not Found']);
            $request->merge([
                'password' => Hash::make($request->password),
            ]);
            $user = User::create($request->only((new User)->getFillable()));
    
            $user->syncRoles('sale-head');
            if(!$user)
                 return response()->json(['message' => 'user Not Found']);
            $request->merge([
                'agency_id' =>$agency->id,
            ]);
            // return $user;
            $user->employee()->create($request->only((new Employee)->getFillable()));
    
            DB::commit();
        
        }
        elseif(auth()->user()->hasRole('sale-head')){
            $agency = auth()->user()->agency;
            $user =User::create($request->only((new User)->getFillable()));
            // return auth()->user()->employee->agency;
            $request->merge([
                'parent_id' => auth()->user()->id,
                'agency_id' => $agency->id,
            ]);
            // here i create employee 
            $user->empolyee()->create($request->only((new User)->getFillable()));
           
        }
        elseif(auth()->user()->hasRole('sale-manager')){
            
            $user = User::create($request->only((new User)->getFillable()));

            $request->merge([
                'parent_id' => auth()->user()->id,
                'agency_id' => auth()->user()->agency,
            ]);
            $user->empolyee()->create($request->only((new Employee)->getFillable()));
        }
        // $user = User::create($request->only((new User)->getFillable()));
        // $request->merge(['agency_id' => $agency->id]);

        // $user->employee()->create($request->only((new Employee)->getFillable()));
        DB::commit();
        return response()->json(['message' => ' Created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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
