<?php

namespace app\api\models;

use app\models\Wallet;

class Pay extends \app\api\SecureModel implements \app\api\ModelInterface, \app\api\SecureModelInterface
{
    const SUCCESS = 'success';

    public $dest_user_id;
    public $amount;

    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                [['dest_user_id'], 'number']
            ]);
    }

    public function response()
    {
        return [
            'result' => $this->pay()
        ];
    }

    private function pay()
    {
        $service = new \app\services\Payment();
        $service->setUsersFromApiModel($this);
        if ($service->pay($this->amount)) {
            return self::SUCCESS;
        }
    }
}
