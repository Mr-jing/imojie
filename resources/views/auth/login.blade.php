@extends('layout.default')

@section('title')登录
@stop

@section('content')
    <div id="login-page" class="container">
        <div class="row" id="passport-wrap">
            <div class="col-md-3">
                @include('auth.auth_nav')
            </div>
            <div class="col-md-9">
                <form method="POST" action="{{action('Auth\AuthController@postLogin')}}">
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
                        <label for="email">邮箱</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <label for="password">密码</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="remember"> 记住账号
                        </label>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block">登 录</button>
                    </div>
                    <div class="form-group">
                        <label>第三方账号登录</label>

                        <div>
                            <a class="btn btn-danger" href="{{route('oauth', ['provider' => 'weibo'])}}">微博登录</a>
                            <a class="btn btn-primary" href="{{route('oauth', ['provider' => 'qq'])}}">QQ 登录</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop