<?php

namespace lingyin\admin\controllers;

use backend\base\Controller;
use lingyin\admin\models\vo\PartnerForm;

class PartnerController extends Controller
{

    public function actionIndex()
    {

        $model = new PartnerForm();
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionAdd()
    {

    }

}