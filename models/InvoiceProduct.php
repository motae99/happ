<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%invoice_product}}".
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $product_id
 * @property int $quantity
 * @property int $buying_rate
 * @property int $selling_rate
 *
 * @property Invoices $invoice
 * @property Product $product
 */
class InvoiceProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%invoice_product}}';
    }

    /**
     * @inheritdoc
     */
    public $discount;
    public $inventory;
    public $available;

    public function rules()
    {
        return [
            [['product_id', 'quantity', 'buying_rate', 'selling_rate', 'inventory' ], 'required'],
            [['invoice_id', 'product_id', 'quantity', 'buying_rate', 'selling_rate', 'discount'], 'integer'],
            // [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoices::className(), 'targetAttribute' => ['invoice_id' => 'id']],
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
            'invoice_id' => Yii::t('app', 'Invoice ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'quantity' => Yii::t('app', 'Quantity'),
            'buying_rate' => Yii::t('app', 'Buying Rate'),
            'selling_rate' => Yii::t('app', 'Selling Rate'),
            'd_rate' => Yii::t('app', 'Dollar Rate'),
            'stocking_id' => Yii::t('app', 'Stock out'),
            'created_at' => Yii::t('app', 'created at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoices::className(), ['id' => 'invoice_id']);
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
     * @return InvoiceProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InvoiceProductQuery(get_called_class());
    }
}
