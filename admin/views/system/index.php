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
                    <h3 class="box-title">数据库配置列表</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin param-data">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>租户名称</th>
                                <th>环境</th>
                                <th>连接</th>
                                <th>用户</th>
                                <th>密码</th>
                                <th>连接标识</th>
                                <th>其他配置</th>
                                <th>状态</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($list as $item): ?>
                                <tr data-db_config_id="<?=$item['id']?>">
                                    <td><?= $item['id'] ?></td>
                                    <td><?= $partnerList[$item['partner_id']] ?? $item['partner_id'] ?></td>
                                    <td><?= $item['environment'] ?></td>
                                    <td><?= $item['dsn'] ?></td>
                                    <td><?= $item['login'] ?></td>
                                    <td><?= $item['password'] ?></td>
                                    <td><?= $item['config_name']?></td>
                                    <td><?= $item['extra_config']?></td>
                                    <td><?= $statusList[$item['status']] ?? ''; ?></td>
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
$this->registerJsFile(Url::to('@web/static/admin/js/system.js'), ['depends' => 'backend\assets\AppAsset']);
?>