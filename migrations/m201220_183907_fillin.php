<?php

use yii\db\Migration;

/**
 * Class m201220_183907_fillin
 */
class m201220_183907_fillin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $namesData = $csv = array_map('str_getcsv', file(__DIR__ . '/../data/names.csv'));
        $names = array_column(array_slice($namesData, 1), 1);

        $this->insert('user', [
            'name' => 'System'
        ]);
        $this->insert('wallet', [
            'user_id' => 1,
            'amount' => 0
        ]);

        foreach ($names as $name) {
            $this->insert(
                'user',
                [
                    'name' => $name,
                    'password' => md5($name),
                    'auth_key' => \Yii::$app->security->generateRandomString()
                ]
            );

            $this->insert(
                'wallet',
                [
                    'user_id' => Yii::$app->db->getLastInsertID(),
                    'amount' => rand(150, 950)
                ]
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}
