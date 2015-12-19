@extends('layout.default')

@section('title')发贴
@stop

@section('content')
    <div class="container">
        <?php var_dump(\Session::all());?>
        <form method="post" action="{{route('topic.store')}}">
            {!! csrf_field() !!}
            <div>标题：<input type="text" name="title"/></div>
            <div>内容：<textarea name="content"></textarea></div>
            <div><input type="submit" value="发表"/></div>
        </form>
    </div>
@stop