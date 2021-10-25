<?php

namespace api\modules\v1\controllers;
use Yii;
use yii\rest\ActiveController;

/**
 * Bank Controller API
 **/
class BankController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Bank';    

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }

    public static function actionMoneysend() 
    {
        if(isset($_GET['idTransaction']) && isset($_GET['userID'])) {
            $idTransaction = $_GET['idTransaction'];
            $userID = $_GET['userID'];

            $updateTransactionBank = BankController::updateTransactionBank($idTransaction,$userID);
            $updateUser = BankController::updateUser($userID,$idTransaction);

            if($updateTransactionBank && $updateUser) {
                return json_encode(array('result'=>'transaction successfully'));
            } else {
                return json_encode(array('error'=> 'transaction error'));
            }
            
        } else {
            return json_encode(array('error'=>'error get data'));
        }
    }

    public static function updateTransactionBank($idTransaction,$userID) {

         /**получения данных о переводе */
         $commandTransaction = (new \yii\db\Query())
            ->select('id_user,status')
            ->from('transaction_bank')
            ->where(['id' => $idTransaction])
            ->createCommand();
        $dataTransaction = $commandTransaction->queryOne();

        if($dataTransaction['id_user'] == $userID && $dataTransaction['status'] == 0) {
           /**обновления данных о переводе */
            $transaction = Yii::$app->db->beginTransaction();
            $updateQuantity = Yii::$app->db->createCommand()
                ->update('transaction_bank', array('status' => 1),'id = :id', array(':id'=> $idTransaction))
                ->execute();
            if($updateQuantity) {
                $transaction->commit();
                return true;
            } else {
                $transaction->rollback();
                return false;
            }
        } else {
            return false;
        }

    }

    public static function updateUser($userID,$idTransaction) {
        /**получения данных о состоянии счета на сайте */
        $commandUser = (new \yii\db\Query())
            ->select('cash')
            ->from('user')
            ->where(['id' => $userID])
            ->createCommand();
        $dataUser = $commandUser->queryOne();

         /**получения данных о переводе */
        $commandTransaction = (new \yii\db\Query())
            ->select('money, status')
            ->from('transaction_bank')
            ->where(['id' => $idTransaction])
            ->createCommand();
        $dataTransaction = $commandTransaction->queryOne();
        
        if(intval($dataUser['cash']) >= intval($dataTransaction['money']) && $dataTransaction['status'] == 1) {
            $transaction = Yii::$app->db->beginTransaction();
             /**обновления данных у юзера */
            $updateUser = Yii::$app->db->createCommand()
                ->update('user', array('cash' => $dataUser['cash'] - $dataTransaction['money']),'id = :id', array(':id'=> $userID))
                ->execute();
            if($updateUser) {
                $transaction->commit();
                return true;
            } else {
                $transaction->rollback();
                return false;
            }
        } else { 
            return false;
        }
    }

}


