<?php

namespace api\common\models;

class Product extends \api\components\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{product}}';
	}

	public function fields()
    {
        return [
            'id',
            'category' => function($model) { return $model->category->name; },
            'no',
            'product_name',
            'description',
            'buying_price',
            'selling_price',
            'percentage',
            'minimum',
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
         
    }

	public static function find() {
		return new ProductQuery(get_called_class());
	}
}

class ProductQuery extends \api\components\db\ActiveQuery
{
}