<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%outstanding}}".
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $client_id
 * @property string $type
 * @property string $amount
 * @property string $due_date
 * @property string $bank
 * @property int $cheque_no
 * @property string $cheque_date
 * @property string $status
 * @property string $created_at
 *
 * @property Invoices $invoice
 * @property SystemAccount $systemAccount
 */
class Outstanding extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%outstanding}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cheque_no', 'cheque_date', 'amount', 'bank', 'due_date'], 'required'],
            [['cheque_no'], 'integer'],
            [['amount'], 'number'],
            [['cheque_date', 'due_date'], 'safe'],
            [['bank'], 'string', 'max' => 45],

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
            'client_id' => Yii::t('app', 'Cient'),
            'amount' => Yii::t('app', 'Amount'),
            'type' => Yii::t('app', 'Type'),
            'bank' => Yii::t('app', 'Bank Name'),
            'cheque_no' => Yii::t('app', 'Cheque No'),
            'cheque_date' => Yii::t('app', 'Cheque Date'),
            'due_date' => Yii::t('app', 'Due Date'),
            'status' => Yii::t('app', 'Status'),
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
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }


    
}
