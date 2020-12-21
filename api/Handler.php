<?php

namespace app\api;


class Handler
{
    public static function processAndSendResponse(ModelInterface $model)
    {
        try {
            $model->setAttributes( self::getAttributesFromRequest() );

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
        return json_decode(\Yii::$app->request->rawBody, true);
    }

    public static function sendResponse($response)
    {
        die(self::format($response));
    }

    private static function format($response)
    {
        return json_encode($response);
    }
}
