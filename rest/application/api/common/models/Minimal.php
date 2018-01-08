<?php

namespace api\common\models;

class Minimal extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{minimal}}';
	}

	public function fields()
    {
        return [
            'id',
            'inventory' => function($model) { return $model->stock->inventory->name; },
            'item' => function($model) { return $model->stock->product_name; },
            'quantity',
            // 'recivableAccountNO' => function($model) { return $model->recivable->id; },
            // 'obening' => 
            // 'balance' => Yii::t('app', 'Existing Balance'),
            // 'color_class' => Yii::t('app', 'Color'),
            // 'balance' => Yii::t('app', 'balance'),
            // 'clear' => Yii::t('app', 'Clear'),
        ];
    }

	public function getStock()
    {
        $stock = $this->hasOne(Stock::className(), ['id' => 'stock_id']);
        return $stock ; 
    }

	public static function find() {
		return new MinimalQuery(get_called_class());
	}
}

class MinimalQuery extends \api\components\db\ActiveQuery
{
}	