<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogStoreRequest;
use App\Http\Requests\BlogUpdateRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blog = Blog::all();
        return response()->json($blog);
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
    public function store(BlogStoreRequest $request)
    { 
        $blog = Blog::create($request->only((new Blog)->getFillable()));

        // $blog_images= [];
        //  $image_path = '/images/property';
        //  foreach($request->images as $image){
        //      $extension = $image->getClientOriginalExtension(); 
        //      $file_name = strtolower(Str::random(10));
        //      $file = $file_name . '.' . $extension;
        //      $image->move(public_path($image_path),$file);
          
        //      $blog_images [] = [

        //     'image'=> $image_path .'.'. $file,
        //     'imageable_type'=> Blog::class,
        //     'imageable_id' => $blog->id,
        //  ];
       

        // }
        // return $blog_images;
        // $blog->images()->insert($blog_images);


        $blog_images = [];
        $image_path = '/images/blogs';
        foreach($request->images as $image){

            $extension = $image->getClientOriginalExtension();
            $file_name = strtolower(Str::random(10));
            $file = $file_name .'.' . $extension;
            $image->move(public_path($image_path),$file);

            $blog_images[] = [
                'image'=> $image_path . $file,
                'imageable_type' => Blog::class,
                'imageable_id' => $blog->id,
            ];
        }
        $blog->images()->insert($blog_images);
        return response()->json(['message' => 'successfully created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blog = Blog::find($id);
        if(!$blog){
            return response()->json(['message' => 'Not found']);
         }
         return response()->json(['message'=>$blog]);
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
    public function update(BlogUpdateRequest $request, $id)
    {
        $blog = Blog::find($id);
        if(!$blog){
            return response()->json(['message' => 'Not found']);
         }
        $blog->update($request->only((new Blog)->getFillable()));
        return response()->json(['message' => 'updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Blog::find($id);
        if(!$blog){
           return response()->json(['message' => 'Not found']);
        }
        $blog->delete();
        return response()->json(['message' => 'Deleted successfully']);
   }

}
