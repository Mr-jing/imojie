@extends('layout.default')

@section('title')修改邮箱
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                @include('user.settings_nav')
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-9">
                        <form method="POST" action="{{action('UserController@update')}}">
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-warning alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <p>{{$error}}</p>
                                </div>
                            @endforeach
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label for="email">用户名</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       value="{{ $user->email }}">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-block">提 交</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop