$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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


    $('#delete_topic').click(function () {
        console.log($(this).attr('data-url'), $(this).attr('data-method'));

        var postData = {
            _method: $(this).attr('data-method')
        };
        $.post($(this).attr('data-url'), postData, function (res) {
            console.log(res);
            $('#delete_topic').attr('data-url', "http://imojie.my/topic/14");
        });
    });
});