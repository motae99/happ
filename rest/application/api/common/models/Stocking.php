<?php

namespace api\common\models;

class Stocking extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{stocking}}';
	}

	public static function find() {
		return new StockingQuery(get_called_class());
	}
}

class StockingQuery extends \api\components\db\ActiveQuery
{
}