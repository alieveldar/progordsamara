var flashInstalled;
var OpenWin = 0;
var OpenTools = 0;
var Speed = 500;
var Blankw = 600;
var Blankh = 350;
var Startw = 600;
var podlogused = 0;
var path = document.location;
var Setis = 0;
var toup = 0;
document.onkeypress = getText;
var bands = "";
var admins = new Array(10, 100);
$(function () {
    /* смайлики */
    $(document).click(function (e) {
        $('.SmilesGroup').hide();
    });
    $('.Smiles .toggle').live('click', function (e) {
        $('.SmilesGroup').not($('.SmilesGroup', $(this).parents('.Smiles'))).hide();
        $('.SmilesGroup', $(this).parents('.Smiles')).toggle();
        e.stopPropagation();
    });
    /* Всплывающая фотка */
    $("a[rel^='prettyPhoto']").prettyPhoto({showTitle: false});
    /* Мультиаплоад фоток */
    if ($('#uploadercom').size()) {
        UploadsInComments();
    }
    /* Кнопка "наверх" */
    $(window).scroll(function () {
        ToUpReady();
    });
    /* Баннерная система */
    flashInstalled = BannersFlash();
    setTimeout(BannersSystem, 100);
    /* Перемешать новости */
    $(".ReOneOrder").shuffle();
    $(".ReTwoOrder").shuffle();
    $('.ArticleContent a').each(function () {
        var a = new RegExp('/' + window.location.host + '/');
        if (!a.test(this.href)) {
            $(this).click(function (event) {
                event.preventDefault();
                event.stopPropagation();
                window.open(this.href, '_blank');
            });
        }
    });

    /*удалить pretty с фото*/

    var $link = $('.nopopup').parent().unbind('click').attr('rel', '');
    var $reklama = $link.prev().attr('href');
    $link.attr('href', $reklama);


});



/* Перехват нажатий */
$(document).keyup(function (e) {
    if (e.keyCode == 27 && $("#BoxCount").val() != "0") {
        CloseBlank();
    }
});
$(".UserLoginInput").live('keyup', function (e) {
    if (e.keyCode == 13) {
        id = $(this).parent().attr("id");
        UserLoginFunc(id)
    }
});
/* Кнопка "Наверх" */
/* function ToUpReady() { var sc=$(window).scrollTop(); if (sc>=300 && toup==0) { toup=1; $("#ToUp").show(); var ht=$(".ToUp").html(); if (ht.length>50) { $(".ToUp").show(); }} if (sc<300 && toup==1) { toup=0; $("#ToUp").hide(); $(".ToUp").hide(); }}function DocToUp() { $(window).scrollTop(0); } */

/* Кнопка наверх и всплывающий блок с предложениями экономии */
function DocToUp() {
    $(window).scrollTop(0);
}

function ToUpReady() {
    var sc = $(window).scrollTop();
    if (sc >= 300 && toup == 0) {
        toup = 1;
        $("#ToUp").show();
        $("#Actionsr").show();
        var ht = $(".ToUp").html();
        if (ht.length > 50) {
            $(".ToUp").show();
        }
    }
    if (sc < 300 && toup == 1) {
        toup = 0;
        $("#ToUp").hide();
        $("#Actionsr").hide();
        $(".ToUp").hide();
    }
}

/* Всплывающее окно */
function Qdelta(progress) {
    return (progress * progress);
}

function Fdelta(progress) {
    return Math.pow(progress, 1 / 2.5);
}

function findOffsetHeight() {
    var e = document.getElementById("InnerCont");
    var res = 0;
    while ((res == 0) && e.parentNode) {
        e = e.parentNode;
        res = e.offsetHeight;
    }
    return res;
}

function findOffsetWidth() {
    return (document.body.scrollWidth > document.body.offsetWidth) ? document.body.scrollWidth : document.body.offsetWidth;
}

function ViewBlank(caption, text) {
    var Totalh = findOffsetHeight();
    var Totalw = findOffsetWidth();
    if (OpenWin == 0) {
        OpenWin = 1;
        var div = document.createElement('div');
        div.setAttribute('id', 'inBlock');
        div.className = ('inBlock');
        document.body.appendChild(div);
        div.innerHTML = "<div class='OpenName'>" + caption + "</div><div class='OpenLink'><img id='CloseBtn' class='CloseBar0' src='/admin/images/icons/exit.png' title='Закрыть' onmouseover=\"this.className='CloseBar1';\" onmouseout=\"this.className='CloseBar0';\" onClick='CloseBlank();'></div><div class='C5'></div><div id='ContentBox'>" + text + "</div><div class='C'></div>";
        if (document.documentElement.scrollTop == 0) {
            var yoffset = document.body.scrollTop;
        } else {
            var yoffset = document.documentElement.scrollTop;
        }
        Nheight = div.clientHeight;
        Nwidth = div.clientWidth;
        div.style.marginLeft = "-" + (Nwidth / 2) + "px";
        Nint = setInterval(GetNewOffset, 500);
        document.getElementById('BoxCount').value = Nint;
        var elem = document.getElementById('BoxUp');
        elem.style.display = "block";
        elem.style.width = Totalw + "px";
        elem.style.height = Totalh + "px";
        speed = 300;
        start = new Date().getTime();
        setTimeout(function () {
            now = (new Date().getTime()) - start;
            if (now < speed) {
                setElementOpacity("BoxUp", Qdelta(now / speed) / 2);
                setTimeout(arguments.callee, 10);
            } else {
                setElementOpacity("BoxUp", 0.5);
            }
        }, 10);
        speed2 = 300;
        start2 = new Date().getTime();
        setTimeout(function () {
            now2 = (new Date().getTime()) - start2;
            if (now2 < speed2) {
                setElementOpacity("inBlock", Qdelta(now / speed));
                setTimeout(arguments.callee, 10);
            } else {
                setElementOpacity("inBlock", 1);
            }
        }, 10);
    }
}

function GetNewOffset(Nheight) {
    if (document.documentElement.scrollTop == 0) {
        var yoffset = document.body.scrollTop;
    } else {
        var yoffset = document.documentElement.scrollTop;
    }
    Nh = document.getElementById('inBlock').clientHeight;
    Nh = Nh / 2;
    Tops = yoffset - Nh;
    document.getElementById('inBlock').style.marginTop = Tops + 'px';
}

function CloseBlank() {
    element = document.getElementById('inBlock');
    if (element) {
        element.parentNode.removeChild(element);
    }
    Nint = document.getElementById('BoxCount').value;
    clearInterval(Nint);
    document.getElementById('BoxCount').value = '0';
    speed = 300;
    start = new Date().getTime();
    setTimeout(function () {
        now = (new Date().getTime()) - start;
        if (now < speed) {
            setElementOpacity("BoxUp", 0.5 - Qdelta(now / speed) / 2);
            setTimeout(arguments.callee, 10);
        } else {
            setElementOpacity("BoxUp", 0);
            document.getElementById('BoxUp').style.display = 'none';
            OpenWin = 0;
        }
    }, 10);
}

function setElementOpacity(sElemId, nOpacity) {
    var opacityProp = getOpacityProperty();
    var elem = document.getElementById(sElemId);
    if (!elem || !opacityProp) {
        return false;
    }
    ;
    if (opacityProp == "filter") {
        nOpacity *= 100;
        var oAlpha = elem.filters['DXImageTransform.Microsoft.alpha'] || elem.filters.alpha;
        if (oAlpha) {
            oAlpha.opacity = nOpacity;
        } else {
            elem.style.filter += "progid:DXImageTransform.Microsoft.Alpha(opacity=" + nOpacity + ")";
        }
    } else {
        elem.style[opacityProp] = nOpacity;
    }
}

function getOpacityProperty() {
    if (typeof document.body.style.opacity == 'string') {
        return 'opacity';
    } else if (typeof document.body.style.MozOpacity == 'string') {
        return 'MozOpacity';
    } else if (typeof document.body.style.KhtmlOpacity == 'string') {
        return 'KhtmlOpacity';
    } else if (document.body.filters && navigator.appVersion.match(/MSIE ([\d.]+);/)[1] >= 5.5) {
        return 'filter';
    }
    return false;
}

/* Проверка авторизации */
function UserAuthEnter(caption, redirect_uri) {
    text = "<div id='uLogin1' x-ulogin-params='display=panel&fields=first_name,last_name,photo&providers=vkontakte,facebook,twitter,google,mailru,odnoklassniki,yandex&redirect_uri=" + redirect_uri + "'></div><div class='C15'></div><div class='Info'><b style='color:red;'>Внимание!</b> Регистрируясь и совершая любые действия на сайте,<br>вы автоматически соглашаетесь с <a href='/agreement'><u><b>Пользовательским соглашением</b></u></a>.<br>Если вы не согласны с <a href='/agreement'><b><u>Cоглашением</u></b></a>, пожалуйста, покиньте сайт.<div class='C15'></div><div class='Info'>Социальные сети не передают нам ваши логин и пароль,<br>мы получаем только имя и аватар пользователя.</div></div><div class='C'></div>";
    ViewBlank(caption, text);
    uLogin.initWidget('uLogin1');
    uLogin.initWidget('uLogin2');
    uLogin.initWidget('uLogin3');
}

