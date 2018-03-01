<?php

namespace api\common\models;

class Medical extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{clinic}}';
	}

	public static function find() {
		return new MedicalQuery(get_called_class());
	}
}

class MedicalQuery extends \api\components\db\ActiveQuery
{
}