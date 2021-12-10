<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectIndexRequest;
use App\Http\Requests\Projects\ProjectShowRequest;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Agency;
use App\Models\Floor;
use App\Models\Project;
use App\Models\Unit;
use App\Models\User;
use App\Services\ProjectService;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
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
       
  ///////////////////////Agency Projects///////////////////////
  
        if (auth()->user()->hasRole('agency')) {
            $agency= auth()->user()->agency;
            if(!$agency){
                return response()->json(['message' => 'No Agency found.']);
            }
            $projects = $agency->projects()->get();
             if (!$projects){
                 return response()->json(['message' => 'No Projects found.']);
             }
                
    
        }
 ///////////////////////sale-manager , sale-header , csr Projects///////////////////////       
        elseif(auth()->user()->hasRole('sale-manager') || auth()->user()->hasRole('sale-head') ||
         auth()->user()->hasRole('csr')){

            $employee = auth()->user()->employee;
            if(!$employee){
                return response()->json(['message' => 'Employee found.']);
            }

            $projects = $employee->projects()->get();
             if (!$projects){
                 return response()->json(['message' => 'No Projects found.']);
             }


        return response()->json(['data' => $projects]);
    }






    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::select('id', 'name')->get();
        $project_id = Project::latest()->first()->id;


        return view('projects.create_project')->with(['users' => $users, 'project_id' => $project_id + 1]);
    }


    public function store(ProjectStoreRequest $request)
    {
        // ini_set('max_execution_time', 4);
        if (auth()->user()->hasRole('agency')) {
            $agency = auth()->user()->agency;
            
            if(!$agency) {
                return response()->json(['message' => 'Agency Not Found']);
            }
            // $request->merge([
            //     'projectable_id' => $agency->id,
            //     'projectable_type' => Agency::class,
            // ]);
            
            
            return auth()->user()->agency->projects()->create($request->all());
            $project = $agency->projects()->create($request->only((new Project)->getFillable()));
            return "created";
        }
        elseif (auth()->user()->hasRole('sale-head') || auth()->user()->hasRole('sale-manager')) {
            return "inside sale head and manager condition";
        }

        // $image_path = "/public/images/project/";
        // return $image_path;
        // $project_images = $this->multi_image_upload($request->project_images, $image_path, $project->id, Project::class);
        // return $project_images;

        // $project->images()->insert($project_images);

        // // return redirect('/projects')->with(['message' => 'Project Created successfully'])

        // return response()->json(['message' => 'created successfully']);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectShowRequest $request, $id)
    {
///////////////////////Agency Projects///////////////////////

  
        if (auth()->user()->hasRole('agency')) {
            $agency= auth()->user()->agency;
            if(!$agency){
                return response()->json(['message' => 'No Agency found.']);
            }
            $project = $agency->projects()->find($id);
             if (!$project){
                 return response()->json(['message' => 'No Projects found.']);
             }
                
    
        }
 ///////////////////////sale-manager , sale-header , csr Projects///////////////////////       
        elseif(auth()->user()->hasRole('sale-manager') || auth()->user()->hasRole('sale-head') ||
         auth()->user()->hasRole('csr')){

            $employee = auth()->user()->employee;
            if(!$employee){
                return response()->json(['message' => 'Employee found.']);
            }

            $project = $employee->projects()->find($id);
             if (!$project){
                 return response()->json(['message' => 'No Projects found.']);
             }
 
               
        }
        return response()->json(['data' => $project]);
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
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
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectUpdateRequest $request, $id)
    {

///////////////////////Agency Projects///////////////////////

        if (auth()->user()->hasRole('agency')) {
            $agency= auth()->user()->agency;
            if(!$agency){
                return response()->json(['message' => 'No Agency found.']);
            }
            $project = $agency->projects()->find($id);
             if (!$project){
                 return response()->json(['message' => 'No Projects found.']);
             }
                
    
        }
 ///////////////////////Sale-manager , Sale-head , csr Projects///////////////////////       
        elseif(auth()->user()->hasRole('sale-manager') || auth()->user()->hasRole('sale-head') ||
         auth()->user()->hasRole('csr')){

            $employee = auth()->user()->employee;
            if(!$employee)
                return response()->json(['message' => 'Employee found.']);
            

            $project = $employee->projects()->find($id);
             if (!$project)
                 return response()->json(['message' => 'No Projects found.']);
             
               
        }

        if ($request->hasFile('images')) {
            $image_path = '/images/project/';
            $project_image = $this->multi_image_upload($request->images, $image_path, $project->id, Project::class);
            $project->images()->insert($project_image);

        }
        $project->update($request->only((new Project)->getFillable()));


        // return redirect('/projects')->with(['message' => 'Updated  successfully']);
        return response()->json(['message' => 'updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {      
  ///////////////////////Agency Projects///////////////////////

        if (auth()->user()->hasRole('agency')) {
            $agency= auth()->user()->agency;
            if(!$agency){
                return response()->json(['message' => 'No Agency found.']);
            }
            $project = $agency->projects()->find($id);
             if (!$project){
                 return response()->json(['message' => 'No Projects found.']);
             }
                
    
        }
 ///////////////////////sale-manager , sale-header , csr Projects///////////////////////       
        elseif(auth()->user()->hasRole('sale-manager') || auth()->user()->hasRole('sale-head') ||
         auth()->user()->hasRole('csr')){

            $employee = auth()->user()->employee;
            if(!$employee)
                return response()->json(['message' => 'Employee found.']);
            

            $project = $employee->projects()->find($id);
             if (!$project)
                 return response()->json(['message' => 'No Projects found.']);
             
               
        }
    
        $project->delete();
       return response()->json(['message' => 'Deleted successfully']);
      
    
    }
}
