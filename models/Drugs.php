<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "drugs".
 *
 * @property int $id
 * @property string $product_name
 * @property string $description
 * @property string $no
 *
 * @property InvoiceItem[] $invoiceItems
 * @property Stock[] $stocks
 */
class Drugs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'drugs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_name', 'quantity', 'price'], 'required'],
            [['description', 'no', 'quantity', 'price'], 'string'],
            [['product_name'], 'string', 'max' => 45],
            [['created_at', 'created_by', 'updated_at', 'updated_by', 'phar_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'phar_id' => Yii::t('app', 'phar_id'),
            'product_name' => Yii::t('app', 'Product Name'),
            'description' => Yii::t('app', 'Description'),
            'quantity' => Yii::t('app', 'quantity'),
            'price' => Yii::t('app', 'price'),
            'created_at' => Yii::t('app', 'created_at'),
            'created_by' => Yii::t('app', 'created_by'),
            'updated_by' => Yii::t('app', 'updated_by'),
            'updated_at' => Yii::t('app', 'updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoiceItems()
    {
        return $this->hasMany(InvoiceItem::className(), ['drug_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStocks()
    {
        return $this->hasMany(Stock::className(), ['drug_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return DrugsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DrugsQuery(get_called_class());
    }
}
