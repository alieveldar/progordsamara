$(function () {
    var tr = new Date(2014, 11, 2);
    $('#countdown').countdown({timestamp: tr});
});

function ShowMore() {
    $("#More").html("<img src='/template/instasamara/load.gif'>");
    JsHttpRequest.query('/modules/page_mods/mysamara-JSReq.php', {'id': lastid}, function (result, errors) {
        if (result) {
            lastid = result["lastid"];
            if (result["code"] == 1) {
                $("#More").html("<a href='javascript:void(0)' onclick='ShowMore()'><img src='/template/instasamara/dot.jpg'></a>");
            } else {
                $("#More").html("");
            }
            $("#works").append(result["text"]);
            $("a[rel^='prettyPhoto" + result["part"] + "']").prettyPhoto({showTitle: false});
        }
    }, true);
}