$(function () {

    function setAjaxHeaders() {
        var headers = {};
        //headers['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');

        var authorization = getAuthorizationHeader();
        if (null !== authorization) {
            headers['Authorization'] = authorization;
        }

        $.ajaxSetup({
            headers: headers
        });
    }

    setAjaxHeaders();

    var hash = window.location.hash;
    hash && $('ul.nav a[href="' + hash + '"]').tab('show');

    $('.nav-tabs a').click(function (e) {
        $(this).tab('show');
        var scrollmem = $('body').scrollTop();
        window.location.hash = this.hash;
        $('html,body').scrollTop(scrollmem);
    });


    // 输入时统计统计贴子标题字数
    $('#topic_title').keyup(function () {
        topicTitleRemain();
    });

    function topicTitleRemain() {
        if (undefined === $('#topic_title').val()) {
            return;
        }
        var remain = 80 - $('#topic_title').val().length;
        var remainSpan = $('#topic_title_remain');
        if (remain >= 0) {
            remainSpan.text(remain).removeClass('color_red');
        } else {
            remainSpan.text(remain).addClass('color_red');
        }
    }

    topicTitleRemain();


    $('#login_btn').click(function (event) {
        event.preventDefault();

        var form = $('#login_form');
        var url = form.attr('action');
        var postData = form.serialize();

        $.ajax({
            type: 'POST',
            url: url,
            data: postData,
            success: function (res) {
                setTokens(res);
                window.location.href = '/';
            },
            error: function (xhr) {
                var res = xhr.responseJSON;
                console.log('error', res);
            }
        });
    });

    function setTokens(tokens) {
        localStorage.setItem('set_tokens_created_at', (new Date()).getTime());
        for (var key in tokens) {
            localStorage.setItem(key, tokens[key]);
        }
    }

    function clearTokens() {
        var keys = [
            'access_token',
            'expires_in',
            'refresh_token',
            'token_type',
            'set_tokens_created_at'
        ];
        for (var i in keys) {
            localStorage.removeItem(keys[i]);
        }
    }

    function refreshToken(refresh_token) {
        $.ajax({
            async: false,
            type: 'POST',
            url: global_urls.refresh_token,
            data: {
                refresh_token: refresh_token
            },
            success: function (res) {
                setTokens(res);
            },
            error: function (xhr) {
                var res = xhr.responseJSON;
                console.log('error', res);
            }
        });
    }

    function getAccessToken() {
        if (null === localStorage.getItem('set_tokens_created_at') ||
            null === localStorage.getItem('expires_in') ||
            null === localStorage.getItem('access_token') ||
            null === localStorage.getItem('refresh_token')) {
            return null;
        }

        var currentTime = (new Date()).getTime();
        var isExpired = (localStorage.getItem('set_tokens_created_at') + localStorage.getItem('expires_in'))
            < currentTime;
        // access_token 未过期
        if (!isExpired) {
            return localStorage.getItem('access_token');
        }

        refreshToken(localStorage.getItem('refresh_token'));

        return localStorage.getItem('access_token') ? localStorage.getItem('access_token') : null;
    }

    function getAuthorizationHeader() {
        var tokenType = localStorage.getItem('token_type');
        var accessToken = getAccessToken();
        if (null !== tokenType && null !== accessToken) {
            return tokenType + ' ' + accessToken;
        }
        return null;
    }


    $('#create_topic_btn').click(function (event) {
        event.preventDefault();

        var form = $('#create_topic_form');
        var url = form.attr('action');
        var postData = form.serialize();

        $.post(url, postData, function (res) {
            if (res.data.id) {
                window.location.href = topic_urls.list + '/' + res.data.id;
            }
        });
    });


    $('#update_topic_btn').click(function (event) {
        event.preventDefault();

        var form = $('#update_topic_form');
        var url = form.attr('action');
        var postData = form.serialize();
        //var topicId = form.attr('data-id');

        $.post(url, postData, function (res) {
            if (res.data.id) {
                window.location.href = topic_urls.list + '/' + res.data.id;
            }
        });
    });


    $('#delete_topic').click(function () {
        if (!confirm('确定要删除吗？')) {
            return;
        }

        var url = $(this).attr('data-url');
        var postData = {
            _method: $(this).attr('data-method')
        };

        $.post(url, postData, function (res) {
            if (res.data) {
                window.location.href = topic_urls.list;
            } else {
                alert(res.message);
            }
        });
    });


    $('#create_reply_btn').click(function (event) {
        event.preventDefault();

        var form = $('#create_reply_form');
        var url = form.attr('action');
        var postData = form.serialize();

        $.post(url, postData, function (res) {
            if (res.data.id) {
                alert('回复成功');
            }
        });
    });
});