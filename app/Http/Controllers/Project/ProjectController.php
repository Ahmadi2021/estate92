<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectIndexRequest;
use App\Http\Requests\Projects\ProjectShowRequest;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Floor;
use App\Models\Project;
use App\Models\Unit;
use App\Models\User;
use App\Services\ProjectService;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    use ImageUpload;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProjectIndexRequest $request, ProjectService $project_service)
    {

        // return auth()->user();
        if(auth()->user()->hasRole('agency')){
            auth()->users()->agency;
        }
        $projects = auth()->user()->projects()->selectProjects()->get();
                            // ->active() //this is scope function [inside model Project]
                            // ->latest()
                           
    
        if(!$projects)
            return response()->json(['message' => 'No projects found.']);
        return response()->json(['data' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::select('id','name')->get();
        $project_id =Project::latest()->first()->id;
      

        return view('projects.create_project')->with(['users' => $users , 'project_id' => $project_id+1]);
    }

   
    public function store(ProjectStoreRequest $request)
    {  
        if(auth()->user()->hasRole('agency')){
          $agency =  auth()->user()->agency;
          if(!$agency){
              return response()->json(['message'=>'Agency Not Found']);
          }
          $project= $agency->projects()->create($request->only((new Project)->getFillable()));

         
        }elseif(auth()->user()->hasRole('sale-head')|| auth()->user()->hasRole('sale-manager')){



        }
       
        $image_path = "/public/images/project/";
        $project_images = $this->multi_image_upload($request->project_images, $image_path,$project->id,Project::class);

        $project->images()->insert($project_images);
        
        // return redirect('/projects')->with(['message' => 'Project Created successfully']);
        if(!$project){
            return response()->json(['message' => 'failed to create project']);
        }
            
        return response()->json(['message'=>'created successfully']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectShowRequest $request,$id)
    {
        
        $pro = auth()->user()->projects()->selectProjects()->find($id);
    
        if(!$pro){
            return response()->json(['message'=>'Not Found']);  
        }
        // return view('projects.show_project')->with(['project'=> $pro]);
        return response()->json(['message'=> $pro]);  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::with(['images'])
                    ->find($id);
      
        $users = User::get();
        // ->find(0);
        // ->first();

        // ->get();
        // ->paginate(10);
        // ->all();
        
        return view('projects.edit_project')->with(['project' => $project, 'users' => $users]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectUpdateRequest $request, $id)
    {
        
        $project = auth()->user()->projects()->find($id);
        if(!$project){
            return response()->json(['message'=>'Not Found']);
        }
       
        if($request->hasFile('images')){
            $image_path = '/images/project/';
           $project_image =  $this->multi_image_upload($request->images , $image_path, $project->id, Project::class ); 
           $project->images()->insert($project_image); 
         
        }
        $project->update($request->only((new Project)->getFillable()));
     
        
       
        // return redirect('/projects')->with(['message' => 'Updated  successfully']);
        return response()->json(['message'=>'updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = auth()->user()->projects()->find($id);
        if(!$project){
            return response()->json(['message'=>'Not Found']);
        }
        $project->delete();
        
        //return redirect('/projects')->with(['message' => 'Successfully Deleted']);
        return response()->json(['message'=>'Deleted successfully']);
    }
}
