<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\RegisterRequest;
use App\Models\Agency;
use App\Models\Customer;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use phpseclib3\System\SSH\Agent;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request){
        DB::beginTransaction();
        try {
        $pass = Hash::make($request->password);

        $request->merge([
            'password' => $pass
        ]);
        $user = User::create($request->only((new User())->getFillable()));
        $token = $user->createToken('secret_key')->accessToken;
        
        // this line will check the role name inside the ROLE TABLE 
        // $check_role = Role::findByName($request->role);
        // this line of code will create the data insdie model_has_role table 
        // $user->syncRoles($check_role->name);

        if($request->role == 'customer'){
            $user->syncRoles('customer');
            $user->customer()->create($request->only((new Customer)->getFillable()));
             DB::commit();
                 return response()->json([
                     'message' => 'created successfuly',
                     'token' => $token,
                ]);
        }
        
        else if($request->role == 'agency'){
            $user->syncRoles('agency');
            $user->agency()->create($request->only((new Agency)->getFillable()));
            DB::commit();
            return response()->json([
                'message' => 'created successfuly',
                'token' => $token,
                ]);
            
        }

          

      }  
       
        catch(Exception $exception){
            DB::rollBack();
            return response()->json(['message' => $exception->getMessage()]);
        }
    
}
}
