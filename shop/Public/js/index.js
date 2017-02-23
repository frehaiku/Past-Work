$(document).ready(function() {

    var temp = 1;
    $("#Issue").click(function() {

        if (temp) {
            //将箭头翻转
            $("#ArrowUp").css({
                "-webkit-transform": "rotate(180deg)",
                "transform": "rotate(180deg)"
            });
            //将点我发布字体颜色
            $(this).css({
                "color": "#fff",
                "background": "#06cab4"
            });

            //滑块滑下

            $("#IssueDetail").css({
                "-webkit-transform": "translateY(0px)",
                "transform": "translateY(0px)"
            });
            temp = 0;
        } else {
            $(this).css({
                "color": "#000",
                "background": "#fff"
            });
            $("#IssueDetail").css({
                "-webkit-transform": "translateY(-260px)",
                "transform": "translateY(-260px)"
            });
            $("#ArrowUp").css({
                "-webkit-transform": "rotate(0deg)",
                "transform": "rotate(0deg)"
            });
            temp = 1;
        }

    });

    //日期处理
    $(".describe .date").each(function(index, element) {

        var content = $(element).html();


        $(element).html(content.slice(0, 10));
    });

    //瀑布流宽度控制
    var IssueContentWidth = $("#IssueContent").width();
    $("#IssueContent li.detail_block").css({
        'width': IssueContentWidth / 2 - 4 + 'px'
    });

    //a标签点击后变样式
    $('#nav_top a').each(function() {
        if ($($(this))[0].href == String(window.location))
            $(this).addClass('border_bottom').attr('href', 'javascript:void(0);');
    });

});
