<?php

namespace api\common\models;

class Inventory extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{inventory}}';
	}

	public function fields()
    {
        return [
        	'id',
            'name',
            'alias',
            'address',
            'phone_no',
           
        ];
    }

    public function extraFields() {
        return [
            'stock' => function($model) { return $model->stock; },
        ];
    }

	public function getStock()
    {
        return $this->hasMany(Stock::className(), ['inventory_id' => 'id']);
    }

	public static function find() {
		return new InventoryQuery(get_called_class());
	}
}

class InventoryQuery extends \api\components\db\ActiveQuery
{
}