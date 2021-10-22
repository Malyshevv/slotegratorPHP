<?php

namespace frontend\models;
use Yii;

class ProfilePage extends \yii\db\ActiveRecord{

      public static function tableName()
      {
             return 'user'; // Имя таблицы в БД в которой хранятся записи блога
      }

      public static function getAll()
      {		

        if(Yii::$app->user->isGuest) {
            return false;
        }
        
        $id = Yii::$app->user->identity->id;
        $data = self::find()->where('id = :id', [':id' => $id])->one();

        return $data;
      }


      public static function getGift() {
        if(Yii::$app->user->isGuest) {
          return false;
        }
        
      	$id = Yii::$app->user->identity->id;

        $command = (new \yii\db\Query())
          ->select("
            user_has_gift.gift_id as gift_id,
            user_has_gift.quantity as quantity, 
            user_has_gift.send as send, 
            gift.name as name, 
            gift.img as img
          ")
        ->from('user_has_gift')
        ->leftJoin('gift' , 'gift.id = user_has_gift.gift_id')
        ->where(['user_id' => $id])
        ->createCommand();

        return $command->queryAll();

      }
}