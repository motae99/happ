<?php


namespace api\common\models;

class Client extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{client}}';
	}

	public static function find() {
		return new ClientQuery(get_called_class());
	}
}

class ClientQuery extends \api\components\db\ActiveQuery
{
}