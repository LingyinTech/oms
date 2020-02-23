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
        <div class="col-md-7">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">所有付款方式</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin data-grid data-grid-check" data-form="paymethod">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Code</th>
                                <th>名称</th>
                                <th>是否有效</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($list as $item): ?>
                                <tr class="">
                                    <td data-name="id" data-value="<?= $item['id'] ?>"><?= $item['id'] ?></td>
                                    <td data-name="code" data-value="<?= $item['code'] ?>"><?= $item['code'] ?></td>
                                    <td data-name="name" data-value="<?= $item['name'] ?>"><?= $item['name'] ?></td>
                                    <td data-name="status" data-value="<?= $item['status'] ?>"><?= isset($statusList[$item['status']]) ? $statusList[$item['status']] : ''; ?></td>
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
                    <h3 class="box-title">付款方式</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?php $form = ActiveForm::begin([
                    'id' => 'PayMethod',
                    'class' => 'PayMethod',
                    'fieldConfig' => [
                        'template' => "{input}",
                    ],
                ]); ?>
                <div class="box-body">
                    <?= $form->field($model, 'id')->input('hidden') ?>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Code标识</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'code')->input('text', ['maxlength' => '128', 'placeholder' => '支付方式编码']) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label">名称</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'name')->input('text', ['maxlength' => '128', 'placeholder' => '支付方式名称']) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label">状态</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'status')->dropDownList($statusList) ?>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="reset" class="btn btn-default action-reset">重置</button>
                    <button type="button" onclick="window.admin.params.payMethod.save()" class="btn btn-info pull-right">提交
                    </button>
                </div>
                <!-- /.box-footer -->
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

<?php
$this->registerJsFile(Url::to('@web/static/order/js/params.js'), ['depends' => 'backend\assets\AppAsset']);
?>