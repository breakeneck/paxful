<?php

namespace app\services\Payment;

use app\models\Transaction;
use app\models\User;

class Payment
{
    const COMMISSION_PERCENT = 1.5;
    const SYSTEM_USER_ID = 1;

    private $source_user_id;
    private $dest_user_id;

    private $amount;
    private $commision;
    private $commisionedAmount;

    public function getSystemUser()
    {
        return User::findOne(['id' => self::SYSTEM_USER_ID]);
    }

    public function setUsersFromApiModel(\app\api\models\Payment $model)
    {
        $this->source_user_id = $model->getAuthenticatedUserId();
        $this->dest_user_id = $model->dest_user_id;
    }

    public function pay($amount)
    {
        $this->setAmount($amount);

        $transaction = $this->getTransactionModel();

        if ($this->payerHasNotEnoughMoney($transaction)) {
            throw new \Exception('Not enough money on wallet');
        }

        $this->updateUsersWallets($transaction);

        $transaction->save();

        return true;
    }

    private function payerHasNotEnoughMoney($transaction)
    {
        return $this->commisionedAmount > $transaction->getSourceUser()->getWallet()->amount;
    }

    private function setAmount($amount)
    {
        $this->commisionedAmount = $amount * self::COMMISSION_PERCENT + $amount;
        $this->commision = $this->commisionedAmount - $amount;
        $this->amount = $amount;
    }

    private function getTransactionModel()
    {
        $transaction = new Transaction();
        $transaction->dest_user_id = $this->dest_user_id;
        $transaction->source_user_id = $this->source_user_id;
        $transaction->amount = $this->amount;
        return $transaction;
    }

    private function updateUsersWallets(Transaction $transaction)
    {
        $commission = $this->commisionedAmount - $this->amount;
        $systemUser = $this->getSystemUser();
        $systemUser->getWallet()->amount += $commission;
        $systemUser->save();

        $transaction->getDestUser()->amount += $this->amount;
        $transaction->getDestUser()->save();

        $transaction->getSourceUser()->amount -= $this->commisionedAmount;
        $transaction->getDestUser()->save();
    }

}
