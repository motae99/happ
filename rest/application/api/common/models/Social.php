<?php

namespace api\common\models;

class Social extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{social}}';
	}

	public static function find() {
		return new SocialQuery(get_called_class());
	}
}

class SocialQuery extends \api\components\db\ActiveQuery
{
}