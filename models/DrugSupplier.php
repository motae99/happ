<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "drug_supplier".
 *
 * @property int $id
 * @property string $name
 * @property int $contact_no
 * @property string $address
 *
 * @property Stock[] $stocks
 */
class DrugSupplier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'drug_supplier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'contact_no'], 'required'],
            [['contact_no'], 'integer'],
            [['address'], 'string'],
            [['name'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'contact_no' => Yii::t('app', 'Contact No'),
            'address' => Yii::t('app', 'Address'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStocks()
    {
        return $this->hasMany(Stock::className(), ['sup_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return DrugSupplierQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DrugSupplierQuery(get_called_class());
    }
}
