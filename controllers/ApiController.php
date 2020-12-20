<?php

namespace app\controllers;

use app\apiModels\ApiHandler;
use app\apiModels\Login;
use yii\web\Controller;

class ApiController extends Controller
{
    public function actionLogin()
    {
        $handler = new ApiHandler();
        $handler->assignModel(new Login());
        $handler->getResponse();
    }

    public function actionPay()
    {
        $handler = new ApiHandler();
        $handler->assignModel(new Payment());
        $handler->authenticate();
        $handler->getResponse();
    }
}
