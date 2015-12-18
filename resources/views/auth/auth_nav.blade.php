<div class="list-group">
    <a href="{{url('auth/login')}}"
       class="list-group-item {{ (\Request::is('auth/login') ? ' active ' : '') }}">登录</a>
    <a href="{{url('auth/register')}}"
       class="list-group-item {{ (\Request::is('auth/register') ? ' active ' : '') }}">注册</a>
    <a href="{{url('auth/forgot')}}"
       class="list-group-item {{ (\Request::is('auth/forgot') ? ' active ' : '') }}">找回密码</a>
</div>
