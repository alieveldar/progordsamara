function TimeLineLeft() {
    clas = 'TimeLine';
    nowtimeline = nowtimeline - 1;
    if (nowtimeline < 0) {
        nowtimeline = 0;
    }
    $("." + clas).hide();
    $("#" + clas + "-" + nowtimeline).show();
    TimeLineArrows();
}

function TimeLineRight() {
    clas = 'TimeLine';
    nowtimeline = nowtimeline + 1;
    if (nowtimeline > totaltimeline) {
        nowtimeline = totaltimeline;
    }
    $("." + clas).hide();
    $("#" + clas + "-" + nowtimeline).show();
    TimeLineArrows();
}

function TimeLineArrows() {
    $("#TimeLineRight").html("<img src='/template/standart/tright1.png' onclick='TimeLineRight();'>");
    $("#TimeLineLeft").html("<img src='/template/standart/tleft1.png' onclick='TimeLineLeft();'>");
    if (nowtimeline == 0) {
        $("#TimeLineLeft").html("<img src='/template/standart/tleft0.png' style='cursor:default;'>");
    }
    if (nowtimeline == totaltimeline) {
        $("#TimeLineRight").html("<img src='/template/standart/tright0.png' style='cursor:default;'>");
    }
}