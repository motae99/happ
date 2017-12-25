<?php

namespace api\common\models;

class Minimal extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{minimal}}';
	}

	public static function find() {
		return new MinimalQuery(get_called_class());
	}
}

class MinimalQuery extends \api\components\db\ActiveQuery
{
}	