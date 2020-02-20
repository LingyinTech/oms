<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2018/6/2
 * Time: 0:37
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>

    <link rel="stylesheet" href="<?= Url::to('@web/js/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker3.min.css') ?>" type="text/css">

<div class="row">
    <div class="col-md-7">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">合作伙伴</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table data-grid data-grid-check" data-form="partnerform">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>标识</th>
                            <th class="none">简码</th>
                            <th>名称</th>
                            <th>状态</th>
                            <th colspan="2">有效期</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($list as $item): ?>
                            <tr>
                                <td data-name="id" data-value="<?=$item['id']?>"><?=$item['id']?></td>
                                <td data-name="code" data-value="<?=$item['code']?>"><?=$item['code']?></td>
                                <td class="none" data-name="short_code" data-value="<?=$item['short_code']?>"><?=$item['short_code']?></td>
                                <td data-name="name" data-value="<?=$item['name']?>"><?=$item['name']?></td>
                                <td data-name="status" data-value="<?=$item['status']?>"><?= isset($statusList[$item['status']]) ? $statusList[$item['status']] : ''; ?></td>
                                <td data-name="active_start" data-value="<?=!empty($item['active_start']) ? date('Y-m-d',$item['active_start']) : ''?>"><?=!empty($item['active_start']) ? date('Y-m-d',$item['active_start']) : '-'?></td>
                                <td data-name="active_end" data-value="<?=!empty($item['active_end']) ? date('Y-m-d',$item['active_end']) : ''?>"><?=!empty($item['active_end']) ? date('Y-m-d',$item['active_end']) : '-'?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="text-right paginationWrap">
                        <?= \yii\widgets\LinkPager::widget(['pagination' => $pages, 'maxButtonCount' => 6]); ?>
                    </div>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <div class="col-md-5">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">合作伙伴</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php $form = ActiveForm::begin([
                'id' => 'PartnerForm',
                'class' => 'form-group has-feedback',
                'fieldConfig' => [
                    'template' => "{input}<span class='form-control-feedback'></span>",
                ],
            ]); ?>
                <div class="box-body">
                    <?= $form->field($model, 'id')->input('hidden') ?>

                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label">标识</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'code')->input('text', ['maxlength' => '16','placeholder'=>'伙伴标识']) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label">简码</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'short_code')->input('text', ['maxlength' => '16','placeholder'=>'简码']) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label">名称</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'name')->input('text', ['maxlength' => '64','placeholder'=>'合作伙伴']) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">状态</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'status')->dropDownList($statusList) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label">有效期起始时间</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'active_start')->input('text', ['class' => 'form-control date-picker','placeholder'=>'有效期']) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label">有效期结束时间</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'active_end')->input('text', ['class' => 'form-control date-picker','placeholder'=>'有效期']) ?>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="reset" class="btn btn-default action-reset">重置</button>
                    <button type="button" class="btn btn-info pull-right" onclick="window.admin.partner.save()">提交</button>
                </div>
                <!-- /.box-footer -->
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
$this->registerJsFile(Url::to('@web/js/bootstrap-datepicker-1.9.0/js/bootstrap-datepicker.min.js'), ['depends' => 'backend\assets\AppAsset']);
$this->registerJsFile(Url::to('@web/static/admin/js/partner.js'), ['depends' => 'backend\assets\AppAsset']);
?>