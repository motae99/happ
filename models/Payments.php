<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%payments}}".
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $system_account_id
 * @property string $amount
 * @property string $mode
 * @property string $bank_name
 * @property int $cheque_no
 * @property string $cheque_date
 * @property string  * @property string $created_at
 *
 * @property Invoices $invoice
 * @property SystemAccount $systemAccount
 */
class Payments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%payments}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invoice_id', 'system_account_id', 'amount'], 'required'],
            [['invoice_id', 'system_account_id', 'cheque_no'], 'integer'],
            [['amount'], 'number'],
            [['mode'], 'string'],
            [['cheque_date', 'created_at'], 'safe'],
            [['bank_name'], 'string', 'max' => 45],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoices::className(), 'targetAttribute' => ['invoice_id' => 'id']],
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
            'invoice_id' => Yii::t('app', 'Invoice ID'),
            'system_account_id' => Yii::t('app', 'System Account ID'),
            'amount' => Yii::t('app', 'Amount'),
            'mode' => Yii::t('app', 'Mode'),
            'bank_name' => Yii::t('app', 'Bank Name'),
            'cheque_no' => Yii::t('app', 'Cheque No'),
            'cheque_date' => Yii::t('app', 'Cheque Date'),
            'transaction_id' => Yii::t('app', 'Transaction ID'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoices::className(), ['id' => 'invoice_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSystemAccount()
    {
        return $this->hasOne(SystemAccount::className(), ['id' => 'system_account_id']);
    }

    public function getTransaction()
    {
        return $this->hasOne(Transaction::className(), ['id' => 'transaction_id']);
    }

    /**
     * @inheritdoc
     * @return PaymentsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PaymentsQuery(get_called_class());
    }
}
