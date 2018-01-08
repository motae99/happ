<?php

namespace api\common\models;

class Stock extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{stock}}';
	}

	public function fields()
    {
        return [
            'product_name',
            'highest_rate',
            'quantity',
            // 'avg_cost'=> function($model) { return round($model->avg_cost ,4); },
            'selling_price' => function($model) { return round($model->product->selling_price ,4); },
           
        ];
    }

	public function getInventory()
    {
        $inventory = $this->hasOne(Inventory::className(), ['id' => 'inventory_id']);
        return $inventory ; 
    }

    public function getProduct()
    {
        $product = $this->hasOne(Product::className(), ['id' => 'product_id']);
        return $product ; 
    }

	public static function find() {
		return new StockQuery(get_called_class());
	}
}

class StockQuery extends \api\components\db\ActiveQuery
{
}