<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "insurance_acceptance".
 *
 * @property int $id
 * @property int $availability_id
 * @property int $insurance_id
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 * @property int $updated_by
 *
 * @property Availability $availability
 * @property Insurance $insurance
 */
class InsuranceAcceptance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'insurance_acceptance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['insurance_id', 'patient_payment', 'insurance_refund', 'contract_expiry' ], 'required'],
            [['availability_id', 'insurance_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['availability_id'], 'exist', 'skipOnError' => true, 'targetClass' => Availability::className(), 'targetAttribute' => ['availability_id' => 'id']],
            [['insurance_id'], 'exist', 'skipOnError' => true, 'targetClass' => Insurance::className(), 'targetAttribute' => ['insurance_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'availability_id' => Yii::t('app', 'Availability ID'),
            'insurance_id' => Yii::t('app', 'Insurance ID'),
            'patient_payment' => Yii::t('app', 'patient_payment'),
            'insurance_refund' => Yii::t('app', 'insurance_refund'),
            'contract_expiry' => Yii::t('app', 'contract_expiry'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAvailability()
    {
        return $this->hasOne(Availability::className(), ['id' => 'availability_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInsurance()
    {
        return $this->hasOne(Insurance::className(), ['id' => 'insurance_id']);
    }

    /**
     * {@inheritdoc}
     * @return InsuranceAcceptanceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InsuranceAcceptanceQuery(get_called_class());
    }
}
