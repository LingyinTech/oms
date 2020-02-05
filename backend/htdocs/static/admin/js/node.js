;(function () {

    function save() {

        let url = '/admin/node/save';
        $.post(url, $("#NodeForm").serialize(), function (data) {
            if (data.status == 0) {
                layer.msg('保存成功')
            } else {
                layer.msg('保存存失败');
            }
        }, 'json');
    }

    window.admin = window.admin || {};
    window.admin.node = window.admin.node || {};

    window.admin.node.save = save;
})();