function parseGetParams() {
    var $_GET = {};
    var __GET = window.location.search.substring(1).split("&");
    for (var i = 0; i < __GET.length; i++) {
        var getVar = __GET[i].split("=");
        $_GET[getVar[0]] = typeof(getVar[1]) == "undefined" ? "" : getVar[1];
    }
    return $_GET;
}

/* Авторизация */
function UserLoginFunc(f) {
    var l = $("#" + f + " #UserLoginLogin").val();
    var p = $("#" + f + " #UserLoginPassword").val();
    if (l != "" && p != "") {
        $("#" + f + " #UserLoginMsg").html("Идет проверка логина и пароля...");
        $("#" + f + " #UserLoginMsg").show();
        $("#" + f + " #UserLoginMsg").attr("class", "SaveDiv");
        JsHttpRequest.query('/modules/standart/UsersLogin-JSReq.php', {
            'login': l,
            'password': p
        }, function (result, errors) {
            if (result) { /*s*/
                $("#" + f + " #UserLoginMsg").html(result["Text"]);
                $("#" + f + " #UserLoginMsg").show();
                $("#" + f + " #UserLoginMsg").attr("class", result["Class"]);
                if (result["Code"] == 1) {
                    document.location = document.location;
                }
                /*e*/
            }
        }, true);
    }
}

/* Регистрация */
function UserRegisterFunc() {
    var error = 0;
    var l = $("#UserRegLogin").val();
    var p = $("#UserRegPassword").val();
    var e = $("#UserRegEmail").val();
    var n = $("#UserRegNick").val();
    if (l == "" || p == "" || n == "" || e == "") {
        error = 1;
        $("#UserLoginMsg").html("Необходимо заполнить все поля формы");
        $("#UserLoginMsg").show();
        $("#UserLoginMsg").attr("class", "ErrorDiv");
    }
    if (e != "undefined" && e != "") {
        if ((/^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,4}$/i).test(e) != true) {
            error = 1;
            $("#UserLoginMsg").html("Указан неверный электронный адрес");
            $("#UserLoginMsg").show();
            $("#UserLoginMsg").attr("class", "ErrorDiv");
        }
    }
    if (error == 0) {
        $("#UserLoginMsg").html("Идет регистрация...");
        $("#UserLoginMsg").show();
        $("#UserLoginMsg").attr("class", "SaveDiv");
        JsHttpRequest.query('/modules/standart/UsersRegister-JSReq.php', {
            'l': l,
            'p': p,
            'n': n,
            'e': e
        }, function (result, errors) {
            if (result) { /*s*/
                $("#UserLoginMsg").html(result["Text"]);
                $("#UserLoginMsg").show();
                $("#UserLoginMsg").attr("class", result["Class"]);
                if (result["Code"] == 1) {
                    document.location = document.location;
                }
                /*e*/
            }
        }, true);
    }
}

/* Ошибки в тексте - выделение */
function getText(e) {
    nN = navigator.appName;
    if (!e) {
        e = window.event
    }
    ;
    if ((e.ctrlKey) && ((e.keyCode == 10) || (e.keyCode == 13))) {
        if (nN == 'Microsoft Internet Explorer') {
            if (document.selection.createRange()) {
                var range = document.selection.createRange();
                mis = range.text;
                misForm(mis);
            }
        } else {
            if (window.getSelection()) {
                mis = window.getSelection();
                misForm(mis);
            } else if (document.getSelection()) {
                mis = document.getSelection();
                misForm(mis);
            }
        }
        return true;
    }
    return true;
}

/* Ошибки в тексте - форма*/
function misForm(mis) {
    if (mis == '') return false;
    var loc = window.location;
    var caption = 'Уведомление об ошибке';
    var text = '<form id="misForm" onsubmit="return false">';
    text += '<div class="MiddleInput"><strong>Адрес страницы :</strong><input name="misUrl" value="' + window.location + '" /></div><div class="C10"></div>';
    text += '<div class="MiddleInput"><strong>Ошибка :</strong><textarea name="misText">' + mis + '</textarea></div><div class="C10"></div>';
    text += '<div class="MiddleInput"><strong>Комментарий : </strong><textarea name="misComment"></textarea></div><div class="C10"></div>';
    text += '<div class="CenterText"><input type="submit" name="sendbutton" id="sendbutton" class="SaveButton" value="Отправить" onclick="misSave()"></div>';
    text += '</form>';
    ViewBlank(caption, text);
}

/* Ошибки в тексте - отправка */
function misSave() {
    var misUrl = $('input[name=misUrl]').val();
    var misText = $('textarea[name=misText]').val();
    var misComment = $('textarea[name=misComment]').val();
    JsHttpRequest.query('/modules/standart/MisSave-JSReq.php', {
        'misUrl': misUrl,
        'misText': misText,
        'misComment': misComment
    }, function (result, errors) {
        if (result) { /*s*/
            if (result["Code"] == 1) {
                $("#misForm").html(result["Text"]);
            }
            /*e*/
        }
    }, true);
}

/* Ответ на коммент */
function CommentAnswer(id) {
    text = "В ответ на <b><a href='#comment" + id + "'>комментарий</a></b> пользователя <b><a href='" + $("#UserIdComment-" + id).parent('a').attr('href') + "'>" + $("#UserIdComment-" + id).html() + "</a></b>";
    $(".UserComAnswer:last").html(text).show();
    $(".UserComAnswerC:last").html("<a href='javascript:void(0);' onclick='CommentAnswerCancel();'>Отмена</a>").show();
    document.location = "#addcomment";
}

/* Отмена Ответ на коммент */
function CommentAnswerCancel() {
    $(".UserComAnswer:last, .UserComAnswerC:last").html("").hide();
}

/* Форма редактирования комментария */
function GetCommentForm(id) {
    $("img, a", $("#CommentItem-" + id + " .CommentEdit")).toggle();
    JsHttpRequest.query('/modules/standart/UsersComment-Edit-JSReq.php', {
        'id': id,
        'action': 'form'
    }, function (result, errors) {
        $("img", $("#CommentItem-" + id + " .CommentEdit")).toggle();
        if (result) { /*s*/
            if (result["Code"] == 1) {
                $("#CommentItem-" + id + " .view1").hide();
                $("#CommentItem-" + id + " .view2").html(result["Text"]);
            }
            /*e*/
        }
    }, true);
}

/* Отмена редактирования конмментария */
function CancelEditComment(id) {
    $("a", $("#CommentItem-" + id + " .CommentEdit")).toggle();
    $("#CommentItem-" + id + " .view1").show();
    $("#CommentItem-" + id + " .view2").empty();
}

/* Удаление комментария */
function CommentDelete(id) {
    $("img, a", $("#CommentItem-" + id + " .CommentDelete")).toggle();
    ;JsHttpRequest.query('/modules/standart/UsersComment-Del-JSReq.php', {'id': id}, function (result, errors) {
        if (result) { /*s*/
            if (result["Code"] == 1) {
                $("#CommentItem-" + id).fadeOut(500);
            }
            /*e*/
        }
    }, true);
}

/* Файлы в коментах*/
function UploadsInComments() {
    var uploadercom = new qq.FineUploader({
        element: document.getElementById('uploadercom'),
        request: {endpoint: '/modules/standart/multiupload/server/handler3.php', paramsInBody: false,},
        callbacks: {
            onComplete: function (id, fileName, responseJSON) {
                if (responseJSON.success) $('#uploadercompics').html($('#uploadercompics').html() + responseJSON.uploadName + ';');
            }
        },
        debug: true
    });
}

/* Отправить отредактированный комментарий */
function EditUserComment(id, form) {
    obj = $(".CommentMsg", form);
    obj.html("Идет отправка комментария...");
    obj.show();
    obj.attr("class", "SaveDiv");
    if ($(".UserComText", form).val() != "") {
        var t = $(".UserComText", form).val();
    } else {
        obj.html("Введите текст комментария!");
        obj.attr("class", "ErrorDiv");
        return false;
    }
    $(".CommentSend", form).html("<img src='/template/standart/loader2.gif' style='padding:10px;' />");
    JsHttpRequest.query('/modules/standart/UsersComment-Edit-JSReq.php', {'t': t, 'id': id}, function (result, errors) {
        if (result) { /*s*/
            obj.html(result["Text"]);
            obj.attr("class", result["Class"]);
            if (result["Code"] == 1) {
                $("a", $("#CommentItem-" + id + " .CommentEdit")).toggle();
                $("#CommentItem-" + id + " .view2").empty();
                $("#CommentItem-" + id + " .view1").html(result["Comment"]).show();
            } else {
                $(".CommentSave", form).html("<input type='submit' name='sendbutton' class='SaveButton' value='Сохранить комментарий' onClick=\"EditUserComment(" + id + ", $(this).parents('.UserCommentsForm2'));\">");
            }
            /*e*/
        }
    }, true);
}

