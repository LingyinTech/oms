<?php


namespace lingyin\common\jobs;

use lingyin\common\base\Job;
use lingyin\common\models\vo\DbConfigForm;
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


    protected function active()
    {
        $dbConfigForm = new DbConfigForm();
        $data['partner_id'] = $this->partner_id;
        $data['environment'] = YII_ENV;
        return $dbConfigForm->createDbConfigByTemplate($data,1);
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