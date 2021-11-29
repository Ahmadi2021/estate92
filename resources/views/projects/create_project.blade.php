@extends('app.app');

@section('content')
<h1 style="margin-bottom:40px; text-align:center;"> Create Your Project </h1>

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

    
<form action="{{ route('projects.store')}}" method="post" enctype="multipart/form-data">
    @csrf
  <div class="form-row row">
    <div class="form-group col-md-2">
      <label for="id">Project Id</label>
      <input type="text" class="form-control" id="id" placeholder="ID" value='{{$project_id}}' name='id'  disabled>
    </div>
    <div class="form-group col-md-10">
      <label for="title">Name</label>
      <input type="text" class="form-control" id="name" name='name' placeholder="Title" value="{{ old('name') }}" />
      @error('name')
        <p style="color:red">{{ $message }}</p>
      @enderror
    </div>
    
  </div>
    <div class="form-row row">
        <div class="form-group col-md-6">
            <label for="phone">Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" />
            @error('phone_number')
                <p style="color:red">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="code">Code</label>
            <input type="text" class="form-control" id="code" name='code'>
  </div>


      </div>
  <div class="form-group">
    <label for="inputAddress">Address</label>
    <input type="text" class="form-control" id="inputAddress" name='address' >
  </div>
  <div class="form-group">
    <label for="inputAddress">Image</label>
    <input type="file" class="form-control" id="inputAddress" name='images[]' multiple>
  </div>
  <div class="form-group">
    <label for="description">Description</label>
    <textarea type="text" class="form-control" id="description" name ='description'> </textarea>
  </div>
  <div class="form-group">
    <label for="description">user_id</label>
    <select name='user_id'>
    @foreach($users as $user)
       <option value={{$user->id}}>{{$user->name}} </option> 
    @endforeach
    
    </select>
   
  
  <br>
  <div class="form-group mt-3  ">
    <a href='{{route('projects.index')}}' class="btn btn-danger mr-2 float-end"> Cancel</button> </a>
    <input type="submit" class="btn btn-primary mr-2 float-end" value="Save"/>
    
  </div>
  
  
</form>
</div>

@endsection

