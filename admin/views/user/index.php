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
                    <h3 class="box-title">用户列表</h3>

                    <div class="pull-right">
                        <?php if (app()->accessCheck->checkPermission('admin/user/add')): ?>
                            <a href="/admin/user/add" class="btn btn-primary">添加员工</a>
                        <?php endif; ?>
                        <?php if (app()->accessCheck->checkPermission('admin/user/batch-add')): ?>
                            <a href="/admin/user/batch-add" class="btn btn-primary">批量添加</a>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin param-data">
                            <thead>
                            <tr>
                                <th class="none">ID</th>
                                <th>员工编号</th>
                                <th>姓名</th>
                                <th>邮箱</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($list as $item): ?>
                                <tr data-user_id="<?= $item['user_id'] ?>">
                                    <td class="none"><?= $item['user_id'] ?></td>
                                    <td>
                                        <?= $item['username'] ?>
                                        <?php
                                        if (app()->user->getIdentity()->getSupperAdmin(
                                            ) && isset($partnerList[$item['partner_id']])): ?>
                                            (<?= $partnerList[$item['partner_id']] ?>)
                                        <?php
                                        endif; ?>
                                    </td>
                                    <td><?= $item['real_name'] ?></td>
                                    <td><?= $item['email'] ?></td>
                                    <td><?= isset($statusList[$item['status']]) ? $statusList[$item['status']] : '' ?></td>
                                    <td>
                                        <a href="/admin/user/add?id=<?= $item['user_id'] ?>" title="修改"
                                           class="glyphicon glyphicon-pencil action-edit mr5"></a>
                                        <a class="glyphicon glyphicon-lock action-password" title="设置密码"></a>
                                        <a class="glyphicon glyphicon-trash action-delete" title="删除"></a>
                                    </td>
                                </tr>
                            <?php
                            endforeach; ?>
                            </tbody>
                        </table>

                        <div class="text-right paginationWrap">

                            <?= \yii\widgets\LinkPager::widget(
                                ['pagination' => $pages, 'maxButtonCount' => 6, 'hideOnSinglePage' => false]
                            ); ?>
                        </div>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>

<?php
$this->registerJsFile(Url::to('@web/static/admin/js/user.js'), ['depends' => 'backend\assets\AppAsset']);
?>