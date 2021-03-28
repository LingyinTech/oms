<?php


namespace lingyin\common\jobs;

use lingyin\admin\models\vo\RoleForm;
use lingyin\common\base\Job;
use lingyin\common\models\vo\DbConfigForm;
use Exception;
use yii\queue\Queue;

class PartnerJob extends Job
{
    /**
     * @var int 伙伴 ID
     */
    public $partner_id;

    /**
     * @var string 事件类型，active 激活 | inactive 失效
     */
    public $event;

    /**
     * 租户注册初始化，读队列操作
     * 1. 选择业务数据库（或者生成，待分析）
     * 2. 初始化权限分组和权限数据
     * 3. 发邮件通知注册成功
     */
    protected function active()
    {
        try {
            $dbConfigForm = new DbConfigForm();
            $data = [
                'partner_id' => $this->partner_id,
                'environment' => YII_ENV
            ];
            $db = $dbConfigForm->createDbConfigByTemplate($data, 10001);

            if (empty($db)) {
                throw new Exception('创建数据库连接配配失败');
            }

            app()->runAction('system/init-db', ['db' => $db, 'interactive' => false]);

            $data = [
                'name' => '管理员',
                'status' => 2,
                'partner_id' => $this->partner_id,
            ];
            $model = new RoleForm();
            $model->load($data);
            $model->saveRole();


        } catch (Exception $e) {
        }
    }

    public function inactive()
    {
    }

    /**
     * @param Queue $queue
     * @return mixed|void
     */
    public function execute($queue)
    {
        switch ($this->event) {
            case 'active':
                $this->active();
                break;
            case 'inactive':
                $this->inactive();
                break;
        }
    }
}