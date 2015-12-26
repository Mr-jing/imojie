@extends('layout.default')

@section('title')发贴
@stop

@section('content')
    <div class="container">
        <?php var_dump(\Session::all());?>
        <form method="post" action="{{route('topic.store')}}">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="topic_title">标题：</label>
                <span class="pull-right">剩余可输入字数：<span id="topic_title_remain">80</span></span>
                <input class="form-control" type="text" id="topic_title" name="title"/>
            </div>
            <div class="form-group">
                <label for="content">内容：</label>
                <textarea class="form-control" rows="18" id="content" name="content"></textarea>
            </div>
            <div>
                <input class="btn btn-primary" type="submit" value="发 表"/>
            </div>
        </form>
    </div>
@stop