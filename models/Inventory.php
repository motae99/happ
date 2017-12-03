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
    public $item;
    public $from;
    public $to;
    public $quantity;
    public function rules()
    {
        return [
            [['name', 'color_class', 'alias', 'address', 'phone_no'], 'required'],
            [['item', 'from', 'to', 'quantity'], 'required'],
            [['item', 'from', 'to', 'quantity'], 'integer'],
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
            'id' => Yii::t('inventory', 'ID'),
            'name' => Yii::t('inventory', 'Name'),
            'alias' => Yii::t('inventory', 'Alias'),
            'address' => Yii::t('inventory', 'Address'),
            'phone_no' => Yii::t('inventory', 'Phone No'),
            'asset_account_id' => Yii::t('inventory', 'asset_account_id'),
            'expense_account_id' => Yii::t('inventory', 'account_group'),
            'color_class' => Yii::t('inventory', 'color_class'),
            'created_at' => Yii::t('inventory', 'created_at'),
            'updated_at' => Yii::t('inventory', 'updated_at'),
            'created_by' => Yii::t('inventory', 'created_by'),
            'updated_by' => Yii::t('inventory', 'updated_by'),
            'item' => Yii::t('inventory', 'item'),
            'from' => Yii::t('inventory', 'from'),
            'to' => Yii::t('inventory', 'to'),
            'quantity' => Yii::t('inventory', 'quantity'),
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
        return $this->hasOne(SystemAccount::className(), ['id' => 'asset_account_id']);
    }

    public function getExpense()
    {
        return $this->hasOne(SystemAccount::className(), ['id' => 'expense_account_id']);
    }

    public function getInvoices()
    {
        return $this->hasMany(Invoices::className(), ['inventory_id' => 'id']);
    }

    public function getInvoicesCount()
    {
        return $this->hasMany(Invoices::className(), ['inventory_id' => 'id'])->count();
    }

    public function getStocksCount()
    {
        return $this->hasMany(Stock::className(), ['inventory_id' => 'id'])->count();
    }


    
    public static function find()
    {
        return new InventoryQuery(get_called_class());
    }
}
