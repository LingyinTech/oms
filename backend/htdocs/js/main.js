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

    window.admin = window.admin || {};
    window.admin.main = window.main || {};
    window.admin.main.cookie = window.admin.main.cookie || {};
    window.admin.main.cookie.set = setCookie;
    window.admin.main.cookie.get = getCookie;
    window.admin.main.cookie.delete = delCookie;
})();


;(function () {
    $('.sidebar-toggle').on('click', function () {
        if ($('body').hasClass('sidebar-collapse')) {
            window.admin.main.cookie.delete('sidebar-toggle-control');
        } else {
            window.admin.main.cookie.set('sidebar-toggle-control', 1, 7);
        }
    });

})();