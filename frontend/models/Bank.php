<?php

namespace frontend\models;
use Yii;

class Bank extends \yii\db\ActiveRecord{


      public static function getBank() {
		
		if(Yii::$app->user->isGuest) {
                  return false;
            }

            $command = (new \yii\db\Query())
                        ->from('transaction_bank')
                        ->orderBy(['id'=> 'SORT ASC'])
                        ->createCommand();

      	return $command->queryAll();

      }
}