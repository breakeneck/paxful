<?php

namespace app\controllers;

use app\api\Handler;
use app\api\models\Login;
use app\api\models\Payment;
use yii\web\Controller;

class ApiController extends Controller
{
    public function actionLogin()
    {
        Handler::processAndSendResponse(new Login());
    }

    public function actionPay()
    {
        Handler::processAndSendResponse(new Payment());
    }
}
