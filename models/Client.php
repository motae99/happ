<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%client}}".
 *
 * @property int $id
 * @property string $client_name
 * @property int $phone
 * @property string $address
 * @property int $account_id
 *
 * @property Invoices[] $invoices
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $balance;
    public $clear;

    public static function tableName()
    {
        return '{{%client}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_name', 'phone', 'color_class', 'clear'], 'required'],
            [['phone', 'account_id', 'balance', 'clear'], 'integer'],
            [['address'], 'string'],
            [['client_name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'client_name' => Yii::t('app', 'Client Name'),
            'phone' => Yii::t('app', 'Phone'),
            'address' => Yii::t('app', 'Address'),
            'account_id' => Yii::t('app', 'Account'),
            'balance' => Yii::t('app', 'Existing Balance'),
            'color_class' => Yii::t('app', 'Color'),
            'balance' => Yii::t('app', 'balance'),
            'clear' => Yii::t('app', 'Clear'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoices::className(), ['client_id' => 'id']);
    }

    public function getRecievable()
    {
        return $this->hasOne(SystemAccount::className(), ['id' => 'account_id']);
    }

    public function getPayable()
    {
        return $this->hasOne(SystemAccount::className(), ['id' => 'payable_id']);
    }

    public function getInvoicescount()
    {
        $count = $this->hasMany(Invoices::className(), ['client_id' => 'id'])->count();
        return $count;
    }

    public function getRecievablebalance()
    {
        $account = $this->hasOne(SystemAccount::className(), ['id' => 'account_id']);
        return $account['balance'] ; 
    }

    public function getOpeningbalance()
    {
        $account = $this->hasOne(SystemAccount::className(), ['id' => 'account_id']);
        return $account->opening_balance ; 
    }

    public function getPayablebalance()
    {
        $account = $this->hasOne(SystemAccount::className(), ['id' => 'payable_id']);
        return $account->balance ; 
    }
    /**
     * @inheritdoc
     * @return ClientQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClientQuery(get_called_class());
    }
}
