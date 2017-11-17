<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%inventory}}".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $account_group
 *
 * @property Stock[] $stocks
 * @property Stocking[] $stockings
 */
class Inventory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%inventory}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'account_group'], 'required'],
            [['address'], 'string'],
            [['name', 'account_group'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'address' => Yii::t('app', 'Address'),
            'account_group' => Yii::t('app', 'account_group'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStocks()
    {
        return $this->hasMany(Stock::className(), ['inventory_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStockings()
    {
        return $this->hasMany(Stocking::className(), ['inventory_id' => 'id']);
    }

    public function getAccount()
    {
        return $this->hasOne(InventoryAccount::className(), ['inventory_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return InventoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InventoryQuery(get_called_class());
    }
}
