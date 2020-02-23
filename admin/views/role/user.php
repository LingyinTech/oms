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
        <div class="col-md-9">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">员工列表</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table role-node-grid">
                            <thead>
                            <tr>
                                <th>员工编号</th>
                                <th>姓名</th>
                                <th>部门</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($list as $item): ?>
                                <tr data-user_id="<?= $item['user_id'] ?>">
                                    <td data-name="username" data-value="<?= $item['username'] ?>"><?= $item['username'] ?></td>
                                    <td data-name="real_name" data-value="<?= $item['real_name'] ?>"><?= $item['real_name'] ?></td>
                                    <td data-name="department_id" data-value=""></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>

                        <div class="text-right paginationWrap">
                            <?= \yii\widgets\LinkPager::widget(['pagination' => $pages, 'maxButtonCount' => 3]); ?>
                        </div>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-3">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">权限分配</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?php $form = ActiveForm::begin([
                    'id' => 'RoleNodeForm',
                    'class' => '',
                    'fieldConfig' => [
                        'template' => "{input}",
                    ],
                ]); ?>

                <div class="box-body">
                    <?= $form->field($model, 'role_id')->input('hidden') ?>

                    <div class="row">
                        <div class="col-md-12">
                            <?php foreach ($roleList as $item): ?>
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="checkbox" name="check_node[]" class="check_node"
                                               value="<?= $item['id'] ?>"> <?= $item['label'] ?>
                                        <?php if (isset($nodeStatusList[$item['status']])): ?>
                                            (<?= $nodeStatusList[$item['status']] ?>)
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-9">
                                        <?php if (!empty($item['items'])): ?>
                                            <?php foreach ($item['items'] as $v): ?>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <input type="checkbox" name="check_node[]" class="check_node"
                                                               value="<?= $v['id'] ?>"> <?= $v['label'] ?>
                                                        <?php if (isset($nodeStatusList[$v['status']])): ?>
                                                            (<?= $nodeStatusList[$v['status']] ?>)
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <?php if (!empty($v['items'])): ?>
                                                            <?php foreach ($v['items'] as $vv): ?>
                                                                <span class="nowrap">
                                                                    <input type="checkbox" name="check_node[]" class="check_node" value="<?= $vv['id'] ?>"> <?= $vv['label'] ?>
                                                                    <?php if (isset($nodeStatusList[$vv['status']])): ?>
                                                                        (<?= $nodeStatusList[$vv['status']] ?>)
                                                                    <?php endif; ?>
                                                                </span>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="reset" class="btn btn-default ">重置</button>
                    <button type="button" class="btn btn-info pull-right" onclick="window.admin.role.saveUser()">提交
                    </button>
                </div>
                <!-- /.box-footer -->
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

<?php
$this->registerJsFile(Url::to('@web/static/admin/js/role.js'), ['depends' => 'backend\assets\AppAsset']);
?>