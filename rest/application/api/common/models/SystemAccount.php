<?php

namespace api\common\models;

class SystemAccount extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{system_account}}';
	}

	public static function find() {
		return new SystemAccountQuery(get_called_class());
	}
}

class SystemAccountQuery extends \api\components\db\ActiveQuery
{
}