<?php

namespace frontend\models;
use Yii;

class ManagerGift extends \yii\db\ActiveRecord{


      public static function getGift() {

		if(Yii::$app->user->isGuest) {
                  return false;
            }
		
            $command = (new \yii\db\Query())
                        ->select("
                        user.username as name,
                        adress_user.address as adress")
                        ->from('adress_user')
                        ->leftJoin('user' , 'user.id = adress_user.id_user')
                        ->createCommand();

      	return $command->queryAll();

      }
}