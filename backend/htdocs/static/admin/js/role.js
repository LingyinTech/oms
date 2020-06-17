namespace('admin.role')
;(function () {

    $('table.role-grid tbody tr').on('click', function () {
        $(this).children('td').each(function (i, v) {
            let name = $(this).data('name');
            let value = $(this).data('value');

            $('#roleform-' + name).val(value);
        })
    });

    $('#RoleNodeForm input.check_node').on('click',function () {
        let check = $(this).prop('checked');
        let childNodeArr = $(this).parent().next().find('input.check_node');
        if (childNodeArr) {
            childNodeArr.each(function () {
                $(this).prop('checked',check);
            })
        }
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

    $('table.role-user-grid tbody tr').on('click', function () {
        $('table.role-user-grid tbody tr').removeClass('active');
        $(this).addClass('active');
        let userId = $(this).data('user_id');
        let url = '/admin/role/user';
        $('#roleuserform-user_id').val(userId);
        let load = layer.load(2, {time: 3 * 1000});
        $.post(url + '?user_id=' + userId, function (data) {
            layer.close(load);
            if (0 == data.status) {
                let roleArr = data.data.split(',');
                $('input.check_role').each(function () {
                    if (roleArr.indexOf($(this).val()) >= 0) {
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
                window.admin.main.form.reset('RoleNodeForm');
            } else {
                layer.msg('保存存失败');
            }
        }, 'json');
    }

    function saveUser() {
        let userId = $('#roleuserform-user_id').val();
        if (!userId) {
            layer.msg('请先选择员工');
            return;
        }

        let url = '/admin/role/save-user';
        let roleArr = [];
        $('input.check_role:checked').each(function () {
            roleArr.push($(this).val());
        });
        let roleId = roleArr.join(',');
        let load = layer.load(2, {time: 3 * 1000});
        $.post(url, {role_id: roleId, user_id: userId}, function (data) {
            layer.close(load);
            if (data.status == 0) {
                layer.msg('保存成功');
                window.admin.main.form.reset('RoleUserForm');
            } else {
                layer.msg('保存存失败');
            }
        }, 'json');
    }

    window.admin.role.save = save;
    window.admin.role.saveNode = saveNode;
    window.admin.role.saveUser = saveUser;
})();