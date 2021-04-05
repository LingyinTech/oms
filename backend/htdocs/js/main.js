namespace = function () {
    var argus = arguments;
    for (var i = 0; i < argus.length; i++) {
        var objs = argus[i].split(".");
        var obj = window;
        for (var j = 0; j < objs.length; j++) {
            obj[objs[j]] = obj[objs[j]] || {};
            obj = obj[objs[j]];
        }
    }
    return obj;
}

namespace('main.cookie')
;(function () {
    // 写cookie
    function setCookie(name, value, day) {
        var exp = new Date();
        exp.setTime(exp.getTime() + day * 24 * 60 * 60 * 1000);
        document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();
    }

    //读取cookies
    function getCookie(name) {
        var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");

        if (arr = document.cookie.match(reg)) {
            return unescape(arr[2]);
        }

        return null;
    }

    //删除cookies
    function delCookie(name) {
        var exp = new Date();
        exp.setTime(exp.getTime() - 1);
        var cval = getCookie(name);
        if (cval != null)
            document.cookie = name + "=" + cval + ";expires=" + exp.toGMTString();
    }

    window.main.cookie.set = setCookie;
    window.main.cookie.get = getCookie;
    window.main.cookie.delete = delCookie;
})();

namespace('main.form')
;(function () {
    function resetForm(formId) {
        if (formId) {
            $('#' + formId)[0].reset();
        }

        $("input[type='hidden']").each(function () {
            if ('_csrf' !== $(this).attr('name')) {
                $(this).val('');
            }
        })
    }

    window.main.form.reset = resetForm;
})();

;(function () {

    $('table.data-grid-check tbody tr').on('click', function () {
        let formName = $('table.data-grid').data('form');
        $(this).children('td').each(function (i, v) {
            let name = $(this).data('name');
            let value = $(this).data('value');
            $('#' + formName + '-' + name).val(value);
        })
    });

    $('.sidebar-toggle').on('click', function () {
        if ($('body').hasClass('sidebar-collapse')) {
            window.main.cookie.delete('sidebar-toggle-control');
        } else {
            window.main.cookie.set('sidebar-toggle-control', 1, 7);
        }
    });

    $('form button.action-reset').on('click', window.main.form.reset);

})();