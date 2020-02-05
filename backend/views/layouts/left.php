<?php

use lingyin\admin\components\Menu;

?>
<aside class="main-sidebar">

    <section class="sidebar">

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => Menu::getMenuItems(),
            ]
        ) ?>

    </section>

</aside>
