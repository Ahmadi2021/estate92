<?php

namespace App\Traits;

use App\Models\Project;
use App\Models\User;

trait UserRole {
    // public function check_roles($role)
    // {
    //     if($role == 'agency'){
    //         return auth()->user()->agency;
    //     }
    //     else if($role == 'sale-head' || $role == 'sale-manager' || $role == 'csr'){
    //         return auth()->user()->employee;
    //     }
    //     else if($role == 'customer'){
    //         return (new User);
    //     }
    // }


    public function check_role($role){

        if($role == 'agency'){

            return auth()->user()->agency;

        }elseif($role == 'sale-head' || $role == 'sale-manager' || $role == 'csr'){

            return auth()->user()->employee;

        }elseif($role == 'customer'){
            return auth()->user()->customer;
        }
    }
}
