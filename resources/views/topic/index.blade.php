@extends('layout.default')

@section('title')贴子列表
@stop

@section('content')
    <div class="container">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="topic_sort">
                        <a href="{{route('topic.index')}}" class="{{'active'===$sort ? 'active':''}}">默认</a>
                        <a href="{{route('topic.index', ['sort' => 'excellent'])}}"
                           class="{{'excellent'===$sort ? 'active':''}}">精华</a>
                        <a href="{{route('topic.index', ['sort' => 'hot'])}}"
                           class="{{'hot'===$sort ? 'active':''}}">热门</a>
                        <a href="{{route('topic.index', ['sort' => 'newest'])}}"
                           class="{{'newest'===$sort ? 'active':''}}">最新</a>
                    </div>
                </div>
                <div class="panel-body">
                    <ul class="topic_list">
                        @foreach ($topics as $topic)
                            <li class="topic">
                                <a class="avatar pull-left" href=""><img src="" alt="" width="42" height="42"></a>

                                <div class="main">
                                    <div class="title"><a
                                                href="{{route('topic.show', [$topic->id])}}">{{$topic->title}}</a>
                                    </div>
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
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="panel-footer">
                    <?php echo $topics->appends(['sort' => $sort])->render(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-body text_center">
                    <a class="btn btn-success btn-lg" href="{{route('topic.create')}}">创建贴子</a>
                </div>
            </div>
        </div>
    </div>
@stop