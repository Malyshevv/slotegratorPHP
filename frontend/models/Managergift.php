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
                        adress_user.id as id,
                        adress_user.userhasgift_id as userhasgift_id,
                        user_has_gift.send as status,
                        user.username as name,
                        adress_user.address as adress")
                        ->from('adress_user')
                        ->leftJoin('user' , 'user.id = adress_user.id_user')
                        ->leftJoin('user_has_gift' , 'user_has_gift.id = adress_user.userhasgift_id')
                        ->createCommand();

      	return $command->queryAll();

      }
}