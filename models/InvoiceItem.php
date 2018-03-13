<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior; 


/**
 * This is the model class for table "invoice_item".
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $drug_id
 *
 * @property Drugs $drug
 * @property Invoice $invoice
 */
class InvoiceItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoice_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['invoice_id', 'drug_id'], 'required'],
            [['invoice_id', 'drug_id'], 'integer'],
            [['drug_id'], 'exist', 'skipOnError' => true, 'targetClass' => Drugs::className(), 'targetAttribute' => ['drug_id' => 'id']],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoice::className(), 'targetAttribute' => ['invoice_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'invoice_id' => Yii::t('app', 'Invoice ID'),
            'drug_id' => Yii::t('app', 'Drug ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrug()
    {
        return $this->hasOne(Drugs::className(), ['id' => 'drug_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['id' => 'invoice_id']);
    }

    /**
     * {@inheritdoc}
     * @return InvoiceItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InvoiceItemQuery(get_called_class());
    }
}
