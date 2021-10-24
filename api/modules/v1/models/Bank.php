<?php
namespace api\modules\v1\models;
use Yii;
/**
 * Bank Model
 *
 **/
class Bank extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{

		return 'transaction_bank';
	}

    public static function sendMoney() 
    {
        return $_GET;
    }
}
