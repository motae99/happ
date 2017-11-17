<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%stocking}}".
 *
 * @property int $id
 * @property int $inventory_id
 * @property int $product_id
 * @property int $buying_price
 * @property int $selling_price
 * @property int $quantity
 * @property string $created_at
 *
 * @property Inventory $inventory
 * @property Product $product
 */
class Stocking extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%stocking}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['inventory_id', 'product_id', 'buying_price', 'selling_price', 'quantity'], 'required'],
            [['inventory_id', 'product_id', 'buying_price', 'selling_price', 'quantity'], 'integer'],
            [['created_at'], 'safe'],
            [['inventory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Inventory::className(), 'targetAttribute' => ['inventory_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'inventory_id' => Yii::t('app', 'Inventory ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'buying_price' => Yii::t('app', 'Buying Price'),
            'selling_price' => Yii::t('app', 'Selling Price'),
            'quantity' => Yii::t('app', 'Quantity'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventory()
    {
        return $this->hasOne(Inventory::className(), ['id' => 'inventory_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @inheritdoc
     * @return StockingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StockingQuery(get_called_class());
    }
}
