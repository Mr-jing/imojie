@extends('layout.default')

@section('title')发贴
@stop

@section('content')
    <div class="container">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="panel-title">{{$topic->title}}</h1>

                <div>{{$topic->uid}}</div>
                <div>{{$topic->created_at}}</div>
            </div>
            <div class="panel-body">{{$topic->content}}</div>
            <div class="panel-footer">
                <a href="{{route('topic.edit', [$topic->id])}}">编辑</a>

                <form method="post" action="{{route('topic.destroy', $topic->id)}}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="DELETE"/>
                    <input type="submit" value="删除"/>
                </form>
            </div>
        </div>
    </div>
@stop