<?php

namespace app\api\models;

use yii\base\Model;

class Login extends Model implements \app\api\ModelInterface
{
    public $username;
    public $password;

    public function rules()
    {
        return [
            [['username', 'password'], 'safe']
        ];
    }

    public function response()
    {
        return [
            'access_token' => $this->getAccessToken()
        ];
    }

    private function getAccessToken()
    {
        $user = $this->getUser();
        $user->access_token = \Yii::$app->security->generateRandomString();
        $user->save();

        return $user->access_token;
    }

    private function getUser()
    {
        $user = \app\models\User::findOne(['name' => $this->username]);
        if ($user && $user->validatePassword($this->password)) {
            return $user;
        }
        throw new \Exception('Wrong username or password');
    }
}

