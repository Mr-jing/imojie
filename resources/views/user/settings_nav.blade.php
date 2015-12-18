<div class="list-group">
    <a href="{{url('user/settings/info')}}"
       class="list-group-item {{ (\Request::is('user/settings/info') ? ' active ' : '') }}">个人信息</a>
    {{--<a href="{{url('user/settings/email')}}"--}}
       {{--class="list-group-item {{ (\Request::is('user/settings/email') ? ' active ' : '') }}">修改邮箱</a>--}}
    <a href="{{url('user/settings/password')}}"
       class="list-group-item {{ (\Request::is('user/settings/password') ? ' active ' : '') }}">修改密码</a>
    <a href="{{url('user/settings/oauth')}}"
       class="list-group-item {{ (\Request::is('user/settings/oauth') ? ' active ' : '') }}">第三方账号</a>
</div>