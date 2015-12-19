@extends('layout.default')

@section('title')发贴
@stop

@section('content')
    <div class="container">
        <?php var_dump(\Session::all(), old('title'));?>
        <form method="post" action="{{route('topic.update', [$topic->id])}}">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="PUT"/>

            <div>标题：<input type="text" name="title" value="{{null !== old('title') ? old('title') : $topic->title}}"/>
            </div>

            <div>内容：<textarea
                        name="content">{{null !== old('content') ? old('content') : $topic->original_content}}</textarea>
            </div>
            <div><input type="submit" value="修改"/></div>
        </form>
    </div>
@stop