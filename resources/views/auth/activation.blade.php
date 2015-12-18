@extends('layout.default')


@section('title')注册
@stop

@section('content')
    <div class="container">
        <div id="bind-wrap">
            <div>
                @if(isset($oauthUser))
                    {{$oauthUser['user']->getId()}}
                @endif
                <form method="POST" action="{{action('Auth\AuthController@postActivation')}}">
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
                        <input type="email" class="form-control" id="email" name="email" value="{{$email}}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="username">用户名</label>
                        <input type="text" class="form-control" id="username" name="username"
                               value="{{ old('username') }}">
                    </div>
                    <div class="form-group">
                        <label for="password">密码</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">重复密码</label>
                        <input type="password" class="form-control" id="password_confirmation"
                               name="password_confirmation">
                    </div>
                    <input type="hidden" name="email" value="{{$email}}">
                    <input type="hidden" name="code" value="{{$code}}">

                    <div class="form-group">
                        <span>同意并接受 <a target="_blank" href="">《服务条款》</a></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block">注 册</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop