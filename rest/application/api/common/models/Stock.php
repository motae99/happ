<?php

namespace api\common\models;

class Stock extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{stock}}';
	}

	public static function find() {
		return new StockQuery(get_called_class());
	}
}

class StockQuery extends \api\components\db\ActiveQuery
{
}