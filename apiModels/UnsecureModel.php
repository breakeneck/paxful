<?php

class UnsecureModel extends \yii\base\Model
{
    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->setAttributes()
    }
}