/* Отправить комментарий */
function SendUserComment(form) {
    obj = $(".CommentMsg", form);
    var vki = $("#gidvk").val();
    obj.html("Идет отправка комментария...");
    obj.show();
    obj.attr("class", "SaveDiv");
    var an = $(".UserComAnswer", form).html();
    if ($(".UserComName", form).val()) {
        var n = $(".UserComName", form).val();
    } else {
        var n = "";
    }
    var f = $("#uploadercompics", form).html();
    if ($(".UserComText", form).val() != "") {
        var t = $(".UserComText", form).val();
    } else {
        obj.html("Введите текст комментария!");
        obj.attr("class", "ErrorDiv");
        return false;
    }
    if ($(".UserComCaptcha", form)) {
        if ($(".UserComCaptcha", form).val() == "") {
            obj.html("Введите защитный код!");
            obj.attr("class", "ErrorDiv");
            return false;
        } else {
            var c = $(".UserComCaptcha", form).val();
        }
    } else {
        var c = "";
    }
    $(".CommentSend", form).html("<img src='/template/standart/loader2.gif' style='padding:10px;' />");
    JsHttpRequest.query('/modules/standart/UsersComment-JSReq.php', {
        'n': n,
        't': t,
        'c': c,
        'f': f,
        'an': an,
        'vki': vki
    }, function (result, errors) {
        if (result) { /*s*/
            if (result["Code"] == 10) {
                document.location = "/users/lostid";
            }
            $(".CommentSend", form).html("<input type='submit' name='sendbutton' class='SaveButton' value='Добавить комментарий' onClick=\"SendUserComment($(this).parents('.UserCommentsForm'));\">");
            obj.html(result["Text"]);
            obj.attr("class", result["Class"]);
            if (result["Code"] == 1) {
                $("#UserComAnswer", form).html("");
                $(".UserComAnswerC", form).html("");
                $(".UserComAnswer", form).hide();
                $(".UserComAnswerC", form).hide();
                $("#NoComments").remove();
                $("#UserCommentsList").append(result["Comment"]);
                $(".UserComText", form).val("");
                $("#uploadercompics", form).html("");
                $(".UserComCaptcha", form).val("");
                $(".captchaImg", form).attr("src", $(".captchaImg", form).attr("src").replace(/\d+$/, Math.random()));
            }
            /*e*/
        }
    }, true);
}

/* Нравится комментарий */
function likeSaveComment(qid, pid) {
    $("#CommentLike-" + pid).html("<img src='/template/standart/loader.gif' style='float:right; margin-top:4px;'>");
    JsHttpRequest.query('/modules/standart/UsersComment-Like-JSReq.php', {
        'qid': qid,
        'pid': pid
    }, function (result, errors) {
        if (result) { /*s*/
            $("#CommentLike-" + pid).html(result["text"]);
            /*e*/
        }
    }, true);
}

