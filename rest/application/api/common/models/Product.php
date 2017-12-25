<?php

namespace api\common\models;

class Product extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{product}}';
	}

	public static function find() {
		return new ProductQuery(get_called_class());
	}
}

class ProductQuery extends \api\components\db\ActiveQuery
{
}