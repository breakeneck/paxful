<?php

namespace app\services;

use app\models\Transaction;
use app\models\User;

class Payment
{
    const COMMISSION_PERCENT = 1.5;
    const SYSTEM_USER_ID = 1;

    private $payer;
    private $receiver;
    private $systemUser;

    private $amount;
    private $commision;
    private $commisionedAmount;

    public function __construct()
    {
        $this->systemUser = User::findOne(['id' => self::SYSTEM_USER_ID]);
    }

    public function setUsersFromApiModel(\app\api\models\Pay $model)
    {
        $this->payer = User::findOne(['id' => $model->getAuthenticatedUserId()]);
        $this->receiver = User::findOne(['id' => $model->dest_user_id]);
    }

    public function pay($amount)
    {
        $this->setAmount($amount);

        if ($this->payerHasNotEnoughMoney()) {
            throw new \Exception('Not enough money on wallet');
        }

        $this->updateUsersWallets();

        $this->createTransaction();

        return true;
    }

    private function payerHasNotEnoughMoney()
    {
        return $this->commisionedAmount > $this->payer->wallet->amount;
    }

    private function setAmount($amount)
    {
        $this->commisionedAmount = $amount * self::COMMISSION_PERCENT + $amount;
        $this->commision = $this->commisionedAmount - $amount;
        $this->amount = $amount;
    }

    private function createTransaction()
    {
        $transaction = new Transaction();
        $transaction->source_user_id = $this->payer->id;
        $transaction->dest_user_id = $this->receiver->id;
        $transaction->amount = $this->amount;
        $transaction->save();
        return $transaction;
    }

    private function updateUsersWallets()
    {
        $this->payer->wallet->amount -= $this->commisionedAmount;
        $this->payer->wallet->save();

        $this->receiver->wallet->amount += $this->amount;
        $this->receiver->wallet->save();

        $this->systemUser->wallet->amount += $this->commision;
        $this->systemUser->wallet->save();
    }

}
