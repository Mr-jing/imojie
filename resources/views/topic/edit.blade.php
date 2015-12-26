@extends('layout.default')

@section('title')编辑贴子
@stop

@section('content')
    <div class="container">
        <form method="post" action="{{route('topic.update', [$topic->id])}}">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="PUT"/>

            <div class="form-group">
                <label for="topic_title">标题：</label>
                <span id="topic_title_remain" class="pull-right">80</span>
                <input class="form-control" type="text" id="topic_title" name="title"
                       value="{{null !== old('title') ? old('title') : $topic->title}}"/>
            </div>
            <div class="form-group">
                <label for="content">内容：</label>
                <textarea class="form-control" rows="18" id="content"
                          name="content">{{null !== old('content') ? old('content') : $topic->original_content}}</textarea>
            </div>
            <div>
                <input class="btn btn-primary" type="submit" value="发 表"/>
            </div>
        </form>
    </div>
@stop