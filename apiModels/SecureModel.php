<?php

namespace app\apiModels;


class SecureModel extends \yii\base\Model
{
    public $access_token;

    public function rules()
    {
        return [
            ['access_token', 'safe'],
        ];
    }

    public function authenticate()
    {
        return \Yii::$app->user->loginByAccessToken($this->access_token);
    }
}
