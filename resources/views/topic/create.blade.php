@extends('layout.default')

@section('title')发贴
@stop

@section('content')
    <div class="container">
        <form method="post" action="{{route('topic.store')}}">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="topic_title">标题：</label>
                <span id="topic_title_remain" class="pull-right">80</span>
                <input class="form-control" type="text" id="topic_title" name="title" value="{{old('title')}}"/>
            </div>
            <div class="form-group">
                <label for="content">内容：</label>
                <textarea class="form-control" rows="18" id="content" name="content">{{old('content')}}</textarea>
            </div>
            <div>
                <input class="btn btn-primary" type="submit" value="发 表"/>
            </div>
        </form>
    </div>
@stop