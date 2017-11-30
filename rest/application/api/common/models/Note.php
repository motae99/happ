<?php

namespace api\common\models;

class Note extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{note}}';
	}

	public static function find() {
		return new NoteQuery(get_called_class());
	}
}

class NoteQuery extends \api\components\db\ActiveQuery
{
}	