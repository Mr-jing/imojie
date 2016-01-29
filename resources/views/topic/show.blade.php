@extends('layout.default')

@section('title')发贴
@stop

@section('content')
    <div class="container">

        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="panel-title">{{$topic->title}}</h1>

                    <div>{{$topic->uid}}</div>
                    <div>{{$topic->created_at}}</div>
                </div>
                <div class="panel-body">{!! $topic->content !!}</div>
                <div class="panel-footer">
                    @if(\Sentinel::getUser() && \Sentinel::getUser()->id === $topic->uid)
                        <a href="{{route('topic.edit', [$topic->id])}}">编辑</a>
                        <a id="delete_topic" href="javascript:;"
                           data-url="{{app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('topic.destroy', $topic->id)}}"
                           data-method="delete">删除</a>
                    @endif
                </div>
            </div>

            <div id="replies" class="panel panel-default">
                <div class="panel-heading">
                    贴子回复：
                </div>
                <div class="panel-body">
                    @if(count($replies))
                        <ul class="list-group">
                            @foreach($replies as $reply)
                                <li class="list-group-item">
                                    <div>{!! $reply->content !!}</div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>暂无回复</p>
                    @endif
                </div>
                <div class="panel-footer">
                    <?php echo $replies->fragment('replies')->render(); ?>
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

@section('script')
    <script type="text/javascript">
        var topic_urls = {
            list: "{{route('topic.index')}}"
        };
    </script>
@stop