@extends('layout.default')

@section('title')绑定账号
@stop

@section('content')
    <div class="container">
        <div id="bind-wrap">
            <ul class="nav nav-tabs mb15" role="tablist">
                <li role="presentation" class="active">
                    <a href="#bind" aria-controls="bind" role="tab" data-toggle="tab">绑定已有账号</a>
                </li>
                <li role="presentation">
                    <a href="#register" aria-controls="register" role="tab" data-toggle="tab">注册新账号并绑定</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="bind" role="tabpanel">
                    <form method="POST" action="{{action('Auth\AuthController@postBind')}}">
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
                            <input type="email" class="form-control" id="email" placeholder="Email" name="email"
                                   value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <label for="password">密码</label>
                            <input type="password" class="form-control" id="password" placeholder="Password"
                                   name="password">
                        </div>
                        <div class="form-group">
                            <span>同意并接受 <a target="_blank" href="">《服务条款》</a></span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block">绑 定</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="register" role="tabpanel">
                    <form method="POST" action="{{action('Auth\AuthController@postRegister')}}">
                        {!! csrf_field() !!}
                        <div class="form-group mt10">
                            <label for="email">邮箱</label>
                            <input type="email" class="form-control" id="email" placeholder="Email" name="email"
                                   value="{{ old('email') }}">
                        </div>
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
    </div>
@stop