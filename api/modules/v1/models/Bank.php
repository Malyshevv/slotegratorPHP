<?php
namespace api\modules\v1\models;

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
}
