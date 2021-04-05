namespace('admin.partner')
;(function () {

    $('input.date-picker').datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: true,
        autoclose: true
    });


    function save() {
        let url = '/admin/partner/save';
        $.post(url, $("#PartnerForm").serialize(), function (data) {
            if (data.status == 0) {
                layer.msg('保存成功')
                window.main.form.reset('PartnerForm');
            } else {
                layer.msg('保存存失败');
            }
        }, 'json');
    }

    window.admin.partner.save = save;
})();