;(function () {

    $('.action-delete').on('click', function () {
        let url = '/admin/node/delete';
        let id = $(this).parents('tr').data('node_id');
        let that = this;
        if (confirm('确认要删除？')) {
            let load = layer.load(2, {time: 3 * 1000});
            $.post(url,{id:id}, function (data) {
                if (data.status == 0) {
                    $(that).parents('tr').remove();
                }
                layer.close(load);
                layer.msg(data.msg);
            }, 'json');
        }
    });

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