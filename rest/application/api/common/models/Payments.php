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

	public function fields()
    {
        return [
            'invoice_id',
            'amount',
            'mode',
            'bank_name',
            'cheque_no',
            'cheque_date',
            'time'=> function($model) { return $model->created_at; },
           
        ];
    }

	public static function find() {
		return new PaymentsQuery(get_called_class());
	}
}

class PaymentsQuery extends \api\components\db\ActiveQuery
{
}