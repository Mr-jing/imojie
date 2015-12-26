$(function () {
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
        var remain = 80 - $(this).val().length;
        var remainSpan = $('#topic_title_remain');
        if (remain >= 0) {
            remainSpan.text(remain).removeClass('color_red');
        } else {
            remainSpan.text(remain).addClass('color_red');
        }
    });
});