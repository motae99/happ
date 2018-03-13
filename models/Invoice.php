<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior; 


/**
 * This is the model class for table "invoice".
 *
 * @property int $id
 * @property int $insurance_id
 * @property int $insurance_no
 * @property string $name
 * @property int $pharmacy_id
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 *
 * @property PharInsu $insurance
 * @property Pharmacy $pharmacy
 * @property InvoiceItem[] $invoiceItems
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoice';
    }

    public function behaviors()
    {
         return [
             // [
             //     'class' => SluggableBehavior::className(),
             //     'attribute' => 'message',
             //     'immutable' => true,
             //     'ensureUnique'=>true,
             // ],
             [
                 'class' => BlameableBehavior::className(),
                 'createdByAttribute' => 'created_by',
                 'updatedByAttribute' => 'updated_by',
             ],
             'timestamp' => [
                 'class' => 'yii\behaviors\TimestampBehavior',
                 'attributes' => [
                     ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                     ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                 ],
                 'value' => date('Y-m-d H:i:s'),
             ],
         ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['insurance_id', 'insurance_no', 'name', 'pharmacy_id', 'created_at', 'created_by'], 'required'],
            [['insurance_id', 'insurance_no', 'pharmacy_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 45],
            [['insurance_id'], 'exist', 'skipOnError' => true, 'targetClass' => PharInsu::className(), 'targetAttribute' => ['insurance_id' => 'id']],
            [['pharmacy_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pharmacy::className(), 'targetAttribute' => ['pharmacy_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'insurance_id' => Yii::t('app', 'Insurance ID'),
            'insurance_no' => Yii::t('app', 'Insurance No'),
            'name' => Yii::t('app', 'Name'),
            'pharmacy_id' => Yii::t('app', 'Pharmacy ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInsurance()
    {
        return $this->hasOne(PharInsu::className(), ['id' => 'insurance_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPharmacy()
    {
        return $this->hasOne(Pharmacy::className(), ['id' => 'pharmacy_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoiceItems()
    {
        return $this->hasMany(InvoiceItem::className(), ['invoice_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return InvoiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InvoiceQuery(get_called_class());
    }
}
