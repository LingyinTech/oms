namespace('admin.user')
;(function () {

    $('.action-password').on('click', function () {
        let userId = $(this).parents('tr').data('user_id');
        let url = '/admin/user/password?id=' + userId;
        layer.open({
            type: 2,
            content: url,
            title: false,
            area: ['450px', '300px']
        });
    });

    function savePassword() {
        let url = '/admin/user/password';
        let load = layer.load(2, {time: 3 * 1000});
        $.post(url, $("#PasswordForm").serialize(), function (data) {
            if (data.status == 0) {
                $("#PasswordForm")[0].reset();
            }
            layer.close(load);
            layer.msg(data.msg);
        }, 'json');
    }

    function save() {
        let url = '/admin/user/add';
        let load = layer.load(2, {time: 3 * 1000});
        $.post(url, $("#UserForm").serialize(), function (data) {
            if (data.status == 0) {
                window.main.form.reset('UserForm');
            }
            layer.close(load);
            layer.msg(data.msg);
        }, 'json');
    }

    window.admin.user.password = savePassword;
    window.admin.user.save = save;
})();