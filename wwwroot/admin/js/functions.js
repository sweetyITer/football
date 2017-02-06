//提示消息框
function tip(options) {
    var conf = {
        html: "<div class=\"mingming-tips\" id=\"__ID__\"><div class=\"box\"><div class=\"shade\"><\/div><p>__TEXT__<\/p><\/div><\/div>",
        text: '提示',
        url: '',
        reload: false,
        time: 3000,
        id: new Date().valueOf()
    };
    if (typeof options == "string") {
        conf.text = options;
    } else {
        conf = $.extend(conf, options);
    }

    $('body').append(conf.html.replace('__TEXT__', conf.text).replace('__ID__', conf.id));
    $('#' + conf.id).fadeIn(500);
    if (conf.url) {
        $.URL.url(conf.url);
        conf.reload = true;
    }
    setTimeout(function () {
        if (conf.reload) {
            $.URL.reload();
        } else {
            $('#' + conf.id).fadeOut(1000, null, function () {
                $(this).remove();
            });
        }
    }, conf.time);
}
function error(msg, code) {
    var conf = {
        html: '<div class="bootstrap-tips" id="__ID__"><div class="alert alert-danger alert-dismissible fade in" role="alert">' +
        '        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button><h4>__CODE__</h4>' +
        '    <p>__TEXT__</p></div></div>',
        text: msg,
        code: 'ERROR',
        url: '',
        reload: false,
        time: 3000,
        id: new Date().valueOf()
    };
    code && (conf.code = code);

    $('body').append(conf.html.replace('__TEXT__', conf.text)
        .replace('__ID__', conf.id)
        .replace('__CODE__', conf.code)
    );
    $('#' + conf.id).fadeIn(500);
    if (conf.url) {
        $.URL.url(conf.url);
        conf.reload = true;
    }
    setTimeout(function () {
        if (conf.reload) {
            $.URL.reload();
        } else {
            $('#' + conf.id).fadeOut(1000, null, function () {
                $(this).remove();
            });
        }
    }, conf.time);
}
/**
 * 清空所有cookie
 */
function clearAllCookie() {
    //清除目前的所有cookie
    var keys = document.cookie.match(/[^ =;]+(?=\=)/g);
    if (keys) {
        for (var i = keys.length; i--;)
            document.cookie = keys[i] + '=0;expires=' + new Date(0).toUTCString()
    }
}

var CONF = {
    tpl: function (tpl) {
        return '//' + window.location.host + "/template/" + tpl + '.tpl.html?v=' + VERSION;
    },
    url: function (query) {
        return '//' + window.location.host + "/" + query + '.json';
    }
};
//处理接口返回数据
function dealJson(json, successCallback, errorCallback) {
    if (json.code && json.code == 'SUCCESS') {

        successCallback(json);
    } else {
        if (typeof errorCallback == 'function') {
            errorCallback(json);
        } else {
            error(json.msg, json.code);
        }
    }
}
/**
 * 初始化
 * @param $model
 * @param id
 * @param value
 */
function selectInit($model, id, value) {
    $('select[ng-model="' + $model + '"]').html('<option id="' + id + '">' + value + '</option>');
}