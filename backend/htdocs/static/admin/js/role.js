;(function () {

    $('table.role-grid tbody tr').on('click', function () {
        $(this).children('td').each(function (i, v) {
            let name = $(this).data('name');
            let value = $(this).data('value');

            $('#roleform-' + name).val(value);
        })
    });

    $('table.role-node-grid tbody tr').on('click', function () {
        let roleId = $(this).data('role_id');
        let url = '/admin/role/node';
        $('#rolenodeform-role_id').val(roleId);
        let load = layer.load(2, {time: 3 * 1000});
        $.post(url + '?role_id=' + roleId, function (data) {
            layer.close(load);
            if (0 == data.status) {
                $('#rolenodeform-node_id').val(data.data);
            } else {
                layer.msg(data.msg);
            }
        },'json');
    });

    function save() {
        let url = '/admin/role/save';
        $.post(url, $("#RoleForm").serialize(), function (data) {
            if (data.status == 0) {
                layer.msg('保存成功')
                $('#RoleForm')[0].reset();
            } else {
                layer.msg('保存存失败');
            }
        }, 'json');
    }

    window.admin = window.admin || {};
    window.admin.role = window.admin.role || {};

    window.admin.role.save = save;
})();