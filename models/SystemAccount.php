<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%system_account}}".
 *
 * @property int $id
 * @property string $account_no
 * @property string $system_account_name
 * @property int $account_type_id
 * @property string $description
 * @property string $opening_balance
 * @property string $balance
 * @property string $group
 * @property string $to_increase
 * @property string $color_class
 *
 * @property ClientAccount[] $clientAccounts
 * @property Payments[] $payments
 * @property AccountType $accountType
 */
class SystemAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%system_account}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_no', 'system_account_name', 'account_type_id', 'description', 'to_increase'], 'required'],
            [['account_type_id'], 'integer'],
            [['opening_balance', 'balance'], 'number'],
            [['to_increase'], 'string'],
            [['account_no', 'system_account_name', 'group', 'color_class'], 'string', 'max' => 45],
            [['description'], 'string', 'max' => 255],
            [['account_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccountType::className(), 'targetAttribute' => ['account_type_id' => 'id']],
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
            'system_account_name' => Yii::t('app', 'System Account Name'),
            'account_type_id' => Yii::t('app', 'Account Type ID'),
            'description' => Yii::t('app', 'Description'),
            'opening_balance' => Yii::t('app', 'Opening Balance'),
            'balance' => Yii::t('app', 'Balance'),
            'group' => Yii::t('app', 'Group'),
            'to_increase' => Yii::t('app', 'To Increase'),
            'color_class' => Yii::t('app', 'Color Class'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientAccounts()
    {
        return $this->hasMany(ClientAccount::className(), ['system_account_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payments::className(), ['system_account_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountType()
    {
        return $this->hasOne(AccountType::className(), ['id' => 'account_type_id']);
    }

    /**
     * @inheritdoc
     * @return SystemAccountQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SystemAccountQuery(get_called_class());
    }
}
