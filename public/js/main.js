$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Authorization': 'Bearer siEfbBwWenpn6vmnzsvSF3wCJWE5Z3V33gUqDkOD'
        }
    });

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
});