<?php

namespace api\common\models;

class Vacation extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{vacation}}';
	}

	public static function find() {
		return new VacationQuery(get_called_class());
	}
}

class VacationQuery extends \api\components\db\ActiveQuery
{
}