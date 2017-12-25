<?php

namespace api\common\models;

class Inventory extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{inventory}}';
	}

	public static function find() {
		return new InventoryQuery(get_called_class());
	}
}

class InventoryQuery extends \api\components\db\ActiveQuery
{
}