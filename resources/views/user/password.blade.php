@extends('layout.default')

@section('title')修改密码
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
                        <form method="POST" action="{{action('UserController@postPassword')}}">
                            @if (Session::has('message'))
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <p>{{Session::get('message')}}</p>
                                </div>
                            @endif
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
                                <label for="current_password">当前密码</label>
                                <input type="password" class="form-control" id="current_password"
                                       name="current_password">
                            </div>

                            <div class="form-group">
                                <label for="new_password">新密码</label>
                                <input type="password" class="form-control" id="new_password" name="new_password">
                            </div>

                            <div class="form-group">
                                <label for="new_password_confirmation">重复新密码</label>
                                <input type="password" class="form-control" id="new_password_confirmation"
                                       name="new_password_confirmation">
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