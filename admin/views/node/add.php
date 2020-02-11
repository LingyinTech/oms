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
                    'id' => 'NodeForm',
                    'class' => 'form-group has-feedback',
                    'fieldConfig' => [
                        'template' => "{input}<span class='form-control-feedback'></span>",
                    ],
                ]); ?>
                <div class="box-body">
                    <?= $form->field($model, 'id')->input('hidden') ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">父级菜单</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'pid', [
                                'template' => '<div class="input-group">{input}
                                <input type="text" value="'.$parentLabel.'" class="form-control" id="nodeform-pname" readonly="readonly">
							    <span class="input-group-btn">
							    <button class="btn btn-primary" onclick="window.admin.node.pop()" type="button">选择</button>
							    </span>
							    </div>'
                            ])->input('hidden'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">菜单名称</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'label')->input('text', ['maxlength' => '128', 'placeholder' => '菜单名称']) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">路径</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'url')->input('text', ['maxlength' => '128', 'placeholder' => '路径']) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">图标</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'icon')->input('text', ['maxlength' => '128', 'placeholder' => '图标']) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">排序</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'sort')->input('text', ['maxlength' => '2', 'placeholder' => '排序']) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">菜单类型</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'status')->dropDownList($statusList) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">备注</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'remark')->textarea(['style' => 'width: 100%;line-height: 30px;']) ?>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="reset" class="btn btn-default">重置</button>
                    <button type="button" onclick="window.admin.node.save()" class="btn btn-info pull-right">提交</button>
                </div>
                <!-- /.box-footer -->
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

<?php
$this->registerJsFile(Url::to('@web/js/layer-3.1.1/dist/layer.js'), ['depends' => 'dmstr\web\AdminLteAsset']);
$this->registerJsFile(Url::to('@web/static/admin/js/node.js'), ['depends' => 'dmstr\web\AdminLteAsset']);
?>