@extends('app.app')

@section( 'content')
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">project</th>
            <th scope="col">floors Count</th>
            <th scope="col">units Count</th>
        </tr>
        </thead>
        <tbody>
        @foreach($projects as $proj)
        <tr>
            <th scope="row">1</th>
            <td>{{$proj->name}}</td>
            <td>{{$proj->floors_count}}</td>
            <td>{{$proj->units_count}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
@endsection
