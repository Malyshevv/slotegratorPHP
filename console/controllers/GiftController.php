<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class GiftController extends Controller
{

	public $count;

    public function actionIndex($count) {

		$command = (new \yii\db\Query())
			->from('user_has_gift')
			->where(['send' => 0,'gift_id' => 1])
			->limit($count)
			->createCommand();

    	$res = $command->queryAll();

    	foreach ($res as $keyRes) {
    		$id = $keyRes['id'];
    		$idGift = $keyRes['gift_id'];
    		$idUser = $keyRes['user_id'];
    		$quantity = $keyRes['quantity'];

			if($idGift == 1) {
    			$this->setQuantityUser($idUser,$quantity);
			}
			$this->updateStatusSend($id);   			
    		
    	}

        #echo $this->message . "\n";
        echo '==================== Готово! ====================';
    }

	public function updateStatusSend($id) {
		$transaction = Yii::$app->db->beginTransaction();

		$updateStatus = Yii::$app->db->createCommand()
			->update('user_has_gift', array('send' => 1),'id = :id', array(':id'=> $id))
			->execute();

		if($updateStatus) {
			$transaction->commit();
		} else {
			$transaction->rollback();
			return false;
		}
	}

	public function setQuantityUser($idUser,$quantity) {
		$query = (new \yii\db\Query())
			->from('user')
			->where(['id' => $idUser])
			->createCommand();

		$resQuery = $query->queryOne();

    	$cash = $resQuery['cash'];

		$transaction = Yii::$app->db->beginTransaction();

    	$updateCash = Yii::$app->db->createCommand()
			->update('user', array('cash' => $cash + $quantity),'id = :id', array(':id'=> $idUser))
			->execute();

		if($updateCash) { 
			$transaction->commit();
		} else {
			$transaction->rollback();
			return false;
		}
	}
}
