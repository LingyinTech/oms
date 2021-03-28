<?php

namespace common\components\ueditor;

use Yii;
use yii\helpers\ArrayHelper;

class UEditorAction extends \kucha\ueditor\UEditorAction
{

    protected function handleAction()
    {
        $action = app()->request->get('action');
        switch ($action) {
            case 'uploadimage':
                $result = $this->uploadToUpyun();
                //处理返回的URL
                if (substr($result['url'], 0, 1) != '/') {
                    $result['url'] = '/' . $result['url'];
                }
                $result['url'] = Yii::getAlias('@web' . $result['url']);
                break;

            default:
                return parent::handleAction();
        }

        return $result;

    }

    protected function uploadToUpyun()
    {
        $config = array(
            "pathRoot" => ArrayHelper::getValue($this->config, "imageRoot", $_SERVER['DOCUMENT_ROOT']),
            "pathFormat" => $this->config['imagePathFormat'],
            "maxSize" => $this->config['imageMaxSize'],
            "allowFiles" => $this->config['imageAllowFiles']
        );
        $fieldName = $this->config['imageFieldName'];
        $up = new UpyunUploader($fieldName,$config,'upyun');

        return $up->getFileInfo();

    }

}