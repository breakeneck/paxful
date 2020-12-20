<?php

namespace app\api\models;

use app\models\Wallet;

class Payment extends \app\api\SecureModel implements \app\api\ModelInterface, \app\api\SecureModelInterface
{
    const SUCCESS = 'success';

    public $dest_user_id;
    public $amount;

    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                ['dest_user_id', 'numerical']
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
        $service = new \app\services\Payment\Payment();
        $service->setUsersFromApiModel($this);
        if ($service->pay($this->amount)) {
            return self::SUCCESS;
        }
    }
}
