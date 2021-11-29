<?php

use PhpParser\Node\Stmt\Nop;
use Illuminate\Support\Carbon;

function check_is_active($is_active){

    if($is_active ==1){
     return  "Yes";
    } 
    else{
     return "No" ; 
    }
    

}

function convert_date_format($date){
    return Carbon::parse($date)->format('dS M, Y ');
}