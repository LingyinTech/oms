<?php


namespace app\commands;


use yii\console\Controller;

class PartnerController extends Controller
{

    /**
     * 租户注册初始化
     * 1. 从注册队列里实时读取数据
     * 2. 选择业务数据库（或者生成，待分析）
     * 3. 初始化权限分组和权限数据
     * 4. 发邮件通知注册成功
     */
    public function actionCompleteRegister()
    {
        
    }

    /**
     * 数据迁移
     */
    public function actionTransfer()
    {
    }
}