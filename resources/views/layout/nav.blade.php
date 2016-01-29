@if(Session::get('message'))
    <div class="alert alert-success global-alert" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{Session::get('message')}}</strong>
    </div>
@endif

@if(count($errors->all()) > 0)
    <div class="alert alert-danger global-alert" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>
            @foreach($errors->all() as $error)
                {{$error}}<br/>
            @endforeach
        </strong>
    </div>
@endif

<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">imojie</a>
        </div>

        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="{{ (\Request::is('/') ? ' active ' : '') }}"><a href="{{ url('/') }}">首页</a></li>
                <li class="{{ (\Request::is('topic') ? ' active ' : '') }}"><a href="{{ url('/topic') }}">社区</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if(!Sentinel::check())
                    <li class="{{ (\Request::is('login') ? ' active ' : '') }}"><a
                                href="{{ route('login') }}">登录/注册</a>
                    </li>
                @else
                    <li class="{{ (\Request::is('user/settings/*') ? ' active ' : '') }}"><a
                                href="{{ url('user/settings/info') }}">{{\Sentinel::getUser()->first_name}}</a>
                    </li>
                    <form class="navbar-form navbar-left" method="POST" action="{{ url('auth/logout') }}">
                        {{csrf_field()}}
                        <input type="submit" class="btn btn-default" value="退出"/>
                    </form>
                @endif
            </ul>
        </div>
    </div>
</nav>