@extends('layout.default')

@section('title')找回密码
@stop

@section('content')
    <div id="login-page" class="container">
        <div class="row" id="passport-wrap">
            <div class="col-md-3">
                @include('auth.auth_nav')
            </div>
            <div class="col-md-9">
                @if (Session::has('status'))
                    <div class="alert alert-success" role="alert">{{Session::get('status')}}</div>
                @else
                    <form method="POST" action="{{action('Auth\PasswordController@postEmail')}}">
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
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block">发送邮件</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@stop