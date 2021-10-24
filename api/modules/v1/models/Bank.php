<?php
namespace api\modules\v1\models;
use \yii\db\ActiveRecord;
/**
 * Bank Model
 */
class Bank extends ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'transaction_bank';
	}

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'name', 'money'], 'required']
        ];
    }
}
