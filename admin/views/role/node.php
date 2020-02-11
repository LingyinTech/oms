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
        <div class="col-md-3">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">权限组</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table role-node-grid">
                            <thead>
                            <tr>
                                <th>名称</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($list as $item): ?>
                                <tr data-role_id="<?= $item['id'] ?>">
                                    <td data-name="name" data-value="<?= $item['name'] ?>"><?= $item['name'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-9">
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
                            <?php foreach ($nodeList as $item): ?>
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
                    <button type="reset" class="btn btn-default">重置</button>
                    <button type="button" class="btn btn-info pull-right" onclick="window.admin.role.saveNode()">提交
                    </button>
                </div>
                <!-- /.box-footer -->
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

<?php
$this->registerJsFile(Url::to('@web/js/layer-3.1.1/dist/layer.js'), ['depends' => 'dmstr\web\AdminLteAsset']);
$this->registerJsFile(Url::to('@web/static/admin/js/role.js'), ['depends' => 'dmstr\web\AdminLteAsset']);
?>