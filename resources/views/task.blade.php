@extends('app.app')

@section( 'content')
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">project</th>
            <th scope="col">floors</th>
            <th scope="col">units</th>
        </tr>
        </thead>
        <tbody>
{{--        @foreach($data as d)--}}
{{--        <tr>--}}
{{--            <th scope="row">1</th>--}}
{{--            <td>{{d->name}}</td>--}}
{{--            <td>{{d->floors_count}}</td>--}}
{{--            <td>{{d->units_count}}</td>--}}
{{--        </tr>--}}
{{--        @endforeach--}}
        </tbody>
    </table>
@endsection
