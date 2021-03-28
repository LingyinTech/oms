<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2018/4/24
 * Time: 23:02
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>

    <link rel="stylesheet" href="<?= Url::to('@web/static/order/css/index.css') ?>">
    <link rel="stylesheet" href="<?= Url::to('@web/js/city-picker/city-picker.css') ?>" type="text/css">

<div class="row">
    <section class="create">
        <div class="order-shadow" style="">

            <?php $form = ActiveForm::begin([
                'id' => 'orderForm',
                'class' => 'orderForm',
                'fieldConfig' => [
                    'template' => "{input}",
                ],
            ]); ?>

            <table class="newTabNoColor" style="">
                <colgroup>
                    <col width="4.95%">
                    <col width="4.95%">
                    <col width="4.95%">
                    <col width="4.95%">
                    <col width="4.95%">
                    <col width="4.95%">
                    <col width="4.95%">
                    <col width="4.95%">
                    <col width="4.95%">
                    <col width="4.95%">
                    <col width="4.95%">
                    <col width="4.95%">
                    <col width="4.95%">
                    <col width="4.95%">
                    <col width="4.95%">
                    <col width="4.95%">
                    <col width="4.95%">
                    <col width="4.95%">
                </colgroup>

                <tbody style="">
                <tr style="height: 60px;">
                    <td colspan="2">
                        <img src="<?= Url::to('@web/static/order/images/logo.png') ?>">
                    </td>
                    <td colspan="12">
                        <?= $form->field($model, 'id')->input('hidden') ?>
                        <?= $form->field($model, 'order_state')->input('hidden') ?>
                        <?= $form->field($model, 'order_name')->input('text', ['maxlength' => '128']) ?>
                    </td>
                    <td colspan="6" style="border-left: none;text-align: left;">
                        <?php if (!empty($model->barCode)): ?>
                            <img src="data:image/png;base64,<?= $model->barCode ?>">
                        <?php endif; ?>
                    </td>
                </tr>

                <?php foreach ($fieldGroup as $item):?>
                    <?php if(empty($item['columnList'])) {continue;}?>
                    <?php if(!empty($item['title'])):?>
                        <tr>
                            <td colspan="20" class="tdColor">
                                <div style="text-align: center"><?=$item['title']?></div>
                            </td>
                        </tr>
                    <?php endif;?>
                    <?php foreach ($item['columnList'] as $column):?>
                        <?php if('address' === $column['type']):?>
                            <tr>
                                <td colspan="2" class="tdColor">
                                    <?=$column['fieldList'][0]['label']?>
                                </td>
                                <td colspan="7">
                                    <div id="distpicker">
                                        <div class="form-group">
                                            <div style="position: relative;">
                                                <?= $form->field($model, $column['fieldList'][0]['field'])->input('hidden', [
                                                    'id' => 'city-picker1',
                                                    'class' => 'form-control city-picker-input',
                                                    'readonly' => 'readonly',
                                                    'data-toggle' => 'city-picker'
                                                ]) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td colspan="11" style="position: relative;">
                                    <?= $form->field($model, $column['fieldList'][1]['field'])->input('text', ['maxlength' => '256', 'placeholder' => $column['fieldList'][1]['remark']]) ?>
                                </td>
                            </tr>
                        <?php else:?>
                            <tr>
                                <?php foreach ($column['fieldList'] as $field):?>
                                    <td colspan="2" class="tdColor"><?=$field['label']?></td>
                                    <td colspan="3">
                                        <?= $form->field($model, $field['field'])->input('text', ['maxlength' => '64']) ?>
                                    </td>
                                <?php endforeach;?>
                            </tr>
                        <?php endif;?>
                    <?php endforeach;?>

                <?php endforeach;?>

                <tr>
                    <td colspan="2" class="tdColor">归属</td>
                    <td colspan="3">
                        <?= $form->field($model, 'user_id')->input('text', ['style' => 'display:none;']) ?>
                        <?= $form->field($model, 'real_name')->input('text', ['maxlength' => '30', 'readonly' => 'readonly']) ?>
                    </td>
                    <td colspan="2" class="tdColor">金额</td>
                    <td colspan="2">
                        <?= $form->field($model, 'order_amount')->input('text', ['maxlength' => '30']) ?>
                    </td>

                    <td colspan="2" class="tdColor">订单类型</td>
                    <td colspan="2">
                        <?= $form->field($model, 'order_type')->dropDownList($orderTypeList) ?>
                    </td>

                    <td colspan="2" class="tdColor">付款方式</td>
                    <td colspan="3">
                        <?= $form->field($model, 'pay_method')->dropDownList($payMethodList) ?>
                    </td>

                </tr>

                <tr>
                    <td colspan="2" class="tdColor">订单编号</td>
                    <td colspan="3"><?= $form->field($model, 'order_sn')->input('text', ['maxlength' => '16']) ?></td>
                    <td colspan="2" class="tdColor">下单时间</td>
                    <td colspan="2"><?= $form->field($model, 'order_time')->input('text', ['readonly' => 'readonly']) ?></td>
                    <td colspan="2" class="tdColor">安排时间</td>
                    <td colspan="2"><?= $form->field($model, 'plan_time')->input('text', ['readonly' => 'readonly']) ?></td>
                    <td colspan="2" class="tdColor">快递单号</td>
                    <td colspan="3"><?= $form->field($model, 'ship_no')->input('text', ['maxlength' => '30']) ?></td>
                </tr>

                <tr>
                    <td colspan="18" class="tdColor">
                        <div style="text-align: center">发票信息</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" class="tdColor">发票抬头</td>
                    <td colspan="3">
                        <?= $form->field($model, 'invoice_title')->input('text', ['maxlength' => '256']) ?>
                    </td>

                    <td colspan="2" class="tdColor">类别</td>
                    <td colspan="2">
                        <?= $form->field($model, 'invoice_type')->dropDownList($invoiceTypeList) ?>
                    </td>

                    <td colspan="2" class="tdColor">数量</td>
                    <td colspan="2"><?= $form->field($model, 'invoice_num')->input('text', ['maxlength' => '16']) ?></td>

                    <td colspan="2" class="tdColor">金额</td>
                    <td colspan="3"><?= $form->field($model, 'invoice_amount')->input('text') ?></td>

                </tr>

                <tr>
                    <td colspan="2" class="tdColor">含税单价</td>
                    <td colspan="3">
                        <?= $form->field($model, 'invoice_unit_price')->input('text') ?>
                    </td>
                    </td>
                    <td colspan="2" class="tdColor">
                        其它更详细开票信息
                    </td>
                    <td colspan="11">
                        <?= $form->field($model, 'invoice_note')->input('text', ['maxlength' => '1024']) ?>
                    </td>
                </tr>

                <tr>
                    <td colspan="20" class="tdColor">
                        <div style="text-align: center">其它重要信息</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="20" class="tdColor">
                        <?= $form->field($model, 'extra_note')->textarea(['style' => 'width: 100%;line-height: 30px;']) ?>
                    </td>
                </tr>

                <tr>
                    <td colspan="20" class="tdColor">
                        <div style="text-align: center">效果图</div>
                    </td>
                </tr>

                </tbody>
            </table>
            <?php ActiveForm::end(); ?>

            <div class="xiadan_header guideTips1 " style=" width:100%;">
                <a href="javascript:void();" id="rate" class="b-upload">
                    <input type="file" name="file" id="file1" onchange="window.order.ajaxFileUpload(1,false);">
                    <div class="upload-file-name btn-third">
                        <img class="zip-clode" src="<?= Url::to('@web/static/order/images/up-cloud.png') ?>">
                        <span class="zip-change" style="display:none;"><img
                                    src="<?= Url::to('@web/static/order/images/zip_change.png') ?>"></span>
                        <span id="preview1">点击或拖拽上传资料包</span>
                        <img src="<?= Url::to('@web/static/order/images/loading.gif') ?>" id="loading1"
                             style="width:28px;display:none;">
                    </div>
                    <!-- 文件拖拽区 -->
                    <div class="upload_file_wrap select-shadow" id="dataArea" style="display:none;">拖拽资料到此区域</div>
                </a>
            </div>

        </div>

        <div class="text-center" style="margin:30px 0;">

            <?php if ($model->order_state <= 0): ?>
                <span class="tankBtn">
		        	<input type="button" class="btn btn-second" style="font-size:16px;height: 40px;" value="存稿箱"
                           onclick="window.order.save(0)" id="submit_draft">
		        	<div class="order-btn-tishi" id="caogao-btn-tishi" style="display: none;">
		        		<img src="<?= Url::to('@web/static/order/images/order-loading.gif') ?>">
		        		<span>正在存储...</span>
		        	</div>
		        </span>

                <span class="tankBtn">
		        	<input type="button" class="btn btn-main" style="font-size:16px;height: 40px;" value="终搞确认"
                           onclick="window.order.save(1)" id="submit">
		        	<div class="order-btn-tishi" id="xiadan-btn-tishi" style="display: none;">
		        		<img src="<?= Url::to('@web/static/order/images/order-loading.gif') ?>">
		        		<span>正在下单...</span>
		        	</div>
		        </span>
            <?php endif; ?>
        </div>
    </section>
</div>

    <!-- 订单草稿提交成功提示框 -->
    <div class="tank-tishi-main" style="display:none;">
        <!-- 提交弹框 -->
        <div class="account">
            <span class="tank-tishi-main-cancel" onclick="window.location.reload()">×</span>
            <span class="tank-tishi-main-con" style="margin-top: 20px;">
				<span class="tank-tishi-main-con-txt"></span>
			</span>
            <div class="tank-tishi-time" id="tank-tishi-time"></div>
            <input type="button" class="tank-tishi-btn tishi-btn" value="继续编辑" onclick="window.location.reload()">
        </div>
    </div>

<?php
$this->registerJsFile(Url::to('@web/js/city-picker/city-picker.data.js'), ['depends' => 'backend\assets\AppAsset']);
$this->registerJsFile(Url::to('@web/js/city-picker/city-picker.js'), ['depends' => 'backend\assets\AppAsset']);
$this->registerJsFile(Url::to('@web/static/order/js/order.js'), ['depends' => 'backend\assets\AppAsset']);
?>