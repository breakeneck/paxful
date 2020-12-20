<?php

use yii\db\Migration;

/**
 * Class m201220_222220_alter_transaction
 */
class m201220_222220_alter_transaction extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('transaction', 'create_time', 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201220_222220_alter_transaction cannot be reverted.\n";

        return false;
    }
}
