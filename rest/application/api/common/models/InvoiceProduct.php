<?php


namespace api\common\models;

class InvoiceProduct extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{invoice_product}}';
	}

	public static function find() {
		return new InvoiceProductQuery(get_called_class());
	}
}

class InvoiceProductQuery extends \api\components\db\ActiveQuery
{
}