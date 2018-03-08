<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "insurance".
 *
 * @property int $id
 * @property string $name
 * @property int $appointment_discount
 * @property int $appointment_cap
 * @property int $drug_discount
 * @property int $drug_cap
 * @property int $surgery_discount
 * @property int $surgery_cap
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 *
 * @property InsuranceAcceptance[] $insuranceAcceptances
 * @property PatientInsurance[] $patientInsurances
 */
class Insurance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'insurance';
    }

    /**
     * {@inheritdoc}
     */

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

    public function rules()
    {
        return [
            [['name', 'appointment_discount', 'drug_discount', 'surgery_discount',], 'required'],
            [['appointment_discount', 'appointment_cap', 'drug_discount', 'drug_cap', 'surgery_discount', 'surgery_cap', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'appointment_discount' => Yii::t('app', 'Appointment Discount'),
            'appointment_cap' => Yii::t('app', 'Appointment Cap'),
            'drug_discount' => Yii::t('app', 'Drug Discount'),
            'drug_cap' => Yii::t('app', 'Drug Cap'),
            'surgery_discount' => Yii::t('app', 'Surgery Discount'),
            'surgery_cap' => Yii::t('app', 'Surgery Cap'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInsuranceAcceptances()
    {
        return $this->hasMany(InsuranceAcceptance::className(), ['insurance_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatientInsurances()
    {
        return $this->hasMany(PatientInsurance::className(), ['patient_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return InsuranceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InsuranceQuery(get_called_class());
    }
}
