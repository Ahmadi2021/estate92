@extends('app.app')

@section( 'content')

<div class="container">

<h2 style='text-align:center; margin-bottom:40px'>  Detials of {{$project->name}}</h2>

<table class="table">
  {{-- <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
  </thead> --}}
  <tbody>
    <tr>
      <th scope="row">Name</th>
      <td>{{$project->name}}</td>
      
    </tr>
    <tr>
      <th scope="row">Description</th>
      <td>{{$project->description}}</td>
 
    </tr>
    <tr>
      <th scope="row">Code</th>
      <td>{{$project->code}}</td>
      
    </tr>
      <tr>
      <th scope="row">is_active</th>
      <td>
      {{check_is_active($project->is_active)}}
       
      </td>
      
    </tr>
      <tr>
      <th scope="row">Phone Number</th>
      <td>{{$project->phone_number}}</td>
      
    </tr>
      <tr>
      <th scope="row">address</th>
      <td>{{$project->address}}</td>
      
    </tr>
      <tr>
      <th scope="row">User</th>
      <td>{{$project->user->name}}</td>
      
    </tr>
     </tr>
      <tr>
      <th scope="row">Images</th>
      <td>
        @foreach($project->images as $image)
          <img src='{{asset($image->image)}}' height=100px width=100px />  
        @endforeach
        
      
      </td>
      
    </tr>
  </tbody>
</table>
</div>

@endsection