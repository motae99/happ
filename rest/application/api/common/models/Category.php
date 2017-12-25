<?php

namespace api\common\models;

class Category extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{category}}';
	}

	public static function find() {
		return new CategoryQuery(get_called_class());
	}
}

class CategoryQuery extends \api\components\db\ActiveQuery
{
}