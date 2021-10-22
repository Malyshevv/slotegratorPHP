<?php

namespace frontend\controllers;

use Yii;

use yii\rest\ActiveController;

class RestController extends ActiveController
{
	public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
             'class' => \yii\filters\Cors::className(),
             'cors' => [
                 'Origin' => ['*'],
                 'Access-Control-Request-Method' => ['GET', 'OPTIONS', 'PATCH', 'POST', 'PUT'],
                 'Access-Control-Request-Headers' => ['Authorization', 'Content-Type'],
                 'Access-Control-Max-Age' => 3600
             ]
         ];

        return $behaviors;
    }

    public function actionIndex() {
    	return ['status' => 'OK'];
    }
}