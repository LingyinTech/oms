<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use dmstr\web\AdminLteAsset;
use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
        'js/layer-3.1.1/dist/layer.js',
        'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        AdminLteAsset::class,
    ];

    public function __construct($config = [])
    {
        parent::__construct($config);
        if (!empty(app()->params['domain.static'])) {
            $this->baseUrl = app()->params['domain.static'];
        }
        if (!empty(app()->params['domain.static.version'])) {
            $this->baseUrl .= app()->params['domain.static.version'];
        }
    }
}
