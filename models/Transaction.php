<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property int $source_user_id
 * @property int $dest_user_id
 * @property float|null $amount
 * @property string $create_time
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['source_user_id', 'dest_user_id'], 'required'],
            [['source_user_id', 'dest_user_id'], 'integer'],
            [['amount'], 'number'],
            [['create_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'source_user_id' => 'Source User ID',
            'dest_user_id' => 'Dest User ID',
            'amount' => 'Amount',
            'create_time' => 'Create Time',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TransactionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TransactionQuery(get_called_class());
    }

    /**
     * @return User
     */
    public function getDestUser()
    {
        return $this->hasOne(User::class, ['id' => 'dest_user_id']);
    }

    /**
     * @return User
     */
    public function getSourceUser()
    {
        return $this->hasOne(User::class, ['id' => 'source_user_id']);
    }
}
