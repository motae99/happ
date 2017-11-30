<?php

namespace api\common\models;

class Purchase extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{purchase}}';
	}

	public static function find() {
		return new PurchaseQuery(get_called_class());
	}
}

class PurchaseQuery extends \api\components\db\ActiveQuery
{
}