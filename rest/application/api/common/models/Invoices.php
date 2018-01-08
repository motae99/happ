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

	public function fields()
    {
        return [
            'id',
            'client_name'=> function($model) { return $model->client->client_name; },
            'total' => function($model) { return $model->amount; },
            'cost',
            'discount',
            'status',
            'date',
           
        ];
    }
    public function extraFields() {
        return [
            'payments' => function($model) { return $model->payments; },
            'outstanding' => function($model) { return $model->outstanding; }
            // 'items' => function($model) { return $model->item; }
        ];
    }

    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
        
    }

    public function getPayments()
    {
        return $this->hasOne(Payments::className(), ['invoice_id' => 'id']);
        
    }

    public function getOutstanding()
    {
        return $this->hasOne(Outstanding::className(), ['invoice_id' => 'id']);
        
    }


	public static function find() {
		return new InvoicesQuery(get_called_class());
	}
}

class InvoicesQuery extends \api\components\db\ActiveQuery
{
}