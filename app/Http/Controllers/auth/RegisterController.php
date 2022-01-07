<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\RegisterRequest;
use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email'=> ['required', 'string', 'max:50', 'unique:users,email'],
            'password' => ['required'],
            'role' => ['required', Rule::in(['agency','customer'])],

            // share field between agency and custommer
            'name' => ['required', 'string','max:50'],
            'phone_number' =>['required'],
            'phone_ext' =>['required'],
            //agency required
            'logo' => ['required_if:role,agency'],
            'qr_code' => ['required_if:role,agency'],
            'uuid' => ['required_if:role,agency'],
            // customer required
            'address_1' => ['required_if:role,customer'],
            'address_2' => ['required_if:role,customer'],
            'zip_code' => ['required_if:role,customer'],
            'website' => ['required_if:role,customer'],
            'gender' => ['required_if:role,customer', Rule::in(config('enum.genders'))],

            ]);


    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user->syncRoles($data['role']);
        if($data['role'] == 'customer'){
            $customer =$user->customer()->create([
                'name'=> $data['name'],
                'phone_ext'=> $data['phone_ext'],
                'phone_number'=> $data['phone_number'],
                'address_1'=> $data['address_1'],
                'address_2'=> $data['address_2'],
                'zip_code'=> $data['zip_code'],
                'website'=> $data['website'],
                'gender'=> $data['gender'],
            ]);
        }elseif($data['role']== 'agency'){
            $agency =  $user->agency()->create([
                'name'=> $data['name'],
                ''=> $data['name'],
            ]);

        }
        return $user;
    }
}
