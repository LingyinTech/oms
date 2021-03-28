<?php


namespace backend\base;

use backend\logic\ViewLogic;
use lingyin\admin\components\AccessCheck;
use lingyin\common\components\snowflake\Snowflake;
use yii\db\Connection;
use yii\queue\Queue;

/**
 * Class Application
 * @package backend\base
 * @property Connection $authDb
 * @property Snowflake $snowflake
 * @property Queue $queue
 * @property AccessCheck $accessCheck
 * @property ViewLogic $viewConfig
 */
class Application extends \yii\web\Application
{

}