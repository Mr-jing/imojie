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
                @if(Sentinel::getUser()->id === $topic->uid)
                    <a href="{{route('topic.edit', [$topic->id])}}">编辑</a>
                    <a id="delete_topic" href="javascript:;" data-url="{{route('topic.destroy', $topic->id)}}"
                       data-method="delete">删除</a>

                    <form method="post" action="{{route('topic.destroy', $topic->id)}}">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="DELETE"/>
                        <input type="submit" value="删除"/>
                    </form>
                @endif
            </div>
        </div>
    </div>
@stop