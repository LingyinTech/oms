<?php


namespace backend\base;

use lingyin\common\components\snowflake\Snowflake;
use yii\db\Connection;

/**
 * Class Application
 * @package backend\base
 * @property Connection $authDb
 * @property Snowflake $snowflake
 */
class Application extends \yii\web\Application
{

}