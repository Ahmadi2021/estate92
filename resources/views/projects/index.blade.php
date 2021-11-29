@extends('app.app')

@section('content')


<div class="container">
<h1> project listing </h1>

    @if(session()->has('message'))
      <div class='alert alert-success text-center' > {{session()->get('message')}}  </div>
        
    @endif

<div>
 <a href='{{ route('projects.create') }}'> <button class='btn btn-primary pull-right'> Add </button> </a>
</div>
<table class="table ">
  <thead class="thead-dark">

    <tr>
      <th scope="col">Id</th>
      <th scope="col">Name</th>
      <th scope="col">Description</th>
      <th scope="col">User</th>
      <th scope="col">is_active</th>
      <th scope="col">Created At</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>


@foreach($projects as $key => $project)
  <tr>
      <td>{{++$key}}</td>
      <td>{{$project->name}}</td>
      <td>{{$project->description}}</td>
      

      <td>{{$project->user->name}}</td>
    
      <td>
       {{check_is_active($project->is_active)}}
      </td>
    
      <td>
        {{-- {{ $project->created_at}} --}}
        {{-- 26 jul, 2021 --}}
        {{convert_date_format($project->created_at)}}
      </td>
      <td class="d-flex justify-content-center">
      
      <a href="{{ route('projects.show', $project->id)}}"><button type='button' class='btn btn-info ' style="border-radius"> <i class='fa fa-eye' style='color:white'> </i>  </button></a>
        <a href="{{ route('projects.edit', $project->id) }}"><button type='button' class='btn btn-success rounded-0'> <i class='fa fa-edit' style='color:white'> </i>  </button></a>

            <button type='submit' class='btn btn-danger rounded-right' data-bs-toggle="modal" data-bs-target="#exampleModal"> <i class='fa fa-trash' style='color:white'> </i>  </button>
 
      </td>
      
    
    </tr>
  @endforeach



 
  </tbody>
</table>
{{-- {{$projects->links()}} --}}

</div>
<div class="modal" id="project-delete-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"  >Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are Sure To Delete The Project?
      </div>
      <div class="modal-footer">
        
        <form action="{{ route('projects.destroy', $project->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type='submit' class='btn btn-danger rounded-right' > Delete  </button>
        </form>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

        {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha512-3P8rXCuGJdNZOnUx/03c1jOTnMn3rP63nBip5gOP2qmUh5YAdVAvFZ1E+QLZZbC1rtMrQb+mah3AfYW11RUrWA==" crossorigin="anonymous"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<!-- jQuery Modal -->
{{-- {{ 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" /> }} --}}
<script>

</script>

@endsection