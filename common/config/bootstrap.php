<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2017/12/19
 * Time: 21:31
 */

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');