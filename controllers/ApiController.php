<?php

namespace app\controllers;

use app\api\Handler;
use app\api\models\Login;
use app\api\models\Pay;
use yii\web\Controller;

class ApiController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    '*' => ['POST']
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionLogin()
    {
        Handler::processAndSendResponse(new Login());
    }

    public function actionPay()
    {
        Handler::processAndSendResponse(new Pay());
    }
}
