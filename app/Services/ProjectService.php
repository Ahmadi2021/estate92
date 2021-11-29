<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Property;

class ProjectService {

    public function get_all_projects(){
       return auth()->user();
        $projects = auth()->user()->projects()->selectProjects();
                            //this select is for projects
        return $projects;
    }

    public function show_projects(){
         $projects = auth()->user()->projects()->selectProjects();
         return $projects;
    }
    public function update_project()
    {
        
    }

    public function delete($id){
        if(!$id){
            // return response()->json(['message'=>'Not Found']);  
        }
        $id->delete();

    }
}