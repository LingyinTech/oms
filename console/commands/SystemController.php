<?php


namespace app\commands;


use yii\console\Controller;

class SystemController extends Controller
{
    public function actionNodeInit()
    {
        $list = [
            ''
        ];

        foreach ($list as $sql) {
            app()->db->createCommand($sql)->execute();
        }
    }
}