namespace('admin.profile')
;(function () {

    function savePassword() {
        let url = '/admin/profile/password';
        let load = layer.load(2, {time: 3 * 1000});
        $.post(url, $("#PasswordForm").serialize(), function (data) {
            if (data.status == 0) {
                $("#PasswordForm")[0].reset();
            }
            layer.close(load);
            layer.msg(data.msg);
        }, 'json');
    }

    window.admin.profile.password = savePassword;
})();