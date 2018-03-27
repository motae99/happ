<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;


/**
 * This is the model class for table "availability".
 *
 * @property int $id
 * @property int $physician_id
 * @property int $clinic_id
 * @property string $date
 * @property string $from_time
 * @property string $to_time
 * @property string $appointment_fee
 * @property string $revisiting_fee
 * @property int $max
 * @property string $status
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 *
 * @property Physician $physician
 * @property Clinic $clinic
 * @property InsuranceAcceptance[] $insuranceAcceptances
 */
class Availability extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'availability';
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

    public $duration ;
    public function rules()
    {
        return [
            [[ 'clinic_id', 'date', 'from_time', 'to_time', 'appointment_fee', 'revisiting_fee', 'max', 'duration'], 'required'],
            [['physician_id', 'clinic_id', 'max', 'created_by', 'updated_by'], 'integer'],
            [['date', 'from_time', 'to_time', 'created_at', 'updated_at'], 'safe'],
            [['appointment_fee', 'revisiting_fee', 'duration'], 'number'],
            [['status'], 'string'],
            [['physician_id'], 'exist', 'skipOnError' => true, 'targetClass' => Physician::className(), 'targetAttribute' => ['physician_id' => 'id']],
            [['clinic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clinic::className(), 'targetAttribute' => ['clinic_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'physician_id' => Yii::t('app', 'Physician ID'),
            'clinic_id' => Yii::t('app', 'Clinic ID'),
            'date' => Yii::t('app', 'Date'),
            'from_time' => Yii::t('app', 'From Time'),
            'to_time' => Yii::t('app', 'To Time'),
            'appointment_fee' => Yii::t('app', 'Appointment Fee'),
            'revisiting_fee' => Yii::t('app', 'Revisiting Fee'),
            'max' => Yii::t('app', 'Max'),
            'duration' => Yii::t('app', 'duration'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhysician()
    {
        return $this->hasOne(Physician::className(), ['id' => 'physician_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClinic()
    {
        return $this->hasOne(Clinic::className(), ['id' => 'clinic_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInsuranceAcceptances()
    {
        return $this->hasMany(InsuranceAcceptance::className(), ['availability_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return AvailabilityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AvailabilityQuery(get_called_class());
    }
}
