namespace('view.template')
;(function () {

    $('.action-delete').on('click', function () {
        let templateId = $(this).parents('tr').data('template_id');
        let url = '/template/delete';
        let load = layer.load(2, {time: 3 * 1000});
        $.post(url, {template_id: templateId}, function (data) {
            layer.msg(data.msg);
            layer.close(load);
        }, 'json');
    });

    function save() {
        let url = '/template/add';
        let load = layer.load(2, {time: 3 * 1000});
        $.post(url, $("#TemplateForm").serialize(), function (data) {
            if (data.status == 0) {
                window.main.form.reset('TemplateForm');
            }
            layer.close(load);
            layer.msg(data.msg);
        }, 'json');
    }

    window.view.template.save = save;

})();