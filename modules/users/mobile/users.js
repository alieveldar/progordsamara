/* ОБЩИЕ НАСТРОЙКИ */
var speed = 300;
var error = 0;

function EraseSocial(id) {
    JsHttpRequest.query('/modules/users/EraseSocial-JSReq.php', {'id': id}, function (result, errors) {
        if (result) {
            $('#UserFrom-' + id).hide("slow");
        }
    }, false);
}

function StartUploadAvatar() {
    var upl = document.getElementById("uavatar");
    if (upl != "") {
        document.getElementById('Podstava').className = 'Podstava2';
        JsHttpRequest.query('/modules/users/users-avatar-JSReq.php', {'userpic': upl}, function (result, errors) {
            if (result) {
                if (result["Answer"] == "ok") {
                    document.getElementById('Podstava').className = 'Podstava1';
                    document.getElementById('AvatarI').innerHTML = "<img src='/userfiles/avatar/" + result["Pic"] + "' />";
                } else {
                    document.getElementById('AvatarT').innerHTML = "<b>Oops... Либо вы пытались загрузить не фотографию, либо она была слишком большой, либо наш сервер объелся электричества и не хочет работать...</b><pre>" + result["Answer"] + "</pre>";
                }
            }
        }, false);
    }
}

function SaveSettings() {
    var error = 0;
    var name = $('#uname').val();
    var email = $('#umail').val();
    var forum = $('#uforum').val();
    var pass = $('#upass').val();
    var elem = document.getElementById('sendstat');
    elem.style.display = 'block';
    if (email != '') {
        if ((/^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,4}$/i).test(email) != true) {
            error = 1;
            elem.innerHTML = 'Ошибка: введите ваш E-mail корректно';
        }
    }
    if (name == '') {
        error = 1;
        elem.innerHTML = 'Ошибка: введите ваше имя!';
    }
    if (error == 1) {
        elem.className = 'ErrorDiv';
    } else {
        elem.className = 'SaveDiv';
        elem.innerHTML = 'Секунду, сохраняем настройки...';
        JsHttpRequest.query('/modules/users/users-settings-JSReq.php', {
            'name': name,
            'email': email,
            'forum': forum,
            'pass': pass
        }, function (result, errors) {
            if (result) {
                if (result["Answer"] == "ok") {
                    elem.innerHTML = 'Настройки успешно сохранены.';
                    elem.className = 'SuccessDiv';
                } else {
                    elem.innerHTML = 'Внимание! Возникла ошибка...';
                    elem.className = 'ErrorDiv';
                }
            }
        }, false);
    }
}

function EscapeRefresh(lin, id) {
    $('#I-' + lin + '-' + id).html("<img src='/template/standart/loader.gif'>");
    JsHttpRequest.query('/modules/users/users-delrefresh-JSReq.php', {'id': id, 'lin': lin}, function (result, errors) {
        if (result) {
            $('#R-' + lin + '-' + id).fadeOut();
        }
    }, false);
}