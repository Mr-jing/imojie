@extends('layout.default')

@section('title')发贴
@stop

@section('content')
    <div class="container">
        <?php var_dump(\Session::all());?>
        <h1>{{$topic->title}}</h1>

        <div>
            <div>{{$topic->uid}}</div>
            <div>{{$topic->created_at}}</div>
        </div>
        <p>{{$topic->content}}</p>
    </div>
@stop