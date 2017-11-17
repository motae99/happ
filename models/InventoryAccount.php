<?php

namespace app\models;

use Yii;

class InventoryAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%inventory_account}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['system_account_id', 'id', 'inventory_id'], 'integer'],
            [['system_account_id'], 'exist', 'skipOnError' => true, 'targetClass' => SystemAccount::className(), 'targetAttribute' => ['system_account_id' => 'id']],
            [['inventory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Inventory::className(), 'targetAttribute' => ['inventory_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'account_no' => Yii::t('app', 'Account No'),
            'inventory_id' => Yii::t('app', 'inventory Id Name'),
            'system_account_id' => Yii::t('app', 'System Account ID'),
            'opening_balance' => Yii::t('app', 'Opening Balance'),
            'balance' => Yii::t('app', 'Balance'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSystemAccount()
    {
        return $this->hasOne(SystemAccount::className(), ['id' => 'system_account_id']);
    }

     public function getInventory()
    {
        return $this->hasOne(Inventory::className(), ['id' => 'inventory_id']);
    }


    // public static function find()
    // {
    //     return new InventoryAccountQuery(get_called_class());
    // }
}
