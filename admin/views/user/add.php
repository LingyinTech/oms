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

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">员工管理</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?php $form = ActiveForm::begin([
                    'id' => 'UserForm',
                    'class' => 'form-group has-feedback',
                    'fieldConfig' => [
                        'template' => "{input}<span class='form-control-feedback'></span>",
                    ],
                ]); ?>
                <div class="box-body">
                    <?= $form->field($model, 'user_id')->input('hidden') ?>
                    <?= $form->field($model, 'avatar')->input('hidden') ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">编号</label>
                        <div class="col-sm-8">
                            <?= $form->field($model, 'username')->input('text') ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">邮箱</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'email')->input('text') ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">姓名</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'real_name')->input('text') ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">部门</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'department_id')->dropDownList($departmentList) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">办公室电话</label>
                        <div class="col-sm-8">
                            <?= $form->field($model, 'tel')->input('text') ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">手机号</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'phone')->input('text') ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">状态</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'status')->dropDownList($statusList) ?>
                        </div>
                    </div>

                    <?php if (app()->user->getIdentity()->getSupperAdmin()): ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">合作伙伴</label>

                            <div class="col-sm-8">
                                <?= $form->field($model, 'partner_id')->dropDownList(array_merge(['请选择'],$partnerList)) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="reset" class="btn btn-default">重置</button>
                    <button type="button" onclick="window.admin.user.save()" class="btn btn-info pull-right">提交</button>
                </div>
                <!-- /.box-footer -->
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

<?php
$this->registerJsFile(Url::to('@web/static/admin/js/user.js'), ['depends' => 'backend\assets\AppAsset']);
?>