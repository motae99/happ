<?php

namespace api\common\models;

class Dolar extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{dollar}}';
	}

	public static function find() {
		return new DolarQuery(get_called_class());
	}
}

class DolarQuery extends \api\components\db\ActiveQuery
{
}