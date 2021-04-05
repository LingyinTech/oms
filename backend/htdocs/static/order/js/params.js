namespace('admin.params.payMethod')
namespace('admin.params.orderType')
namespace('admin.params.invoiceType')
;(function () {

    function savePayMethod() {
        let url = '/params/pay-method';
        $.post(url, $("#PayMethod").serialize(), function (data) {
            if (data.status == 0) {
                layer.msg('保存成功')
                window.main.form.reset('PayMethod');
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
                window.main.form.reset('OrderType');
            } else {
                layer.msg('保存存失败');
            }
        }, 'json');
    }

    function saveInvoiceType() {
        let url = '/params/invoice-type';
        $.post(url, $("#InvoiceType").serialize(), function (data) {
            if (data.status == 0) {
                layer.msg('保存成功')
                window.main.form.reset('InvoiceType');
            } else {
                layer.msg('保存存失败');
            }
        }, 'json');
    }

    window.admin.params.payMethod.save = savePayMethod;
    window.admin.params.orderType.save = saveOrderType;
    window.admin.params.invoiceType.save = saveInvoiceType;
})();