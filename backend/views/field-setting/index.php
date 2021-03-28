<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2018/6/2
 * Time: 0:37
 */

use yii\helpers\Url;

?>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">字段设置</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin param-data">
                            <thead>
                            <tr>
                                <th>字段名</th>
                                <th>字段类型</th>
                                <th>可选值</th>
                                <th>系统字段</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($list as $item): ?>
                                <tr data-field_id="<?= $item['id'] ?>">
                                    <td><?= $item['label'] ?></td>
                                    <td><?= $item['type'] ?></td>
                                    <td><?= $item['options'] ?></td>
                                    <td><?= empty($item['is_system']) ? '否' : '是' ?></td>
                                    <td><?= $statusList[$item['status']] ?? ''; ?></td>
                                    <td>
                                        <a href="/admin/node/add?id=<?= $item['id'] ?>" class="glyphicon glyphicon-pencil action-edit mr5"></a>
                                        <?php if (empty($item['is_system'])):?>
                                        <a class="glyphicon glyphicon-trash action-delete"></a>
                                        <?php endif;?>
                                    </td>
                                </tr>
                            <?php
                            endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>

<?php
$this->registerJsFile(Url::to('@web/static/view/js/field.js'), ['depends' => 'backend\assets\AppAsset']);
?>