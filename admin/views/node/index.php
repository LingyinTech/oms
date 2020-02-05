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
                    <h3 class="box-title">菜单列表</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin param-data">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>名称</th>
                                <th>路径</th>
                                <th>图标</th>
                                <th>类型</th>
                                <th>排序</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($list as $item): ?>
                                <tr class="">
                                    <td data-name="id" data-value="<?= $item['id'] ?>"><?= $item['id'] ?></td>
                                    <td data-name="label" data-value="<?= $item['label'] ?>"><?= $item['label'] ?></td>
                                    <td data-name="url" data-value="<?= $item['url'] ?>"><?= $item['url'] ?></td>
                                    <td><?= $item['icon'] ?></td>
                                    <td><?= isset($statusList[$item['status']]) ? $statusList[$item['status']] : ''; ?></td>
                                    <td><?= $item['sort'] ?></td>
                                    <td>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>

                        <div class="text-right paginationWrap">

                            <?= \yii\widgets\LinkPager::widget(['pagination' => $pages, 'maxButtonCount' => 6, 'hideOnSinglePage' => false]); ?>
                        </div>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>

<?php
$this->registerJsFile(Url::to('@web/js/layer-3.1.1/dist/layer.js'), ['depends' => 'dmstr\web\AdminLteAsset']);
$this->registerJsFile(Url::to('@web/static/admin/js/node.js'), ['depends' => 'dmstr\web\AdminLteAsset']);
?>