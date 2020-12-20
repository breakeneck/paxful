<?php

namespace app\apiModels;


use yii\base\Model;

class ApiHandler
{
    /** @var Model */
    private $model;

    private function parseRequest()
    {
        return json_decode(\Yii::$app->request->rawBody);
    }

    public function assignModel($model)
    {
        $this->model = $model;
        $this->model->setAttributes($this->parseRequest());

        if ($model instanceof SecureModel) {
            if (! $this->model->authenticate()) {
                throw new \Exception('Wrong access token');
            }
        }
    }

    public function getResponse()
    {
        try {
            self::format($this->model->response());
        }
        catch (\Exception $exception) {
            self::format([
                'error' => $exception->getMessage()
            ]);
        }
    }

    private function format($response)
    {
        echo json_encode($response);
    }

    public function authenticate()
    {
        if ($this->model instanceof SecureModel) {
            return $this->model->authenticate();
        }

        throw new \Exception("Current action is not require authentication");
    }
}
