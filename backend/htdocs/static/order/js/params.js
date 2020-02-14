namespace('admin.params.payMethod')
namespace('admin.params.orderType')
;(function () {

    $('table.data-grid tbody tr').on('click', function () {
        let formName = $('table.data-grid').data('form');
        $(this).children('td').each(function (i, v) {
            let name = $(this).data('name');
            let value = $(this).data('value');
            $('#'+formName+'-' + name).val(value);
        })
    });

    function savePayMethod() {
        let url = '/params/pay-method';
        $.post(url, $("#PayMethod").serialize(), function (data) {
            if (data.status == 0) {
                layer.msg('保存成功')
                $('#PayMethod')[0].reset();
            } else {
                layer.msg('保存存失败');
            }
        }, 'json');
    }

    function saveOrderType() {
        let url = '/params/order-type';
        $.post(url, $("#OrderType").serialize(), function (data) {
            if (data.status == 0) {
                layer.msg('保存成功')
                $('#OrderType')[0].reset();
            } else {
                layer.msg('保存存失败');
            }
        }, 'json');
    }

    window.admin.params.payMethod.save = savePayMethod;
    window.admin.params.orderType.save = saveOrderType;
})();