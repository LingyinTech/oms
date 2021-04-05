<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>

    <div class="row">
        <div class="col-md-8">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $action ?></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?php $form = ActiveForm::begin([
                                                    'id' => 'TemplateForm',
                                                    'class' => 'form-group has-feedback',
                                                    'fieldConfig' => [
                                                        'template' => "{input}<span class='form-control-feedback'></span>",
                                                    ],
                                                ]); ?>
                <div class="box-body">
                    <?= $form->field($model, 'id')->input('hidden') ?>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">模板名称</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'name')->input('text', ['maxlength' => '64', 'placeholder' => '模板名称']) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">绑定路径</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'path')->input('text', ['placeholder' => '绑定路径']) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">状态</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'status')->dropDownList($statusList) ?>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="reset" class="btn btn-default">重置</button>
                    <button type="button" onclick="window.view.template.save()" class="btn btn-info pull-right">提交</button>
                </div>
                <!-- /.box-footer -->
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

<?php
$this->registerJsFile(Url::to('@web/static/view/js/template.js'), ['depends' => 'backend\assets\AppAsset']);
?>