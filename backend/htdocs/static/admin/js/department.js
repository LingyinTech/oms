namespace('admin.department')
;(function () {

    $('table.department-grid tbody tr').on('click', function () {
        $(this).children('td').each(function (i, v) {
            let name = $(this).data('name');
            let value = $(this).data('value');

            $('#departmentform-' + name).val(value);
        })
    });

    function save() {
        let url = '/admin/department/save';
        $.post(url, $("#DepartmentForm").serialize(), function (data) {
            if (data.status == 0) {
                layer.msg('保存成功')
                $('#DepartmentForm')[0].reset();
            } else {
                layer.msg('保存存失败');
            }
        }, 'json');
    }

    window.admin.department.save = save;
})();