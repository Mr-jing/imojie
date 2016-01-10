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
                @if(\Sentinel::getUser() && \Sentinel::getUser()->id === $topic->uid)
                    <a href="{{route('topic.edit', [$topic->id])}}">编辑</a>
                    <a id="delete_topic" href="javascript:;"
                       data-url="{{app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('topic.destroy', $topic->id)}}"
                       data-method="delete">删除</a>
                @endif
            </div>
        </div>
    </div>
@stop

@section('script')
    <script type="text/javascript">
        var topic_urls = {
            list: "{{route('topic.index')}}"
        };
    </script>
@stop