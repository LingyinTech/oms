<?php if (!empty($list)): ?>
    <ul class="tree_menu">
        <?php foreach ($list as $item): ?>
            <li>
                <a onclick="window.parent.admin.department.select(<?=$item['id']?>,'<?=$item['label']?>');"><span><?=$item['label']?></span> </a>
                <?php if (!empty($item['items'])): ?>
                <?=$renderer->treeToHtml($item['items']);?>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>