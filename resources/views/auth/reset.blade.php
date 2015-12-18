@extends('layout.default')


@section('title')重置密码
@stop

@section('content')
    <div class="container">
        <div id="bind-wrap">
            <form method="POST" action="{{action('Auth\PasswordController@postReset')}}">
                @foreach ($errors->all() as $error)
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p>{!! $error !!}</p>
                    </div>
                @endforeach
                {!! csrf_field() !!}
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="email">邮箱</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label for="password">新密码</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">重复新密码</label>
                    <input type="password" class="form-control" id="password_confirmation"
                           name="password_confirmation">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-block">提 交</button>
                </div>
            </form>
        </div>
    </div>
@stop