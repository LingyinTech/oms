<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2018/6/1
 * Time: 1:09
 */

namespace common\components\ueditor;


use kucha\ueditor\Uploader;

class UpyunUploader extends Uploader
{

    protected $fileField; //表单字段

    protected $stateInfo;

    public function __construct($fileField, $config, $type = "upload")
    {
        if ('upyun' == $type) {
            $this->fileField = $fileField;
            $this->saveUpyun();
        } else {
            parent::__construct($fileField, $config, $type);
        }
    }

    protected function saveUpyun()
    {
        $file = $_FILES[$this->fileField];

        $header['Content-Type'] = $file['type'];
        $header['Mkdir'] = 'true';
        $resource = fopen($file['tmp_name'], 'r');
        $savePath = date('/Y/m/') . md5($file['name']) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);

        $upload = app()->imageUpload;
        $upload->preFixPath = 'flow-thumb';
        $result = app()->imageUpload->write($savePath, $resource, $header);
        if (!empty($result)) {
            $this->stateInfo = $this->stateMap[0];
            $this->fileType = $result['x-upyun-file-type'];
            $this->fullName = app()->imageUpload->baseUrl . $savePath;
            $this->fileName = $file['name'];
            $this->oriName = $file['name'];
            $this->fileSize = $file['size'];
        }
    }

}