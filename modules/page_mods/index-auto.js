function MainTvHover(id, pic, name, path) {
    $('.MainTVListItem2').attr('class', 'MainTVListItem1');
    $('#MainTV-' + id).attr('class', 'MainTVListItem2');
    var text = "<a href='" + path + id + "'><img src='/userfiles/picintv/" + pic + "'></a><div><h1><a href='" + path + id + "'>" + name + "</a></h1></div>";
    $('#MainTVPic').html(text);
}

function ShowOtherBox(id, clas) {
    $("." + clas).hide();
    $("#" + clas + "-" + id).show();
    $("." + clas + "-knopka").attr("class", clas + "-knopka");
    $("#" + clas + "-knopka-" + id).attr("class", clas + "-knopka bg");
}