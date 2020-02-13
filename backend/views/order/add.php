<?php


use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>

<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin([
            'id' => 'OrderForm',
            'class' => 'OrderForm',
            'fieldConfig' => [
                'template' => "{input}",
            ],
        ]); ?>

        <?= $form->field($model, 'id')->input('hidden') ?>

        <table>
            <colgroup>
                <col width="5.5%">
                <col width="5.5%">
                <col width="5.5%">
                <col width="5.5%">
                <col width="5.5%">
                <col width="5.5%">
                <col width="5.5%">
                <col width="5.5%">
                <col width="5.5%">
                <col width="5.5%">
                <col width="5.5%">
                <col width="5.5%">
                <col width="5.5%">
                <col width="5.5%">
                <col width="5.5%">
                <col width="5.5%">
                <col width="5.5%">
                <col width="5.5%">
            </colgroup>

            <tbody style="">

            <tr>
                <td>店铺名称</td>
                <td>
                    <?=$form->field($model,'shop_id')->dropDownList(['1' => 'xxxx1店','2' => '京东商城'])?>
                </td>
                <td>客户名称</td>
                <td><?=$form->field($model,'customer_name')->input('text')?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>

            </tr>

            <tr>

            </tr>

            <tr>

            </tr>

            </tbody>
        </table>

        <?php ActiveForm::end(); ?>

    </div>
</div>
