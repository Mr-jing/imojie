@extends('layout.default')

@section('title')发贴
@stop

@section('content')
    <div class="container">
        <?php var_dump(\Session::all());?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">{{$topic->title}}</h1>

                <div class="panel panel-default">
                    <div>{{$topic->uid}}</div>
                    <div>{{$topic->created_at}}</div>
                </div>
            </div>
            <div class="panel-body">{{$topic->content}}</div>
            <div class="panel-footer"></div>
        </div>
    </div>
@stop