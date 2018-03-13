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
            [['product_name'], 'required'],
            [['description', 'no'], 'string'],
            [['product_name'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_name' => Yii::t('app', 'Product Name'),
            'description' => Yii::t('app', 'Description'),
            'no' => Yii::t('app', 'No'),
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
