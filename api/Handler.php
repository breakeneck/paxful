<?php

namespace app\api;


class Handler
{
    public static function processAndSendResponse(ModelInterface $model)
    {
        try {
            $model->attributes = self::getAttributesFromRequest();

            if ($model instanceof SecureModelInterface) {
                if (! $model->authenticate()) {
                    throw new \Exception('Access token error');
                }
            }

            self::sendResponse($model->response());
        }
        catch (\Exception $exception) {
            self::sendResponse([
                'error' => $exception->getMessage()
            ]);
        }
    }

    private static function getAttributesFromRequest()
    {
        return json_decode(\Yii::$app->request->rawBody);
    }

    public static function sendResponse($response)
    {
        echo self::format($response);
    }

    private static function format($response)
    {
        return json_encode($response);
    }
}
