<?php

namespace lingyin\common\behaviors;

use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;

/**
 * Class SnowflakeBehavior
 * @package lingyin\common\behaviors
 */
class SnowflakeBehavior extends AttributeBehavior
{
    public $cachePrefix = 'snowflake';

    public $primaryAttribute = 'id';

    public $value;

    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => $this->primaryAttribute,
            ];
        }
    }

    protected function getValue($event)
    {
        if ($this->value === null) {
            return app()->snowflake->next($this->cachePrefix);
        }

        return parent::getValue($event);
    }
}