
<div class="row">
    <div class="col-md-12">
        <ul class="tree_menu">
            <li>
                <a onclick="window.parent.admin.node.select(0,'根节点');"><i class="icon"></i> <span>根节点</span> </a>
                <?php if (!empty($list)): ?>
                    <ul class="tree_menu">
                        <?php foreach ($list as $item): ?>
                        <li>
                            <a onclick="window.parent.admin.node.select(<?=$item['id']?>,'<?=$item['label']?>');"><i class="icon"></i> <span><?=$item['label']?></span> </a>
                            <?php if (!empty($item['items'])): ?>
                                <ul class="tree_menu">
                                    <?php foreach ($item['items'] as $v): ?>
                                        <li>
                                            <a onclick="window.parent.admin.node.select(<?=$v['id']?>,'<?=$v['label']?>');"><i class="icon"></i> <span><?=$v['label']?></span> </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </li>
        </ul>
    </div>
</div>