<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "appointment".
 *
 * @property int $id
 * @property int $user_id
 * @property int $patient_id
 * @property int $clinic_id
 * @property int $physician_id
 * @property int $availability_id
 * @property int $calender_id
 * @property string $fee
 * @property string $insured
 * @property string $insured_fee
 * @property string $status
 * @property string $stat
 * @property string $created_at
 */
class Appointment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'appointment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'patient_id', 'clinic_id', 'physician_id', 'availability_id', 'calender_id', 'fee', 'stat'], 'required'],
            [['user_id', 'patient_id', 'clinic_id', 'physician_id', 'availability_id', 'calender_id'], 'integer'],
            [['fee', 'insured_fee'], 'number'],
            [['insured', 'status', 'stat'], 'string'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'patient_id' => Yii::t('app', 'Patient ID'),
            'clinic_id' => Yii::t('app', 'Clinic ID'),
            'physician_id' => Yii::t('app', 'Physician ID'),
            'availability_id' => Yii::t('app', 'Availability ID'),
            'calender_id' => Yii::t('app', 'Calender ID'),
            'fee' => Yii::t('app', 'Fee'),
            'insured' => Yii::t('app', 'Insured'),
            'insured_fee' => Yii::t('app', 'Insured Fee'),
            'status' => Yii::t('app', 'Status'),
            'stat' => Yii::t('app', 'Stat'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created At'),
            'confirmed_at' => Yii::t('app', 'Created At'),
            'confirmed_by' => Yii::t('app', 'Created At'),
            'canceled_at' => Yii::t('app', 'Created At'),
            'canceled_by' => Yii::t('app', 'Created At'),
        ];
    }

    public function getDoctor()
    {
        return $this->hasOne(Physician::className(), ['id' => 'physician_id']);
    }

     public function insu($av)
    {   
        $accept = InsuranceAcceptance::find()->where(['availability_id' => $av])->one();
        return $accept;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClinic()
    {
        return $this->hasOne(Clinic::className(), ['id' => 'clinic_id']);
    }

    public function getPatient()
    {
        return $this->hasOne(Patient::className(), ['id' => 'patient_id']);
    }

    /**
     * {@inheritdoc}
     * @return AppointmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppointmentQuery(get_called_class());
    }
}
