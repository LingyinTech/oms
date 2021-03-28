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
        <div class="col-md-8">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $action ?></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?php $form = ActiveForm::begin([
                    'id' => 'FieldConfigForm',
                    'class' => 'form-group has-feedback',
                    'fieldConfig' => [
                        'template' => "{input}<span class='form-control-feedback'></span>",
                    ],
                ]); ?>
                <div class="box-body">
                    <?= $form->field($model, 'id')->input('hidden') ?>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">字段名（标识）</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'field')->input('text', ['maxlength' => '32', 'placeholder' => '字段名，只能为英文']) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">字段名称</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'label')->input('text', ['maxlength' => '64', 'placeholder' => '字段显示名称']) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">字段类型</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'type')->dropDownList($fieldTypeList) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">字段可选值</label>
                        <div class="col-sm-8">
                            <?= $form->field($model, 'options[]')->input('text', ['maxlength' => '64', 'placeholder' => '字段可选值']) ?>
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
                    <button type="button" onclick="window.view.field.save()" class="btn btn-info pull-right">提交</button>
                </div>
                <!-- /.box-footer -->
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

<?php
$this->registerJsFile(Url::to('@web/static/admin/js/node.js'), ['depends' => 'backend\assets\AppAsset']);
?>