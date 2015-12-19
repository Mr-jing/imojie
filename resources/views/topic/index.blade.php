@extends('layout.default')

@section('title')发贴
@stop

@section('content')
    <div class="container">
        <?php var_dump(\Session::all());?>
        <ul>
            @foreach ($topics as $topic)
                <li>
                    <div>
                        <span>{{$topic->title}}</span>
                        <span>作者：{{$topic->uid}}</span>
                        <span>回复({{$topic->reply_count}})</span>
                        <span>浏览({{$topic->view_count}})</span>

                        <div>
                            <a href="{{route('topic.edit', [$topic->id])}}">编辑</a>

                            <form method="post" action="{{route('topic.destroy', $topic->id)}}">
                                {!! csrf_field() !!}
                                <input type="hidden" name="_method" value="DELETE"/>
                                <input type="submit" value="删除"/>
                            </form>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@stop