<?php

namespace api\common\models;

class Attendance extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{attendance}}';
	}

	public static function find() {
		return new AttendanceQuery(get_called_class());
	}
}

class AttendanceQuery extends \api\components\db\ActiveQuery
{
}