<?php

namespace app\apiModels;

class Payment extends SecureModel implements ApiModelInterface
{
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
            'success' =>
        ];
    }

    public function
}
