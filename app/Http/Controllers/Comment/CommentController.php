<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentStoreRequest;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Property;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comment = Comment::all();
        return response()->json($comment);
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
    public function store(CommentStoreRequest $request)
    {
        if($request->type == 'blog'){
            $request->merge([
                'commentable_type' => Blog::class
            ]);
        }
        elseif($request->type == 'project'){
            $request->merge([
                'commentable_type' => Project::class
            ]);
        }
        elseif($request->type == 'property'){
             $request->merge([
                 'commentable_type' =>Property::class
             ]);
        }
         Comment::create($request->only((new Comment)->getFillable()));
         return response()->json(['message' => 'Created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = Comment::find($id);
        if(!$comment){
           return response()->json(['message' => 'Not found']);
        }
        return response()->json(['message' => $comment]);
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
    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);
        if(!$comment){
            return response()->json(['message' => 'Not found']);
         }
        $comment->update($request->only((new Comment)->getFillable()));
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
        $comment = Comment::find($id);
        if(!$comment){
           return response()->json(['message' => 'Not found']);
        }
        $comment->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
