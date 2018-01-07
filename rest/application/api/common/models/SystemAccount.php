<?php

namespace api\common\models;

class SystemAccount extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{system_account}}';
	}
 	// public function fields()
  //   {
  //       return [
  //           'id',
            
  //           // 'obening' => 
  //           // 'balance' => Yii::t('app', 'Existing Balance'),
  //           // 'color_class' => Yii::t('app', 'Color'),
  //           // 'balance' => Yii::t('app', 'balance'),
  //           // 'clear' => Yii::t('app', 'Clear'),
  //       ];
  //   }

	public static function find() {
		return new SystemAccountQuery(get_called_class());
	}
}

class SystemAccountQuery extends \api\components\db\ActiveQuery
{
}