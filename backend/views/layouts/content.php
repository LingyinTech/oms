<?php

use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

?>
<div class="content-wrapper">
    <section class="content-header">
        <?php if (isset($this->blocks['content-header'])) : ?>
            <h1><?= $this->blocks['content-header'] ?></h1>
        <?php endif; ?>
        <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],]); ?>
    </section>

    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; 2016-<?= date('Y') ?> <a href="https://oms.lingyin99.com">深圳市灵引科技有限公司</a></strong> |
    <a target="_blank" href="https://beian.miit.gov.cn/">粤ICP备18103540号</a>
</footer>