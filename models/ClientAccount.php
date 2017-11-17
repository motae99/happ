<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%client_account}}".
 *
 * @property int $id
 * @property string $account_no
 * @property string $client_account_name
 * @property int $system_account_id
 * @property string $description
 * @property string $opening_balance
 * @property string $balance
 *
 * @property SystemAccount $systemAccount
 */
class ClientAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%client_account}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_no', 'client_account_name', 'system_account_id'], 'required'],
            [['system_account_id'], 'integer'],
            [['opening_balance', 'balance'], 'number'],
            [['account_no', 'client_account_name'], 'string', 'max' => 45],
            [['description'], 'string', 'max' => 255],
            [['system_account_id'], 'exist', 'skipOnError' => true, 'targetClass' => SystemAccount::className(), 'targetAttribute' => ['system_account_id' => 'id']],
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
            'client_account_name' => Yii::t('app', 'Client Account Name'),
            'system_account_id' => Yii::t('app', 'System Account ID'),
            'description' => Yii::t('app', 'Description'),
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

    /**
     * @inheritdoc
     * @return ClientAccountQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClientAccountQuery(get_called_class());
    }
}
