<?php

namespace api\common\models;

class Financial extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{financial}}';
	}

	public static function find() {
		return new FinancialQuery(get_called_class());
	}
}

class FinancialQuery extends \api\components\db\ActiveQuery
{
}