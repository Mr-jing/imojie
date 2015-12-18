@extends('layout.default')

@section('title')个人信息
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                @include('user.settings_nav')
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-3 col-md-push-9">
                        <div class="thumbnail">
                            <img class="avatar" src="" alt="">
                        </div>
                    </div>
                    <div class="col-md-9 col-md-pull-3">
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
                                <label for="username">用户名</label>
                                <input type="text" class="form-control" id="username" name="username"
                                       value="{{ $user->first_name }}">
                            </div>
                            <div class="form-group">
                                <label for="username">手机号</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number"
                                       value="{{ $user->phone_number }}">
                            </div>
                            <div class="form-group">
                                <label>性别</label>

                                <div>
                                    <label>
                                        <input type="radio" name="gender"
                                               value="0" {{ 0==$user->gender ? 'checked' : ''}}>保密
                                    </label>
                                    <label>
                                        <input type="radio" name="gender"
                                               value="1" {{ 1==$user->gender ? 'checked' : ''}}>男
                                    </label>
                                    <label>
                                        <input type="radio" name="gender"
                                               value="2" {{ 2==$user->gender ? 'checked' : ''}}>女
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="username">生日</label>
                                <input type="text" class="form-control" id="birthday" name="birthday"
                                       value="{{ date('Y-m-d', $user->birthday) }}">
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