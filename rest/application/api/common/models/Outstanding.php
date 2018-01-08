<?php

namespace api\common\models;

class Outstanding extends \api\components\db\ActiveRecord
{

	public static function tableName()
	{
		return '{{outstanding}}';
	}

	public function fields()
    {
        return [
            'id',
            'invoice_id',
            'client' => function($model) { return $model->client->client_name; },
            'time' => function($model) { return $model->created_at; },
            'type',
            'amount',
            'cheque_date',
            'cheque_no',
            'bank',
            'due_date',
        ];
    }

	public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
         
    }

	public static function find() {
		return parent::find()->where(['!=', 'status', 'clear']);
	}
}

class OutstandingQuery extends \api\components\db\ActiveQuery
{
}