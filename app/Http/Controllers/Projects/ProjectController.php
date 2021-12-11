<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectIndexRequest;
use App\Http\Requests\Projects\ProjectShowRequest;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Agency;
use App\Models\Employee;
use App\Models\Floor;
use App\Models\Project;
use App\Models\Property;
use App\Models\Unit;
use App\Models\User;
use App\Services\ProjectService;
use App\Traits\ImageUpload;
use App\Traits\UserRole;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    use ImageUpload, UserRole;

    public $owner;

    public function __construct(){

        $this->middleware(function( $request, $next){
            $this->owner = $this->check_role(auth()->user()->getRoleNames()->first());
            return  $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProjectIndexRequest $request, ProjectService $project_service)
    {

        if (!$this->owner) {

            return response()->json(['message'=>"User Not Found"]);
        }

        $projects = $this->owner->projects()->get();

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

        if (!$this->owner) {

            return response()->json(['message'=>"User Not Found"]);
        }
        
        // if(auth()->user()->hasRole('agency')){
        //     $request->merge(['ownerable_type' => Agency::class]);
        // }
        // else if(auth()->user()->hasRole('sale-manager') || auth()->user()->hasRole('sale-head') || auth()->user()->hasRole('csr')){
        //     $request->merge(['ownerable_type' => Employee::class]);
        // }
        
        // $request->merge(['ownerable_id' => $this->owner->id]);
    // return Project::create($request->all());
    //     return Project::create($request->only(['name', 'description', 'code', 'is_active', 'address']));
           Log::debug($this->owner->projects()->create($request->only((new Project)->getFillable())));
            return response()->json(['message' => 'Created Successfully']);
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
