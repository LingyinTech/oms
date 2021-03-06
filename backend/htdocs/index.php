<?php

// comment out the following two lines when deployed to production
use backend\base\Application;

defined('YII_ENV') or define('YII_ENV', getenv('ENV') ?: 'prod');
defined('YII_DEBUG') or define('YII_DEBUG', 'dev' === YII_ENV);
defined('OMS_RUNTIME') or define('OMS_RUNTIME', 'fpm');
defined('CURRENT_COMPANY_ID') or define(
    'CURRENT_COMPANY_ID',
    $_SERVER['LINGYIN_COMPANY_ID'] ?? 0
);

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../../common/config/bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../common/config/main.php',
    require __DIR__ . '/../config/web.php'
);

try {
    (new Application($config))->run();
} catch (\yii\base\InvalidConfigException $e) {
    if (YII_DEBUG) {
        echo $e->getMessage();
    } else {
        throw new \yii\web\NotFoundHttpException('404 Not Found.');
    }
}

/**
 * @return Application
 */
function app()
{
    return Yii::$app;
}