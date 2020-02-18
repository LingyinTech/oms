namespace('admin.department')
;(function () {

    function selectParent() {
        let url = '/admin/department/select';
        layer.open({
            type: 2,
            content: url,
            title: false,
            area: ['450px', '500px']
        });
    }

    function save() {
        let url = '/admin/department/save';
        $.post(url, $("#DepartmentForm").serialize(), function (data) {
            if (data.status == 0) {
                layer.msg('保存成功')
            } else {
                layer.msg('保存失败');
            }
        }, 'json');
    }

    window.admin.department.save = save;
    window.admin.department.pop = selectParent;
})();