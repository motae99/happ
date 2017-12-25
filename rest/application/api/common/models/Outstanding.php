<?php

namespace api\common\models;

class Outstanding extends \api\components\db\ActiveRecord
{

	public static function tableName()
	{
		return '{{outstanding}}';
	}

	public static function find() {
		return new OutstandingQuery(get_called_class());
	}
}

class OutstandingQuery extends \api\components\db\ActiveQuery
{
}