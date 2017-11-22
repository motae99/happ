<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property int $id
 * @property int $category_id
 * @property int $no
 * @property string $product_name
 * @property string $description
 * @property string $buying_price
 * @property string $selling_price
 *
 * @property InvoiceProduct[] $invoiceProducts
 * @property Category $category
 * @property Stock[] $stocks
 * @property Stocking[] $stockings
 */
class Product extends \yii\db\ActiveRecord
{
    
    public static function tableName()
    {
        return '{{%product}}';
    }

    
    public function rules()
    {
        return [
            [['category_id', 'no', 'product_name', 'description', 'buying_price', 'selling_price', 'minimum'], 'required'],
            [['category_id', 'no', 'minimum'], 'integer'],
            [['product_name', 'description', 'buying_price', 'selling_price'], 'string', 'max' => 45],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'no' => Yii::t('app', 'No'),
            'product_name' => Yii::t('app', 'Product Name'),
            'description' => Yii::t('app', 'Description'),
            'buying_price' => Yii::t('app', 'Buying Price'),
            'selling_price' => Yii::t('app', 'Selling Price'),
            'minimum' => Yii::t('app', 'Minimum'),
        ];
    }

    
    public function getInvoiceProducts()
    {
        return $this->hasMany(InvoiceProduct::className(), ['product_id' => 'id']);
    }

    
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    
    public function getStocks()
    {
        return $this->hasMany(Stock::className(), ['product_id' => 'id']);
    }

    
    public function getStockings()
    {
        return $this->hasMany(Stocking::className(), ['product_id' => 'id']);
    }

    
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }
}
