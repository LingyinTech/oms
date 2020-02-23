namespace('admin.role')
;(function () {

    $('table.role-grid tbody tr').on('click', function () {
        $(this).children('td').each(function (i, v) {
            let name = $(this).data('name');
            let value = $(this).data('value');

            $('#roleform-' + name).val(value);
        })
    });

    $('table.role-node-grid tbody tr').on('click', function () {
        $('table.role-node-grid tbody tr').removeClass('active');
        $(this).addClass('active');
        let roleId = $(this).data('role_id');
        let url = '/admin/role/node';
        $('#rolenodeform-role_id').val(roleId);
        let load = layer.load(2, {time: 3 * 1000});
        $.post(url + '?role_id=' + roleId, function (data) {
            layer.close(load);
            if (0 == data.status) {
                $('#rolenodeform-node_id').val(data.data);
                let nodeArr = data.data.split(',');
                $('input.check_node').each(function () {
                    if (nodeArr.indexOf($(this).val()) >= 0) {
                        $(this).prop('checked', true);
                    } else {
                        $(this).prop('checked', false);
                    }
                })
            } else {
                layer.msg(data.msg);
            }
        }, 'json');
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

    function saveNode() {
        let roleId = $('#rolenodeform-role_id').val();
        if (!roleId) {
            layer.msg('请先选择角色');
            return;
        }

        let url = '/admin/role/save-node';
        let nodeArr = [];
        $('input.check_node:checked').each(function () {
            nodeArr.push($(this).val());
        });
        let nodeId = nodeArr.join(',');
        let load = layer.load(2, {time: 3 * 1000});
        $.post(url, {role_id: roleId, node_id: nodeId}, function (data) {
            layer.close(load);
            if (data.status == 0) {
                layer.msg('保存成功');
                $('#RoleNodeForm')[0].reset();
            } else {
                layer.msg('保存存失败');
            }
        }, 'json');
    }

    function saveUser() {

    }

    window.admin.role.save = save;
    window.admin.role.saveNode = saveNode;
    window.admin.role.saveUser = saveUser;
})();