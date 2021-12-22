<?php

namespace App\Http\Controllers\property;

use App\Http\Controllers\Controller;
use App\Http\Requests\Property\PropertyDestroyRequest;
use App\Http\Requests\Property\PropertyIndexRequest;
use App\Http\Requests\Property\PropertyShowRequest;
use App\Http\Requests\PropertyStoreRequest;
use App\Http\Requests\PropertyUpdateRequest;
use App\Models\Property;
use App\Models\User;
use App\Traits\ImageUpload;
use App\Traits\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    use UserRole , ImageUpload;
    public $owner;
    public function __construct()
    {
        $this->middleware(function($request, $next ){
            $this->owner = $this->check_role(auth()->user()->getRoleNames()->first());
            return $next($request);
        });
    }


    public function index(PropertyIndexRequest $request)
    {     if (!$this->owner)
                return  response()->json(['message'=> 'User Not Found']);
        $property =$this->owner->properties()->get();
        if(!$property){
            return response()->json(['message'=> 'Not Found']);
        }
        return response()->json(['message'=> $property]);

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
    public function store(PropertyStoreRequest $request)
    {
        if (!$this->owner){
            return  response()->json(['message'=> 'User Not Found']);
        }
         $property = $this->owner->properties()->create($request->only((new Property)->getFillable()));
         if(!$property)
            return response()->json(['message' => 'No property found.']);
         $prperty_images= [];
         $image_path = '/images/property';
        $property_images= $this->multi_image_upload($request->images , $image_path , $property->id,Property::class);
//         foreach($request->images as $image){
//             $extension = $image->getClientOriginalExtension();
//             $file_name = strtolower(Str::random(10));
//             $file = $file_name . '.' . $extension;
//             $image->move(public_path($image_path),$file);
//
//             $property_images [] = [
//
//            'image'=> $image_path .'.'. $file,
//            'imageable_type'=> Property::class,
//            'imageable_id' => $property->id,
//         ];
//        }
         $property->images()->insert($property_images);
         return response()->json(['message'=>'created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PropertyShowRequest $request,$id)
    {
         $property = auth()->user()->properties()->find($id);
         if(!$property){
            return response()->json(['message'=>'Not found']);
         }
         return response()->json(['message'=> $property]);
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
    public function update(PropertyUpdateRequest $request, $id)
    {
          $property = auth()->user()->properties()->find($id);
          if(!$property){
            return response()->json(['message'=>'Not found']);
         }
           $property->update($request->only((new Property)->getFillable()));
           return response()->json(['message'=>'Updated successfully']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PropertyDestroyRequest $request,$id)
    {
        $property = auth()->user()->properties()->find($id);

        if(!$property){
          return response()->json(['message'=>'Not found']);
       }
        $property->delete();
        return response()->json(['message'=>'Deleted successfully']);
    }
}
