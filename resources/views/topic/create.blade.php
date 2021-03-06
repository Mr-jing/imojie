@extends('layout.default')

@section('title')发贴
@stop

@section('style')
    <link rel="stylesheet" href="{{asset('js\BachEditor-gh-pages\build\build.css')}}">
@stop

@section('content')
    <div class="container">
        <form id="create_topic_form" method="post"
              action="{{app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('topic.store')}}">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="topic_title">标题：</label>
                <span id="topic_title_remain" class="pull-right">80</span>
                <input class="form-control" type="text" id="topic_title" name="title" value="{{old('title')}}"/>
            </div>
            <div class="form-group editor">
                <label for="content">内容：</label>
                <textarea class="form-control" rows="18" id="myEditor" name="content">{{old('content')}}</textarea>
            </div>
            <div>
                <input id="create_topic_btn" class="btn btn-primary" type="submit" value="发 表"/>
            </div>
        </form>

        {{--<div class="editor">--}}
        {{--<textarea id="myEditor"></textarea>--}}
        {{--</div>--}}
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