/* Перемешать элементы */
(function ($) {
    $.fn.shuffle = function () {
        var allElems = this.get(), getRandom = function (max) {
            return Math.floor(Math.random() * max);
        }, shuffled = $.map(allElems, function () {
            var random = getRandom(allElems.length), randEl = $(allElems[random]).clone(true)[0];
            allElems.splice(random, 1);
            return randEl;
        });
        this.each(function (i) {
            $(this).replaceWith($(shuffled[i]));
        });
        return $(shuffled);
    };
})(jQuery);
/* Мультиплатформа SWF */
var swfobject = function () {
    var b = "undefined", Q = "object", n = "Shockwave Flash", p = "ShockwaveFlash.ShockwaveFlash",
        P = "application/x-shockwave-flash", m = "SWFObjectExprInst", j = window, K = document, T = navigator, o = [],
        N = [], i = [], d = [], J, Z = null, M = null, l = null, e = false, A = false;
    var h = function () {
        var v = typeof K.getElementById != b && typeof K.getElementsByTagName != b && typeof K.createElement != b,
            AC = [0, 0, 0], x = null;
        if (typeof T.plugins != b && typeof T.plugins[n] == Q) {
            x = T.plugins[n].description;
            if (x && !(typeof T.mimeTypes != b && T.mimeTypes[P] && !T.mimeTypes[P].enabledPlugin)) {
                x = x.replace(/^.*\s+(\S+\s+\S+$)/, "$1");
                AC[0] = parseInt(x.replace(/^(.*)\..*$/, "$1"), 10);
                AC[1] = parseInt(x.replace(/^.*\.(.*)\s.*$/, "$1"), 10);
                AC[2] = /r/.test(x) ? parseInt(x.replace(/^.*r(.*)$/, "$1"), 10) : 0
            }
        } else {
            if (typeof j.ActiveXObject != b) {
                var y = null, AB = false;
                try {
                    y = new ActiveXObject(p + ".7")
                } catch (t) {
                    try {
                        y = new ActiveXObject(p + ".6");
                        AC = [6, 0, 21];
                        y.AllowScriptAccess = "always"
                    } catch (t) {
                        if (AC[0] == 6) {
                            AB = true
                        }
                    }
                    if (!AB) {
                        try {
                            y = new ActiveXObject(p)
                        } catch (t) {
                        }
                    }
                }
                if (!AB && y) {
                    try {
                        x = y.GetVariable("$version");
                        if (x) {
                            x = x.split(" ")[1].split(",");
                            AC = [parseInt(x[0], 10), parseInt(x[1], 10), parseInt(x[2], 10)]
                        }
                    } catch (t) {
                    }
                }
            }
        }
        var AD = T.userAgent.toLowerCase(), r = T.platform.toLowerCase(),
            AA = /webkit/.test(AD) ? parseFloat(AD.replace(/^.*webkit\/(\d+(\.\d+)?).*$/, "$1")) : false, q = false,
            z = r ? /win/.test(r) : /win/.test(AD), w = r ? /mac/.test(r) : /mac/.test(AD);
        /*@cc_on q=true;@if(@_win32)z=true;@elif(@_mac)w=true;@end@*/
        return {w3cdom: v, pv: AC, webkit: AA, ie: q, win: z, mac: w}
    }();
    var L = function () {
        if (!h.w3cdom) {
            return
        }
        f(H);
        if (h.ie && h.win) {
            try {
                K.write("<script id=__ie_ondomload defer=true src=//:><\/script>");
                J = C("__ie_ondomload");
                if (J) {
                    I(J, "onreadystatechange", S)
                }
            } catch (q) {
            }
        }
        if (h.webkit && typeof K.readyState != b) {
            Z = setInterval(function () {
                if (/loaded|complete/.test(K.readyState)) {
                    E()
                }
            }, 10)
        }
        if (typeof K.addEventListener != b) {
            K.addEventListener("DOMContentLoaded", E, null)
        }
        R(E)
    }();

    function S() {
        if (J.readyState == "complete") {
            J.parentNode.removeChild(J);
            E()
        }
    }

    function E() {
        if (e) {
            return
        }
        if (h.ie && h.win) {
            var v = a("span");
            try {
                var u = K.getElementsByTagName("body")[0].appendChild(v);
                u.parentNode.removeChild(u)
            } catch (w) {
                return
            }
        }
        e = true;
        if (Z) {
            clearInterval(Z);
            Z = null
        }
        var q = o.length;
        for (var r = 0; r < q; r++) {
            o[r]()
        }
    }

    function f(q) {
        if (e) {
            q()
        } else {
            o[o.length] = q
        }
    }

    function R(r) {
        if (typeof j.addEventListener != b) {
            j.addEventListener("load", r, false)
        } else {
            if (typeof K.addEventListener != b) {
                K.addEventListener("load", r, false)
            } else {
                if (typeof j.attachEvent != b) {
                    I(j, "onload", r)
                } else {
                    if (typeof j.onload == "function") {
                        var q = j.onload;
                        j.onload = function () {
                            q();
                            r()
                        }
                    } else {
                        j.onload = r
                    }
                }
            }
        }
    }

    function H() {
        var t = N.length;
        for (var q = 0; q < t; q++) {
            var u = N[q].id;
            if (h.pv[0] > 0) {
                var r = C(u);
                if (r) {
                    N[q].width = r.getAttribute("width") ? r.getAttribute("width") : "0";
                    N[q].height = r.getAttribute("height") ? r.getAttribute("height") : "0";
                    if (c(N[q].swfVersion)) {
                        if (h.webkit && h.webkit < 312) {
                            Y(r)
                        }
                        W(u, true)
                    } else {
                        if (N[q].expressInstall && !A && c("6.0.65") && (h.win || h.mac)) {
                            k(N[q])
                        } else {
                            O(r)
                        }
                    }
                }
            } else {
                W(u, true)
            }
        }
    }

    function Y(t) {
        var q = t.getElementsByTagName(Q)[0];
        if (q) {
            var w = a("embed"), y = q.attributes;
            if (y) {
                var v = y.length;
                for (var u = 0; u < v; u++) {
                    if (y[u].nodeName == "DATA") {
                        w.setAttribute("src", y[u].nodeValue)
                    } else {
                        w.setAttribute(y[u].nodeName, y[u].nodeValue)
                    }
                }
            }
            var x = q.childNodes;
            if (x) {
                var z = x.length;
                for (var r = 0; r < z; r++) {
                    if (x[r].nodeType == 1 && x[r].nodeName == "PARAM") {
                        w.setAttribute(x[r].getAttribute("name"), x[r].getAttribute("value"))
                    }
                }
            }
            t.parentNode.replaceChild(w, t)
        }
    }

    function k(w) {
        A = true;
        var u = C(w.id);
        if (u) {
            if (w.altContentId) {
                var y = C(w.altContentId);
                if (y) {
                    M = y;
                    l = w.altContentId
                }
            } else {
                M = G(u)
            }
            if (!(/%$/.test(w.width)) && parseInt(w.width, 10) < 310) {
                w.width = "310"
            }
            if (!(/%$/.test(w.height)) && parseInt(w.height, 10) < 137) {
                w.height = "137"
            }
            K.title = K.title.slice(0, 47) + " - Flash Player Installation";
            var z = h.ie && h.win ? "ActiveX" : "PlugIn", q = K.title,
                r = "MMredirectURL=" + j.location + "&MMplayerType=" + z + "&MMdoctitle=" + q, x = w.id;
            if (h.ie && h.win && u.readyState != 4) {
                var t = a("div");
                x += "SWFObjectNew";
                t.setAttribute("id", x);
                u.parentNode.insertBefore(t, u);
                u.style.display = "none";
                var v = function () {
                    u.parentNode.removeChild(u)
                };
                I(j, "onload", v)
            }
            U({data: w.expressInstall, id: m, width: w.width, height: w.height}, {flashvars: r}, x)
        }
    }

    function O(t) {
        if (h.ie && h.win && t.readyState != 4) {
            var r = a("div");
            t.parentNode.insertBefore(r, t);
            r.parentNode.replaceChild(G(t), r);
            t.style.display = "none";
            var q = function () {
                t.parentNode.removeChild(t)
            };
            I(j, "onload", q)
        } else {
            t.parentNode.replaceChild(G(t), t)
        }
    }

    function G(v) {
        var u = a("div");
        if (h.win && h.ie) {
            u.innerHTML = v.innerHTML
        } else {
            var r = v.getElementsByTagName(Q)[0];
            if (r) {
                var w = r.childNodes;
                if (w) {
                    var q = w.length;
                    for (var t = 0; t < q; t++) {
                        if (!(w[t].nodeType == 1 && w[t].nodeName == "PARAM") && !(w[t].nodeType == 8)) {
                            u.appendChild(w[t].cloneNode(true))
                        }
                    }
                }
            }
        }
        return u
    }

    function U(AG, AE, t) {
        var q, v = C(t);
        if (v) {
            if (typeof AG.id == b) {
                AG.id = t
            }
            if (h.ie && h.win) {
                var AF = "";
                for (var AB in AG) {
                    if (AG[AB] != Object.prototype[AB]) {
                        if (AB.toLowerCase() == "data") {
                            AE.movie = AG[AB]
                        } else {
                            if (AB.toLowerCase() == "styleclass") {
                                AF += ' class="' + AG[AB] + '"'
                            } else {
                                if (AB.toLowerCase() != "classid") {
                                    AF += " " + AB + '="' + AG[AB] + '"'
                                }
                            }
                        }
                    }
                }
                var AD = "";
                for (var AA in AE) {
                    if (AE[AA] != Object.prototype[AA]) {
                        AD += '<param name="' + AA + '" value="' + AE[AA] + '" />'
                    }
                }
                v.outerHTML = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"' + AF + ">" + AD + "</object>";
                i[i.length] = AG.id;
                q = C(AG.id)
            } else {
                if (h.webkit && h.webkit < 312) {
                    var AC = a("embed");
                    AC.setAttribute("type", P);
                    for (var z in AG) {
                        if (AG[z] != Object.prototype[z]) {
                            if (z.toLowerCase() == "data") {
                                AC.setAttribute("src", AG[z])
                            } else {
                                if (z.toLowerCase() == "styleclass") {
                                    AC.setAttribute("class", AG[z])
                                } else {
                                    if (z.toLowerCase() != "classid") {
                                        AC.setAttribute(z, AG[z])
                                    }
                                }
                            }
                        }
                    }
                    for (var y in AE) {
                        if (AE[y] != Object.prototype[y]) {
                            if (y.toLowerCase() != "movie") {
                                AC.setAttribute(y, AE[y])
                            }
                        }
                    }
                    v.parentNode.replaceChild(AC, v);
                    q = AC
                } else {
                    var u = a(Q);
                    u.setAttribute("type", P);
                    for (var x in AG) {
                        if (AG[x] != Object.prototype[x]) {
                            if (x.toLowerCase() == "styleclass") {
                                u.setAttribute("class", AG[x])
                            } else {
                                if (x.toLowerCase() != "classid") {
                                    u.setAttribute(x, AG[x])
                                }
                            }
                        }
                    }
                    for (var w in AE) {
                        if (AE[w] != Object.prototype[w] && w.toLowerCase() != "movie") {
                            F(u, w, AE[w])
                        }
                    }
                    v.parentNode.replaceChild(u, v);
                    q = u
                }
            }
        }
        return q
    }

    function F(t, q, r) {
        var u = a("param");
        u.setAttribute("name", q);
        u.setAttribute("value", r);
        t.appendChild(u)
    }

    function X(r) {
        var q = C(r);
        if (q && (q.nodeName == "OBJECT" || q.nodeName == "EMBED")) {
            if (h.ie && h.win) {
                if (q.readyState == 4) {
                    B(r)
                } else {
                    j.attachEvent("onload", function () {
                        B(r)
                    })
                }
            } else {
                q.parentNode.removeChild(q)
            }
        }
    }

    function B(t) {
        var r = C(t);
        if (r) {
            for (var q in r) {
                if (typeof r[q] == "function") {
                    r[q] = null
                }
            }
            r.parentNode.removeChild(r)
        }
    }

    function C(t) {
        var q = null;
        try {
            q = K.getElementById(t)
        } catch (r) {
        }
        return q
    }

    function a(q) {
        return K.createElement(q)
    }

    function I(t, q, r) {
        t.attachEvent(q, r);
        d[d.length] = [t, q, r]
    }

    function c(t) {
        var r = h.pv, q = t.split(".");
        q[0] = parseInt(q[0], 10);
        q[1] = parseInt(q[1], 10) || 0;
        q[2] = parseInt(q[2], 10) || 0;
        return (r[0] > q[0] || (r[0] == q[0] && r[1] > q[1]) || (r[0] == q[0] && r[1] == q[1] && r[2] >= q[2])) ? true : false
    }

    function V(v, r) {
        if (h.ie && h.mac) {
            return
        }
        var u = K.getElementsByTagName("head")[0], t = a("style");
        t.setAttribute("type", "text/css");
        t.setAttribute("media", "screen");
        if (!(h.ie && h.win) && typeof K.createTextNode != b) {
            t.appendChild(K.createTextNode(v + " {" + r + "}"))
        }
        u.appendChild(t);
        if (h.ie && h.win && typeof K.styleSheets != b && K.styleSheets.length > 0) {
            var q = K.styleSheets[K.styleSheets.length - 1];
            if (typeof q.addRule == Q) {
                q.addRule(v, r)
            }
        }
    }

    function W(t, q) {
        var r = q ? "visible" : "hidden";
        if (e && C(t)) {
            C(t).style.visibility = r
        } else {
            V("#" + t, "visibility:" + r)
        }
    }

    function g(s) {
        var r = /[\\\"<>\.;]/;
        var q = r.exec(s) != null;
        return q ? encodeURIComponent(s) : s
    }

    var D = function () {
        if (h.ie && h.win) {
            window.attachEvent("onunload", function () {
                var w = d.length;
                for (var v = 0; v < w; v++) {
                    d[v][0].detachEvent(d[v][1], d[v][2])
                }
                var t = i.length;
                for (var u = 0; u < t; u++) {
                    X(i[u])
                }
                for (var r in h) {
                    h[r] = null
                }
                h = null;
                for (var q in swfobject) {
                    swfobject[q] = null
                }
                swfobject = null
            })
        }
    }();
    return {
        registerObject: function (u, q, t) {
            if (!h.w3cdom || !u || !q) {
                return
            }
            var r = {};
            r.id = u;
            r.swfVersion = q;
            r.expressInstall = t ? t : false;
            N[N.length] = r;
            W(u, false)
        }, getObjectById: function (v) {
            var q = null;
            if (h.w3cdom) {
                var t = C(v);
                if (t) {
                    var u = t.getElementsByTagName(Q)[0];
                    if (!u || (u && typeof t.SetVariable != b)) {
                        q = t
                    } else {
                        if (typeof u.SetVariable != b) {
                            q = u
                        }
                    }
                }
            }
            return q
        }, embedSWF: function (x, AE, AB, AD, q, w, r, z, AC) {
            if (!h.w3cdom || !x || !AE || !AB || !AD || !q) {
                return
            }
            AB += "";
            AD += "";
            if (c(q)) {
                W(AE, false);
                var AA = {};
                if (AC && typeof AC === Q) {
                    for (var v in AC) {
                        if (AC[v] != Object.prototype[v]) {
                            AA[v] = AC[v]
                        }
                    }
                }
                AA.data = x;
                AA.width = AB;
                AA.height = AD;
                var y = {};
                if (z && typeof z === Q) {
                    for (var u in z) {
                        if (z[u] != Object.prototype[u]) {
                            y[u] = z[u]
                        }
                    }
                }
                if (r && typeof r === Q) {
                    for (var t in r) {
                        if (r[t] != Object.prototype[t]) {
                            if (typeof y.flashvars != b) {
                                y.flashvars += "&" + t + "=" + r[t]
                            } else {
                                y.flashvars = t + "=" + r[t]
                            }
                        }
                    }
                }
                f(function () {
                    U(AA, y, AE);
                    if (AA.id == AE) {
                        W(AE, true)
                    }
                })
            } else {
                if (w && !A && c("6.0.65") && (h.win || h.mac)) {
                    A = true;
                    W(AE, false);
                    f(function () {
                        var AF = {};
                        AF.id = AF.altContentId = AE;
                        AF.width = AB;
                        AF.height = AD;
                        AF.expressInstall = w;
                        k(AF)
                    })
                }
            }
        }, getFlashPlayerVersion: function () {
            return {major: h.pv[0], minor: h.pv[1], release: h.pv[2]}
        }, hasFlashPlayerVersion: c, createSWF: function (t, r, q) {
            if (h.w3cdom) {
                return U(t, r, q)
            } else {
                return undefined
            }
        }, removeSWF: function (q) {
            if (h.w3cdom) {
                X(q)
            }
        }, createCSS: function (r, q) {
            if (h.w3cdom) {
                V(r, q)
            }
        }, addDomLoadEvent: f, addLoadEvent: R, getQueryParamValue: function (v) {
            var u = K.location.search || K.location.hash;
            if (v == null) {
                return g(u)
            }
            if (u) {
                var t = u.substring(1).split("&");
                for (var r = 0; r < t.length; r++) {
                    if (t[r].substring(0, t[r].indexOf("=")) == v) {
                        return g(t[r].substring((t[r].indexOf("=") + 1)))
                    }
                }
            }
            return ""
        }, expressInstallCallback: function () {
            if (A && M) {
                var q = C(m);
                if (q) {
                    q.parentNode.replaceChild(M, q);
                    if (l) {
                        W(l, true);
                        if (h.ie && h.win) {
                            M.style.display = "block"
                        }
                    }
                    M = null;
                    l = null;
                    A = false
                }
            }
        }
    }
}();
/* Галлерея Pretty */
jQuery.fn.prettyGallery = function (settings) {
    settings = jQuery.extend({
        itemsPerPage: 2,
        animationSpeed: 'normal',
        navigation: 'top',
        of_label: ' of ',
        previous_title_label: 'Previous page',
        next_title_label: 'Next page',
        previous_label: 'Previous',
        next_label: 'Next'
    }, settings);
    return this.each(function () {
        var currentPage = 1;
        var itemWidth = 0;
        var itemHeight = 0;
        var galleryWidth = 0;
        var pageCount = 0;
        var animated = false;
        var $gallery = $(this);
        var prettyGalleryPrevious = function (caller) {
            if (animated || $(caller).hasClass('disabled')) return;
            animated = true;
            $gallery.find('li:lt(' + (currentPage * settings.itemsPerPage) + ')').each(function (i) {
                $(this).animate({'left': parseFloat($(this).css('left')) + (galleryWidth + itemMargin)}, settings.animationSpeed, function () {
                    animated = false;
                });
            });
            $gallery.find('li:gt(' + ((currentPage * settings.itemsPerPage) - 1) + ')').each(function (i) {
                $(this).animate({'left': parseFloat($(this).css('left')) + (galleryWidth + itemMargin)}, settings.animationSpeed);
            });
            currentPage--;
            _displayPaging();
        };
        var prettyGalleryNext = function (caller) {
            if (animated || $(caller).hasClass('disabled')) return;
            animated = true;
            $gallery.find('li:lt(' + (currentPage * settings.itemsPerPage) + ')').each(function (i) {
                $(this).animate({'left': parseFloat($(this).css('left')) - (galleryWidth + itemMargin)}, settings.animationSpeed, function () {
                    animated = false;
                });
            });
            $gallery.find('li:gt(' + ((currentPage * settings.itemsPerPage) - 1) + ')').each(function (i) {
                $(this).animate({'left': parseFloat($(this).css('left')) - (galleryWidth + itemMargin)}, settings.animationSpeed);
            });
            currentPage++;
            _displayPaging();
        };
        var _formatGallery = function () {
            itemWidth = $gallery.find('li:first').width();
            itemMargin = parseFloat($gallery.find('li:first').css('margin-right')) + parseFloat($gallery.find('li:first').css('margin-left')) + parseFloat($gallery.find('li:first').css('padding-left')) + parseFloat($gallery.find('li:first').css('padding-right')) + parseFloat($gallery.find('li:first').css('border-left-width')) + parseFloat($gallery.find('li:first').css('border-right-width'));
            itemHeight = $gallery.find('li:first').height() + parseFloat($gallery.find('li:first').css('margin-top')) + parseFloat($gallery.find('li:first').css('margin-bottom')) + parseFloat($gallery.find('li:first').css('padding-top')) + parseFloat($gallery.find('li:first').css('padding-bottom'));
            galleryWidth = (itemWidth + itemMargin) * settings.itemsPerPage - parseFloat($gallery.find('li:first').css('margin-right'));
            $gallery.css({
                'width': galleryWidth,
                'height': itemHeight,
                'overflow': 'hidden',
                'position': 'relative',
                'clear': 'left'
            });
            $gallery.find('li').each(function (i) {
                $(this).css({'position': 'absolute', 'top': 0, 'left': i * (itemWidth + itemMargin)});
            });
            $gallery.wrap('<div class="prettyGallery"></div>').addClass('prettyGallery');
        };
        var _displayPaging = function () {
            $cg = $gallery.parents('div.prettyGallery:first');
            $cg.find('ul.prettyNavigation span.current').text(currentPage);
            $cg.find('ul.prettyNavigation span.total').text(pageCount);
            $cg.find('ul.prettyNavigation li a').removeClass('disabled');
            if (currentPage == 1) {
                $cg.find('ul.prettyNavigation li.prev a').addClass('disabled');
            } else if (currentPage == pageCount) {
                $cg.find('ul.prettyNavigation li.next a').addClass('disabled');
            }
            ;
        };
        var _applyNav = function () {
            var template = '';
            template += '<ul class="prettyNavigation">';
            template += '<li class="prev"><a href="#" title="' + settings.previous_title_label + '">' + settings.previous_label + '</a></li>';
            template += '<li><span class="current">1</span>' + settings.of_label + '<span class="total">1</span></li>';
            template += '<li class="next"><a href="#" title="' + settings.next_title_label + '">' + settings.next_label + '</a></li>';
            template += '</ul>';
            switch (settings.navigation) {
                case 'top':
                    $gallery.before(template);
                    break;
                case 'bottom':
                    $gallery.after(template);
                    break;
                case 'both':
                    $gallery.before(template);
                    $gallery.after(template);
                    break;
            }
            ;$theNav = $gallery.parent('div.prettyGallery:first').find('ul.prettyNavigation');
            galleryBorderWidth = parseFloat($theNav.css('border-left-width')) + parseFloat($theNav.css('border-right-width'));
            $theNav.width(galleryWidth - galleryBorderWidth);
            $theNav.each(function () {
                $(this).find('li:eq(1)').width(galleryWidth - galleryBorderWidth - parseFloat($(this).parent().find('ul.prettyNavigation li:first').width()) - parseFloat($(this).parent().find('ul.prettyNavigation li:last').width()));
            });
            $theNav.find('li.prev a').bind('click', function () {
                prettyGalleryPrevious(this);
                return false;
            });
            $theNav.find('li.next a').bind('click', function () {
                prettyGalleryNext(this);
                return false;
            });
        };
        if ($(this).find('li').size() > settings.itemsPerPage) {
            pageCount = Math.ceil($(this).find('li').size() / settings.itemsPerPage);
            _formatGallery();
            _applyNav();
            _displayPaging(this);
            currentPage = 1;
        }
        ;
    });
};
$.fn.prettyPhoto = function (settings) {
    var isSet = false;
    var setCount = 0;
    var setPosition = 0;
    var arrayPosition = 0;
    var hasTitle = false;
    var caller = 0;
    var doresize = true;
    var imagesArray = [];
    $(window).scroll(function () {
        _centerPicture();
    });
    $(window).resize(function () {
        _centerPicture();
        _resizeOverlay();
    });
    $(document).keyup(function (e) {
        switch (e.keyCode) {
            case 37:
                if (setPosition == 1) return;
                changePicture('previous');
                break;
            case 39:
                if (setPosition == setCount) return;
                changePicture('next');
                break;
            case 27:
                close();
                break;
        }
        ;
    });
    settings = jQuery.extend({
        animationSpeed: 'normal',
        padding: 40,
        opacity: 0.35,
        showTitle: true,
        allowresize: true
    }, settings);
    $(this).each(function () {
        imagesArray[imagesArray.length] = this;
        $(this).bind('click', function () {
            open(this);
            return false;
        });
    });

    function open(el) {
        caller = $(el);
        theRel = $(caller).attr('rel');
        galleryRegExp = /\[(?:.*)\]/;
        theGallery = galleryRegExp.exec(theRel);
        contentType = "image";
        if ($(caller).attr('href').indexOf('.swf') > 0) {
            hasTitle = false;
            contentType = 'flash';
        }
        ;isSet = false;
        setCount = 0;
        for (i = 0; i < imagesArray.length; i++) {
            if ($(imagesArray[i]).attr('rel').indexOf(theGallery) != -1) {
                setCount++;
                if (setCount > 1) isSet = true;
                if ($(imagesArray[i]).attr('href') == $(el).attr('href')) {
                    setPosition = setCount;
                    arrayPosition = i;
                }
                ;
            }
            ;
        }
        ;_buildOverlay(isSet);
        $('div.pictureHolder span.currentText').html('<span>' + setPosition + '</span>' + '/' + setCount);
        _centerPicture();
        $('div.pictureHolder #fullResImageContainer').hide();
        $('.loaderIcon').show();
        (contentType == 'image') ? _preload() : _writeFlash();
    };showimage = function (width, height, containerWidth, containerHeight, contentHeight, contentWidth, resized) {
        $('.loaderIcon').hide();
        var scrollPos = _getScroll();
        if ($.browser.opera) {
            windowHeight = window.innerHeight;
            windowWidth = window.innerWidth;
        } else {
            windowHeight = $(window).height();
            windowWidth = $(window).width();
        }
        ;$('div.pictureHolder .content').animate({
            'height': contentHeight,
            'width': containerWidth
        }, settings.animationSpeed);
        projectedTop = scrollPos['scrollTop'] + ((windowHeight / 2) - (containerHeight / 2));
        if (projectedTop < 0) projectedTop = 0 + $('div.prettyPhotoTitle').height();
        $('div.pictureHolder').animate({
            'top': projectedTop,
            'left': ((windowWidth / 2) - (containerWidth / 2)),
            'width': containerWidth
        }, settings.animationSpeed, function () {
            $('#fullResImage').attr({'width': width, 'height': height});
            $('div.pictureHolder').width(containerWidth);
            $('div.pictureHolder .hoverContainer').height(height).width(width);
            _shownav();
            $('div.pictureHolder #fullResImageContainer').fadeIn(settings.animationSpeed);
            if (resized) $('a.expand,a.contract').fadeIn(settings.animationSpeed);
        });
    };

    function changePicture(direction) {
        if (direction == 'previous') {
            arrayPosition--;
            setPosition--;
        } else {
            arrayPosition++;
            setPosition++;
        }
        ;
        if (!doresize) doresize = true;
        $('div.pictureHolder .hoverContainer,div.pictureHolder .details').fadeOut(settings.animationSpeed);
        $('div.pictureHolder #fullResImageContainer').fadeOut(settings.animationSpeed, function () {
            $('.loaderIcon').show();
            _preload();
        });
        _hideTitle();
        $('a.expand,a.contract').fadeOut(settings.animationSpeed, function () {
            $(this).removeClass('contract').addClass('expand');
        });
    };

    function close() {
        $('div.pictureHolder,div.prettyPhotoTitle').fadeOut(settings.animationSpeed, function () {
            $('div.prettyPhotoOverlay').fadeOut(settings.animationSpeed, function () {
                $('div.prettyPhotoOverlay,div.pictureHolder,div.prettyPhotoTitle').remove();
                if ($.browser.msie && $.browser.version == 6) {
                    $('select').css('visibility', 'visible');
                }
                ;
            });
        });
    };

    function _checkPosition() {
        (setPosition == setCount) ? $('div.pictureHolder a.next').css('visibility', 'hidden') : $('div.pictureHolder a.next').css('visibility', 'visible');
        (setPosition == 1) ? $('div.pictureHolder a.previous').css('visibility', 'hidden') : $('div.pictureHolder a.previous').css('visibility', 'visible');
        $('div.pictureHolder span.currentText span').text(setPosition);
        (isSet) ? $c = $(imagesArray[arrayPosition]) : $c = $(caller);
        if ($c.attr('title')) {
            $('div.pictureHolder .description').html(unescape($c.attr('title')));
        } else {
            $('div.pictureHolder .description').text('');
        }
        ;
        if ($c.find('img').attr('alt') && settings.showTitle) {
            hasTitle = true;
            $('div.prettyPhotoTitle .prettyPhotoTitleContent').html(unescape($c.find('img').attr('alt')));
        } else {
            hasTitle = false;
        }
        ;
    };

    function _fitToViewport(width, height) {
        hasBeenResized = false;
        $('div.pictureHolder .details').width(width);
        $('div.pictureHolder .details p.description').width(width - parseFloat($('div.pictureHolder a.close').css('width')));
        contentHeight = height + parseFloat($('div.pictureHolder .details').height()) + parseFloat($('div.pictureHolder .details').css('margin-top')) + parseFloat($('div.pictureHolder .details').css('margin-bottom'));
        contentWidth = width;
        containerHeight = height + parseFloat($('div.prettyPhotoTitle').height()) + parseFloat($('div.pictureHolder .top').height()) + parseFloat($('div.pictureHolder .bottom').height());
        containerWidth = width + settings.padding;
        imageWidth = width;
        imageHeight = height;
        if ($.browser.opera) {
            windowHeight = window.innerHeight;
            windowWidth = window.innerWidth;
        } else {
            windowHeight = $(window).height();
            windowWidth = $(window).width();
        }
        ;
        if (((containerWidth > windowWidth) || (containerHeight > windowHeight)) && doresize && settings.allowresize) {
            hasBeenResized = true;
            if ((containerWidth > windowWidth) && (containerHeight > windowHeight)) {
                var xscale = (containerWidth + 200) / windowWidth;
                var yscale = (containerHeight + 200) / windowHeight;
            } else {
                var xscale = windowWidth / containerWidth;
                var yscale = windowHeight / containerHeight;
            }
            if (yscale > xscale) {
                imageWidth = Math.round(width * (1 / yscale));
                imageHeight = Math.round(height * (1 / yscale));
            } else {
                imageWidth = Math.round(width * (1 / xscale));
                imageHeight = Math.round(height * (1 / xscale));
            }
            ;contentHeight = imageHeight + parseFloat($('div.pictureHolder .details').height()) + parseFloat($('div.pictureHolder .details').css('margin-top')) + parseFloat($('div.pictureHolder .details').css('margin-bottom'));
            contentWidth = imageWidth;
            containerHeight = imageHeight + parseFloat($('div.prettyPhotoTitle').height()) + parseFloat($('div.pictureHolder .top').height()) + parseFloat($('div.pictureHolder .bottom').height());
            containerWidth = imageWidth + settings.padding;
            $('div.pictureHolder .details').width(contentWidth);
            $('div.pictureHolder .details p.description').width(contentWidth - parseFloat($('div.pictureHolder a.close').css('width')));
        }
        ;
        return {
            width: imageWidth,
            height: imageHeight,
            containerHeight: containerHeight,
            containerWidth: containerWidth,
            contentHeight: contentHeight,
            contentWidth: contentWidth,
            resized: hasBeenResized
        };
    };

    function _centerPicture() {
        if ($('div.pictureHolder').size() > 0) {
            var scrollPos = _getScroll();
            if ($.browser.opera) {
                windowHeight = window.innerHeight;
                windowWidth = window.innerWidth;
            } else {
                windowHeight = $(window).height();
                windowWidth = $(window).width();
            }
            ;
            if (doresize) {
                projectedTop = (windowHeight / 2) + scrollPos['scrollTop'] - ($('div.pictureHolder').height() / 2);
                if (projectedTop < 0) projectedTop = 0 + $('div.prettyPhotoTitle').height();
                $('div.pictureHolder').css({
                    'top': projectedTop,
                    'left': (windowWidth / 2) + scrollPos['scrollLeft'] - ($('div.pictureHolder').width() / 2)
                });
                $('div.prettyPhotoTitle').css({
                    'top': $('div.pictureHolder').offset().top - $('div.prettyPhotoTitle').height(),
                    'left': $('div.pictureHolder').offset().left + (settings.padding / 2)
                });
            }
            ;
        }
        ;
    };

    function _shownav() {
        if (isSet) $('div.pictureHolder .hoverContainer').fadeIn(settings.animationSpeed);
        $('div.pictureHolder .details').fadeIn(settings.animationSpeed);
        _showTitle();
    };

    function _showTitle() {
        if (settings.showTitle && hasTitle) {
            $('div.prettyPhotoTitle').css({
                'top': $('div.pictureHolder').offset().top,
                'left': $('div.pictureHolder').offset().left + (settings.padding / 2),
                'display': 'block'
            });
            $('div.prettyPhotoTitle div.prettyPhotoTitleContent').css('width', 'auto');
            if ($('div.prettyPhotoTitle').width() > $('div.pictureHolder').width()) {
                $('div.prettyPhotoTitle div.prettyPhotoTitleContent').css('width', $('div.pictureHolder').width() - (settings.padding * 2));
            } else {
                $('div.prettyPhotoTitle div.prettyPhotoTitleContent').css('width', '');
            }
            ;$('div.prettyPhotoTitle').animate({'top': ($('div.pictureHolder').offset().top - 22)}, settings.animationSpeed);
        }
        ;
    };

    function _hideTitle() {
        $('div.prettyPhotoTitle').animate({'top': ($('div.pictureHolder').offset().top)}, settings.animationSpeed, function () {
            $(this).css('display', 'none');
        });
    };

    function _preload() {
        _checkPosition();
        imgPreloader = new Image();
        nextImage = new Image();
        if (isSet) nextImage.src = $(imagesArray[arrayPosition + 1]).attr('href');
        prevImage = new Image();
        if (isSet && imagesArray[arrayPosition - 1]) prevImage.src = $(imagesArray[arrayPosition - 1]).attr('href');
        $('div.pictureHolder .content').css('overflow', 'hidden');
        if (isSet) {
            $('div.pictureHolder #fullResImage').attr('src', $(imagesArray[arrayPosition]).attr('href'));
        } else {
            $('div.pictureHolder #fullResImage').attr('src', $(caller).attr('href'));
        }
        ;imgPreloader.onload = function () {
            var correctSizes = _fitToViewport(imgPreloader.width, imgPreloader.height);
            imgPreloader.width = correctSizes['width'];
            imgPreloader.height = correctSizes['height'];
            setTimeout('showimage(imgPreloader.width,imgPreloader.height,' + correctSizes["containerWidth"] + ',' + correctSizes["containerHeight"] + ',' + correctSizes["contentHeight"] + ',' + correctSizes["contentWidth"] + ',' + correctSizes["resized"] + ')', 500);
        };
        (isSet) ? imgPreloader.src = $(imagesArray[arrayPosition]).attr('href') : imgPreloader.src = $(caller).attr('href');
    };

    function _getScroll() {
        scrollTop = window.pageYOffset || document.documentElement.scrollTop || 0;
        scrollLeft = window.pageXOffset || document.documentElement.scrollLeft || 0;
        return {scrollTop: scrollTop, scrollLeft: scrollLeft};
    };

    function _resizeOverlay() {
        $('div.prettyPhotoOverlay').css({'height': $(document).height(), 'width': $(window).width()});
    };

    function _writeFlash() {
        flashParams = $(caller).attr('rel').split(';');
        $(flashParams).each(function (i) {
            if (flashParams[i].indexOf('width') >= 0) flashWidth = flashParams[i].substring(flashParams[i].indexOf('width') + 6, flashParams[i].length);
            if (flashParams[i].indexOf('height') >= 0) flashHeight = flashParams[i].substring(flashParams[i].indexOf('height') + 7, flashParams[i].length);
            if (flashParams[i].indexOf('flashvars') >= 0) flashVars = flashParams[i].substring(flashParams[i].indexOf('flashvars') + 10, flashParams[i].length);
        });
        $('.pictureHolder #fullResImageContainer').append('<embed width="' + flashWidth + '" height="' + flashHeight + '" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" wmode="opaque" name="prettyFlash" flashvars="' + flashVars + '" allowscriptaccess="always" bgcolor="#FFFFFF" quality="high" src="' + $(caller).attr('href') + '"/>');
        $('#fullResImage').hide();
        contentHeight = parseFloat(flashHeight) + parseFloat($('div.pictureHolder .details').height()) + parseFloat($('div.pictureHolder .details').css('margin-top')) + parseFloat($('div.pictureHolder .details').css('margin-bottom'));
        contentWidth = parseFloat(flashWidth) + parseFloat($('div.pictureHolder .details').width()) + parseFloat($('div.pictureHolder .details').css('margin-left')) + parseFloat($('div.pictureHolder .details').css('margin-right'));
        containerHeight = contentHeight + parseFloat($('div.pictureHolder .top').height()) + parseFloat($('div.pictureHolder .bottom').height());
        containerWidth = parseFloat(flashWidth) + parseFloat($('div.pictureHolder .content').css("padding-left")) + parseFloat($('div.pictureHolder .content').css("padding-right")) + settings.padding;
        setTimeout('showimage(' + flashWidth + ',' + flashHeight + ',' + containerWidth + ',' + containerHeight + ',' + contentHeight + ',' + contentWidth + ')', 500);
    };

    function _buildOverlay() {
        backgroundDiv = "<div class='prettyPhotoOverlay'></div>";
        $('body').append(backgroundDiv);
        $('div.prettyPhotoOverlay').css('height', $(document).height()).bind('click', function () {
            close();
        });
        pictureHolder = '<div class="pictureHolder"><div class="top"><div class="left"></div><div class="middle"></div><div class="right"></div></div><div class="content"><a href="#" class="expand" title="Expand the image">Expand</a><div class="loaderIcon"></div><div class="hoverContainer"><a class="next" href="#">next</a><a class="previous" href="#">previous</a></div><div id="fullResImageContainer"><img id="fullResImage" src="" /></div><div class="details clearfix"><a class="close" href="#">Close</a><p class="description"></p><p class="currentTextHolder"><span class="currentText"><span>0</span>/<span class="total">0</span></span></p></div></div><div class="bottom"><div class="left"></div><div class="middle"></div><div class="right"></div></div></div>';
        titleHolder = '<div class="prettyPhotoTitle"><div class="prettyPhotoTitleLeft"></div><div class="prettyPhotoTitleContent"></div><div class="prettyPhotoTitleRight"></div></div>';
        $('body').append(pictureHolder).append(titleHolder);
        $('.pictureHolder,.titleHolder').css({'opacity': 0});
        $('a.close').bind('click', function () {
            close();
            return false;
        });
        $('a.expand').bind('click', function () {
            if ($(this).hasClass('expand')) {
                $(this).removeClass('expand').addClass('contract');
                doresize = false;
            } else {
                $(this).removeClass('contract').addClass('expand');
                doresize = true;
            }
            ;_hideTitle();
            $('div.pictureHolder .hoverContainer,div.pictureHolder #fullResImageContainer').fadeOut(settings.animationSpeed);
            $('div.pictureHolder .details').fadeOut(settings.animationSpeed, function () {
                _preload();
            });
            return false;
        });
        $('.pictureHolder .previous').bind('click', function () {
            changePicture('previous');
            return false;
        });
        $('.pictureHolder .next').bind('click', function () {
            changePicture('next');
            return false;
        });
        $('.hoverContainer').css({'margin-left': settings.padding / 2});
        if (!isSet) {
            $('.hoverContainer,.currentTextHolder').hide();
        }
        ;
        if ($.browser.msie && $.browser.version == 6) {
            $('select').css('visibility', 'hidden');
        }
        ;$('div.prettyPhotoOverlay').css('opacity', 0).fadeTo(settings.animationSpeed, settings.opacity, function () {
            $('div.pictureHolder').css('opacity', 0).fadeIn(settings.animationSpeed, function () {
                $('div.pictureHolder').attr('style', 'left:' + $('div.pictureHolder').css('left') + ';top:' + $('div.pictureHolder').css('top') + ';');
            });
        });
    };
};

/* Баннерная система: запрос баннеров */
function BannersSystem() {
    var domain = $("#DomainId").val();
    var userid = $("#UserId").val();
    if (in_array(userid, admins)) {
        return false;
    }
    JsHttpRequest.query("/advert/getBanner.php", {'domain': domain}, function (result, errors) {
        if (result) { /*s*/
            if (result["Code"] == 1) {
                BannersParse(result["Banners"]);
            }
            /*e*/
        }
    }, true);
}

/* Баннерная система: разбор запроса */
function BannersParse(banners) {
    jQuery.each(banners, function (pid, items) {
        jQuery.each(items, function (num, item) {
            BannersShow(pid, num, item);
        });
    });
    if ($(".richBanner").html() != undefined && $(".richBanner").html() != "") {
        $("#AllContent").css("padding-top", "40px");
        $(".richBanner").live("mouseover", function () {
            $(this).stop(true, true).animate({height: "150px"}, 300);
        });
        $(".richBanner").live("mouseout", function () {
            $(this).animate({height: "40px"}, 300);
        });
        $(".richBanner").animate({height: "40px"}, 10);
    }
    $("body").append("<img src='/advert/showBanner.php?ids=" + bands + "' style='width:0px; height:0px;' />");
    $(".ToUp").hide();
}

/* Баннерная система: платформа */
function BannersFlash() {
    var flashInstalled = false;
    if (typeof(navigator.plugins) != "undefined" && typeof(navigator.plugins["Shockwave Flash"]) == "object") {
        flashInstalled = true;
    } else if (typeof  window.ActiveXObject != "undefined") {
        try {
            if (new ActiveXObject("ShockwaveFlash.ShockwaveFlash")) {
                flashInstalled = true;
            }
        } catch (e) {
        }
        ;
    }
    ;
    return flashInstalled;
}

function BannersRandom( link ) {
    var rand = Math.random().toString(36).substr(2).toUpperCase();
    link = link.replace('[RANDOM]', rand).replace('%5BRANDOM%5D', rand);
    return link;
}

/* Баннерная система: вывод баннера */
function BannersShow(pid, num, item) {
    var b = item.split(";");
    b[7] = BannersRandom(b[7]);
    b[8] = BannersRandom(b[8]);
    b[9] = BannersRandom(b[9]);
    b[12] = BannersRandom(b[12]);
    num = num - (-1);
    if (($("#Banner-" + pid + "-" + num).size() != 0 && b[0] != 0) || pid == 4 || pid == 24 || pid == 32) {
        if (flashInstalled == true && b[4] != "") {
            view = 1;
        }
        if (!flashInstalled || b[4] == "") {
            view = 2;
        }
        if (view == 2 && b[5] == "") {
            view = 3;
        }
        if (view == 3 && b[13] == "") {
            view = 0;
        }
        if (pid == 4) {
            view = 4;
        }
        if (pid == 24) {
            view = 5;
        }
        if (pid == 32){
          view = 32;
        }
        obj = $("#Banner-" + pid + "-" + num);
        if
        (
          ((pid == 4 || pid == 24) && document.location.host == "progorodsamara.ru")
          ||
          (pid == 32 && document.location.host == "progorodnsk.ru")
        ) {
        console.log('Hmmm');
      }
      bands = bands + b[0] + ".";
        var link = "/advert/clickBanner.php?id=" + b[0] + "&away=" + b[7];
        var link1 = "/advert/clickBanner.php?id=" + b[0] + "%26away=" + b[7];
        var link2 = "/advert/clickBanner.php?id=" + b[0] + "%26away=" + b[8];
        var link3 = "/advert/clickBanner.php?id=" + b[0] + "%26away=" + b[9];
        var vars = "link1=" + link1 + "&link2=" + link2 + "&link3=" + link3;
        if (view == 1) {
            var flash = '<object type="application/x-shockwave-flash" data="http://progorodsamara.ru/advert/files/flash/' + b[4] + '" width="' + b[10] + '" height="' + b[11] + '"><param name="movie" value="http://progorodsamara.ru/advert/files/flash/' + b[4] + '" /><param name="quality" value="high" /><param name="wmode" value="opaque" /><param name="flashvars" value="' + vars + '"><embed type="application/x-shockwave-flash"  width="' + b[10] + '" height="' + b[11] + '" quality="high" wmode="opaque" src="http://progorodsamara.ru/advert/files/flash/' + b[4] + '" flashvars="' + vars + '"></embed></object>';
            obj.append(flash);
        }
        if (view == 2) {
            obj.append("<a href='" + link + "' target='_blank'><img src='/advert/files/image/" + b[5] + "' width='" + b[10] + "' height='" + b[11] + "' /></a>");
        }
        if (view == 3) {
            obj.append(b[13]);
        }
        if ((view == 4 && podlogused == 0) || view == 32) {
            podlogused = 1;
            if (
              (view == 4 && document.location.host == "progorodsamara.ru") ||
              (view == 32 && document.location.host == "progorodnsk.ru")
            ){
              console.log(b);
              BannersPodlogka(b);
            }
        }
        if (view == 5) {
            BannersProPodlogka(b);
        }
        if (view != 0 && view != 4 && view != 5) {
            obj.css("width", b[10]);
            if (view != 13) {
                obj.css("height", b[11]);
            } else {
                obj.css("height", "40");
            }
            obj.show();
            obj.append('<div class="closeban">Закрыть [x]</div>');
            $(".closeban").live("click", function () {
                $(this).parent().fadeOut();
            });
            if (b[12] != "") {
                obj.append("<div class='counter'><img src='" + b[12] + "' /></div>");
            }
        }
    }
}

/* Баннерная система: подложка */
function BannersPodlogka(b) {
    if ($("#InnerCont").size() > 0) {
        var w = ($("#InnerCont").width() - 990) / 2;
        $("#LeftCont").css("width", w);
        $("#LeftCont").show();
        if (b[7] != "") {
            $("#LeftCont").live("click", function () {
                window.open("/advert/clickBanner.php?id=" + b[0] + "&away=" + b[7], '_blank');
            });
        }
        $("#RightCont").css("width", w);
        $("#RightCont").show();
        if (b[8] != "") {
            $("#RightCont").live("click", function () {
                window.open("/advert/clickBanner.php?id=" + b[0] + "&away=" + b[8], '_blank');
            });
        }
        $("#InnerCont").css("background", "url(/advert/files/image/" + b[5] + ") center top no-repeat fixed");
        if (b[12] != "") {
            $("#InnerCont").append("<div class='counter'><img src='" + b[12] + "' /></div>");
        }
    }
}

/* Баннерная система: подподложка */
function BannersProPodlogka(b) {
    if ($("#ProPodlogka").size() > 0) {
        var w = ($("#InnerCont").width() - 990) / 2;
        $("#ProPodlogka").css("width", w);
        $("#ProPodlogka").show();
        if (b[7] != "") {
            $("#ProPodlogka").live("click", function () {
                window.open("/advert/clickBanner.php?id=" + b[0] + "&away=" + b[7], '_blank');
            });
            $("#ProPodlogka").css("background", "url(/advert/files/image/" + b[5] + ") top left no-repeat");
            if (b[12] != "") {
                $("#ProPodlogka").append("<div class='counter'><img src='" + b[12] + "' /></div>");
            }
        }
    }
}

/* Вставка смайла в комментарий */
function addSmile(o) {
    $('textarea', o.parents('.UserComTextDiv')).insertAtCaret(o.text());
    o.parents('.SmilesGroup').hide();
}

/* Сообщение о спаме */
function ThisIsSpam(id) {
    $("img, a", $("#CommentItem-" + id + " .ThisIsSpam")).toggle();
    JsHttpRequest.query('/modules/standart/UsersComment-JSReq.php', {
        'id': id,
        'action': 'spam',
        'link': document.location.href
    }, function (result, errors) {
        $("#CommentItem-" + id + " .ThisIsSpam").html(' | Сообщение о спаме отправлено');
    }, true);
}

function in_array(what, where) {
    for (var i = 0; i < where.length; i++) {
        if (what == where[i]) {
            return true;
        }
    }
    return false;
}

jQuery.fn.extend({
    insertAtCaret: function (myValue) {
        return this.each(function (i) {
            if (document.selection) {
                this.focus();
                var sel = document.selection.createRange();
                sel.text = myValue;
                this.focus();
            } else if (this.selectionStart || this.selectionStart == '0') {
                var startPos = this.selectionStart;
                var endPos = this.selectionEnd;
                var scrollTop = this.scrollTop;
                this.value = this.value.substring(0, startPos) + myValue + this.value.substring(endPos, this.value.length);
                this.focus();
                this.selectionStart = startPos + myValue.length;
                this.selectionEnd = startPos + myValue.length;
                this.scrollTop = scrollTop;
            } else {
                this.value += myValue;
                this.focus();
            }
        })
    }
});
