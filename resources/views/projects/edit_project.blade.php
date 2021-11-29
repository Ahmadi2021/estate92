@extends('app.app');

@section('content')
<h1 style="text-align:center; margin-bottom:40px;"> Updated of {{$project->name}} </h1>

<div class="container">
    {{-- @foreach($errors->all() as $err)
        <div class="alert alert-danger">{{ $err }}</div>
    @endforeach --}}

    {{-- @if(session()->has('message'))
        <div class="alert alert-alert">{{ session()->get('message') }}</div>
    @endif --}}
    @if(session()->has('message'))
       <div class="alert alert-success"> {{session()->get('message')}}  </div>
    @endif

   
<form action="{{ route('projects.update', $project->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
 
  <div class="form-row row">
    <div class="form-group col-md-2">
      <label for="id">project Id</label>
      <input type="text" class="form-control" id="id" placeholder="ID" value='{{$project->id}}' name='id'  disabled />
    </div>
    <div class="form-group col-md-10">
      <label for="title">Name</label>
      <input type="text" class="form-control" id="name" name='name' placeholder="Title" value="{{ $project->name }}" />
      @error('name')
        <p style="color:red">{{ $message }}</p>
      @enderror
    </div>
    
  </div>
    <div class="form-row row">
        <div class="form-group col-md-6">
            <label for="phone">Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $project->phone_number }}" />
            @error('phone_number')
                <p style="color:red">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="code">Code</label>
            <input type="text" class="form-control" id="code" name='code'  value="{{ $project->code }}"/>
        </div>
  </div>
  <div class="form-group">
    <label for="inputAddress">Address</label>
    <input type="text" class="form-control" id="inputAddress" name='address'  value="{{ $project->address }}" />
  </div>
 <input type='file' class='btn btn-primary pull-left' name="images[]" multiple />



</div>
  @foreach($project->images as $image)
  
    <div class="form-group" style='position:relative; display:inline-block ; '>
      <a href='#' > 
        <button type="button" class="btn btn-danger btn-sm close" style='position:absolute; right:0px;'>
          <span>&times;</span>
        </button>
      </a>
      <img style="width:100px;height:90px" src="{{ asset($image->image) }}">  
  </div>
  
  @endforeach

  <div class="form-group">
    <label for="description">Description</label>
    <textarea type="text" class="form-control" id="description" name ='description'  > {{ $project->description }}</textarea>
  </div>
  <div class="form-group">
    <label for="description">user_id</label>
    <select name='user_id'>
    @foreach($users as $user)
       <option value={{$user->id}} @if($user->id == $project->user->id) selected @endif>{{$user->name}} </option> 
    @endforeach
    
    </select>

     <a href='{{route('projects.index')}}' class="btn btn-danger mr-2 float-end"> Cancel </a>
     <input type="submit" class="btn btn-primary mr-2 float-end" value="Update"/>
    


  
  
</form>
</div>

@endsection

