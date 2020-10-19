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
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">权限组</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table role-grid">
                            <thead>
                            <tr>
                                <th class="none">ID</th>
                                <th>名称</th>
                                <th>状态</th>
                                <th class="none">排序</th>
                                <th class="none">备注</th>
                                <th class="none">伙伴ID</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($list as $item): ?>
                                <tr>
                                    <td class="none" data-name="id" data-value="<?= $item['id'] ?>"></td>
                                    <td data-name="name" data-value="<?= $item['name'] ?>">
                                        <?= $item['name'] ?>
                                        <?php if (app()->user->getIdentity()->getSupperAdmin() && isset($partnerList[$item['partner_id']])): ?>
                                        (<?= $partnerList[$item['partner_id']] ?>)
                                        <?php endif; ?>
                                    </td>
                                    <td data-name="status" data-value="<?= $item['status'] ?>"><?= isset($statusList[$item['status']]) ? $statusList[$item['status']] : ''; ?></td>
                                    <td class="none" data-name="sort" data-value="<?= $item['sort'] ?>"></td>
                                    <td class="none" data-name="remark" data-value="<?= $item['remark'] ?>"></td>
                                    <td class="none" data-name="partner_id" data-value="<?= $item['partner_id'] ?>"></td>
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
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">权限组管理</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?php $form = ActiveForm::begin([
                    'id' => 'RoleForm',
                    'class' => 'form-group has-feedback',
                    'fieldConfig' => [
                        'template' => "{input}<span class='form-control-feedback'></span>",
                    ],
                ]); ?>
                <div class="box-body">
                    <?= $form->field($model, 'id')->input('hidden') ?>

                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label">名称</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'name')->input('text', ['maxlength' => '16', 'placeholder' => '权限组名称']) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">排序</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'sort')->input('text', ['maxlength' => '2', 'placeholder' => '排序']) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">状态</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'status')->dropDownList([10 => '启用', 1 => '禁用']) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">备注</label>

                        <div class="col-sm-8">
                            <?= $form->field($model, 'remark')->textarea(['style' => 'width: 100%;', 'placeholder' => '备注']) ?>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="reset" class="btn btn-default">重置</button>
                    <button type="button" class="btn btn-info pull-right" onclick="window.admin.role.save()">提交</button>
                </div>
                <!-- /.box-footer -->
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

<?php
$this->registerJsFile(Url::to('@web/static/admin/js/role.js'), ['depends' => 'backend\assets\AppAsset']);
?>