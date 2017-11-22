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
            [['name', 'color_class', 'alias', 'address', 'phone_no'], 'required'],
            [['address'], 'safe'],
            [['phone_no'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['alias'], 'string', 'max' => 3],
            [['phone_no'], 'string', 'max' => 10],
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
            'alias' => Yii::t('app', 'Alias'),
            'address' => Yii::t('app', 'Address'),
            'phone_no' => Yii::t('app', 'Phone No'),
            'asset_account_id' => Yii::t('app', 'asset_account_id'),
            'expense_account_id' => Yii::t('app', 'account_group'),
            'color_class' => Yii::t('app', 'color_class'),
            'created_at' => Yii::t('app', 'created_at'),
            'updated_at' => Yii::t('app', 'updated_at'),
            'created_by' => Yii::t('app', 'created_by'),
            'updated_by' => Yii::t('app', 'updated_by'),
        ];
    }

    public function getStocks()
    {
        return $this->hasMany(Stock::className(), ['inventory_id' => 'id']);
    }

    public function getStockings()
    {
        return $this->hasMany(Stocking::className(), ['inventory_id' => 'id']);
    }

    public function getAsset()
    {
        return $this->hasOne(SystemAccount::className(), ['asset_account_id' => 'id']);
    }

    public function getEspense()
    {
        return $this->hasOne(SystemAccount::className(), ['expense_account_id' => 'id']);
    }

    public function getInvoices()
    {
        return $this->hasMany(Invoices::className(), ['inventory_id' => 'id']);
    }



    
    public static function find()
    {
        return new InventoryQuery(get_called_class());
    }
}
