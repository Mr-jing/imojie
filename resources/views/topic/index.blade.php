@extends('layout.default')

@section('title')发贴
@stop

@section('content')
    <div class="container">
        <?php var_dump(\Session::all());?>
        <ul>
            @foreach ($topics as $topic)
                <li class="topic">
                    <a class="avatar pull-left" href=""><img src="" alt="" width="42" height="42"></a>

                    <div class="main">
                        <div class="title"><a href="{{route('topic.show', [$topic->id])}}">{{$topic->title}}</a></div>
                        <div class="info">
                            <span class="author">作者：{{$topic->uid}}</span>
                            <span class="created_at">{{$topic->created_at}}</span>
                            <span class="view_count">浏览({{$topic->view_count}})</span>
                        </div>
                    </div>
                    <div class="other pull-right">
                        <div class="reply_count">
                            <img src="" alt="">
                            <span>{{$topic->reply_count}}</span>
                        </div>
                        <div class="like_count">
                            <img src="" alt="">
                            <span>{{$topic->like_count}}</span>
                        </div>
                    </div>


                    {{--<div>--}}
                    {{--<a href="{{route('topic.edit', [$topic->id])}}">编辑</a>--}}

                    {{--<form method="post" action="{{route('topic.destroy', $topic->id)}}">--}}
                    {{--{!! csrf_field() !!}--}}
                    {{--<input type="hidden" name="_method" value="DELETE"/>--}}
                    {{--<input type="submit" value="删除"/>--}}
                    {{--</form>--}}
                    {{--</div>--}}
                </li>
            @endforeach
        </ul>
    </div>
@stop