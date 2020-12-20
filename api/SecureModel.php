<?php

namespace app\api;

class SecureModel extends \yii\base\Model implements SecureModelInterface
{
    public $access_token;
    private $user;

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->authenticate();
    }

    public function rules()
    {
        return [
            ['access_token', 'safe'],
        ];
    }

    public function authenticate()
    {
        $this->user = \Yii::$app->user->loginByAccessToken($this->access_token);
        return $this->user;
    }

    public function getAuthenticatedUserId()
    {
        return $this->user->getId();
    }
}
