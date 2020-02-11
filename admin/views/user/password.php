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
                    <h3 class="box-title">修改密码</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?php $form = ActiveForm::begin([
                    'id' => 'PasswordForm',
                    'class' => 'form-group has-feedback',
                    'fieldConfig' => [
                        'template' => "{input}<span class='form-control-feedback'></span>",
                    ],
                ]); ?>
                <div class="box-body">
                    <?= $form->field($model, 'user_id')->input('hidden') ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">新密码</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'password')->input('password', ['minlength' => '6', 'placeholder' => '请输入密码']) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">确认密码</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'confirm_password')->input('password', ['minlength' => '6', 'placeholder' => '请再次输入密码']) ?>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="reset" class="btn btn-default">重置</button>
                    <button type="button" onclick="window.admin.user.password()" class="btn btn-info pull-right">提交</button>
                </div>
                <!-- /.box-footer -->
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

<?php
$this->registerJsFile(Url::to('@web/js/layer-3.1.1/dist/layer.js'), ['depends' => 'dmstr\web\AdminLteAsset']);
$this->registerJsFile(Url::to('@web/static/admin/js/user.js'), ['depends' => 'dmstr\web\AdminLteAsset']);
?>