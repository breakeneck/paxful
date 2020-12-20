<?php

use yii\db\Migration;

/**
 * Class m201220_181926_initial
 */
class m201220_181926_initial extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute(<<<EOL
CREATE TABLE `user` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(64),
  `password` VARCHAR(64),
  `auth_key` VARCHAR(64),
  `access_token` VARCHAR(64),
  PRIMARY KEY (`id`)
) ENGINE=INNODB;
EOL
);
        $this->execute(<<<EOL
CREATE TABLE `wallet` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `amount` float DEFAULT 0,
  primary key (`id`),
  INDEX `i_user_id` (`user_id`)
) ENGINE=InnoDB
EOL
);

        $this->execute(<<<EOL
CREATE TABLE `transaction` (  
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `source_user_id` INT(11) NOT NULL,
  `dest_user_id` INT(11) NOT NULL,
  `amount` FLOAT,
  PRIMARY KEY (`id`) ,
  INDEX `c_source_user_id` (`source_user_id`),
  INDEX `c_dest_user_id` (`dest_user_id`)
) ENGINE=INNODB;
EOL
);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}
