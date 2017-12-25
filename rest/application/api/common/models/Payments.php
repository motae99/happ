<?php

namespace api\common\models;

class Payments extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{payments}}';
	}

	public static function find() {
		return new PaymentsQuery(get_called_class());
	}
}

class PaymentsQuery extends \api\components\db\ActiveQuery
{
}