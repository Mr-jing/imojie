@extends('layout.default')

@section('title')编辑贴子
@stop

@section('style')
    <link rel="stylesheet" href="{{asset('js\BachEditor-gh-pages\build\build.css')}}">
@stop

@section('content')
    <div class="container">
        <form id="update_topic_form" method="post" data-id="{{$topic->id}}"
              action="{{app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('topic.update', [$topic->id])}}">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="PUT"/>

            <div class="form-group">
                <label for="topic_title">标题：</label>
                <span id="topic_title_remain" class="pull-right">80</span>
                <input class="form-control" type="text" id="topic_title" name="title"
                       value="{{null !== old('title') ? old('title') : $topic->title}}"/>
            </div>
            <div class="form-group editor">
                <label for="content">内容：</label>
                <textarea class="form-control" rows="18" id="myEditor"
                          name="content">{{null !== old('content') ? old('content') : $topic->original_content}}</textarea>
            </div>
            <div>
                <input id="update_topic_btn" class="btn btn-primary" type="submit" value="发 表"/>
            </div>
        </form>
    </div>
@stop

@section('script')
    <script type="text/javascript">
        var topic_urls = {
            list: "{{route('topic.index')}}"
        };
    </script>
    <script type="text/javascript" src="{{asset('js\BachEditor-gh-pages\build\build.js')}}"></script>
@stop