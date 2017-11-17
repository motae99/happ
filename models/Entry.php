<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%entry}}".
 *
 * @property int $id
 * @property int $transaction_id
 * @property int $account_id
 * @property string $is_depit
 * @property double $amount
 * @property string $description
 * @property string $date
 * @property string $timestamp
 * @property string $balance
 *
 * @property Transaction $transaction
 */
class Entry extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%entry}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transaction_id', 'account_id', 'amount', 'date'], 'required'],
            [['transaction_id', 'account_id'], 'integer'],
            [['is_depit'], 'string'],
            [['amount', 'balance'], 'number'],
            [['date', 'timestamp'], 'safe'],
            [['description'], 'string', 'max' => 100],
            [['transaction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Transaction::className(), 'targetAttribute' => ['transaction_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'transaction_id' => Yii::t('app', 'Transaction ID'),
            'account_id' => Yii::t('app', 'Account ID'),
            'is_depit' => Yii::t('app', 'Is Depit'),
            'amount' => Yii::t('app', 'Amount'),
            'description' => Yii::t('app', 'Description'),
            'date' => Yii::t('app', 'Date'),
            'timestamp' => Yii::t('app', 'Timestamp'),
            'balance' => Yii::t('app', 'Balance'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaction()
    {
        return $this->hasOne(Transaction::className(), ['id' => 'transaction_id']);
    }

    /**
     * @inheritdoc
     * @return EntryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EntryQuery(get_called_class());
    }
}
