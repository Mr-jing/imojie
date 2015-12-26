@extends('layout.default')

@section('title')发贴
@stop

@section('content')
    <div class="container">
        <?php var_dump(\Session::all(), old('title'));?>
        <form method="post" action="{{route('topic.update', [$topic->id])}}">
            {!! csrf_field() !!}

            <input type="hidden" name="_method" value="PUT"/>

            <div class="form-group">标题：<input class="form-control" type="text" name="title"
                                              value="{{null !== old('title') ? old('title') : $topic->title}}"/>
            </div>

            <div class="form-group">内容：<textarea
                        name="content">{{null !== old('content') ? old('content') : $topic->original_content}}</textarea>
            </div>
            <div><input type="submit" value="修改"/></div>
        </form>

        <form>
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="exampleInputFile">File input</label>
                <input type="file" id="exampleInputFile">

                <p class="help-block">Example block-level help text here.</p>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox"> Check me out
                </label>
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
@stop