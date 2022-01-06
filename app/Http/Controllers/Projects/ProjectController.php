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
use Carbon\Carbon;
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

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->owner = $this->check_role(auth()->user()->getRoleNames()->first());
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProjectIndexRequest $request, ProjectService $project_service)
    {
//        return Carbon::now()->format('y m d');
        if (!$this->owner) {
            return response()->json(['message' => "User Not Found"]);
        }


        $projects = $this->owner->projects()
            ->select('name','ownerable_id','address', 'created_at', 'id')
            ->withCount(['floors','units'])
            ->get();

//        $projects = collect($projects)->map(function ($value,$key){
////            dd($value);
//            return $value->id +=1;
//        });
//
//        return $projects;
//        $grouped = $projects->groupBy(function ($item) {
//            return $item['created_at'];
//        });
//            ->whereBetween('created_at',
//                [
//                    $request->start_date,
//                    $request->end_date
//                ])

        //
        if (!$projects)
            return response()->json(['message' => 'No Projects found.']);
//        return view('task')->with(['projects'=>$projects]);
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
        return  Agency::class;
        if(!$this->owner)
            return response()->json(['message' => "User Not Found"]);

         if(auth()->user()->hasRole('agency')){
             $request->merge(['ownerable_type' => Agency::class]);
         }
         else if(auth()->user()->hasRole('sale-manager') || auth()->user()->hasRole('sale-head') || auth()->user()->hasRole('csr')){
             $request->merge(['ownerable_type' => Employee::class]);
         }

         $request->merge(['ownerable_id' => $this->owner->id]);
         return Project::create($request->all());
             return Project::create($request->only(['name', 'description', 'code', 'is_active', 'address']));
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
//        if (!$this->owner) {
//            return response()->json(['message' => "User Not Found"]);
//        }
//        $project = $this->owner->projects()->find($id);
//        if (!$project) {
//            return response()->json(['message' => 'No Projects found.']);
//        }
//        return response()->json(['data' => $project]);
         if(!$this->owner)
             return response()->json(['message'=> 'User Not Found']);
        $project = $this->owner->projects()
            ->with(['floors'=> function($query){
                $query->with(['units'=>function($q){
                    $q->where('type' , 'shop')
                        ->where('price', '>' , 500)
                        ->select(['id','name','price','floor_id','type']);

                }])->select(['id','name','project_id'])
                    ->withCount('units');

             }])->select(['id','name','ownerable_id','ownerable_type'])
            ->withMax('units','price')
            ->withCount('units')
            ->withMin('units','price')
            ->get();
        return response()->json(['message' => $project]);



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
        // return auth()->user()->getRoleNames();
        if (!$this->owner)
            return response()->json(['message' => 'User Not Found']);

        $project = $this->owner->projects()->find($id);
        if (!$project) {
            return response()->json(['message' => ' Projects Not found.']);
        }

        if ($request->hasFile('images')) {
            $image_path = '/images/project/';
            $project_image = $this->multi_image_upload($request->images, $image_path, $project->id, Project::class);
            $project->images()->insert($project_image);

        }
        $project->update($request->only((new Project)->getFillable()));
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
        if (!$this->owner)
            return response()->json(['message' => "User Not Found"]);
        $project = $this->owner->projects()->find($id);
        if (!$project) {
            return response()->json(['message' => 'No Projects found.']);
        }
        $project->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
