<?php

namespace api\common\models;

class Invoices extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{invoices}}';
	}

	public static function find() {
		return new InvoicesQuery(get_called_class());
	}
}

class InvoicesQuery extends \api\components\db\ActiveQuery
{
}