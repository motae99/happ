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
            [['client_name', 'phone'], 'required'],
            [['phone', 'account_id', 'balance'], 'integer'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoices::className(), ['client_id' => 'id']);
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
