<?php

namespace app\models;

use Yii;




class Calender extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calender';
    }

    /**
     * {@inheritdoc}
     */


    // public function rules()
    // {
    //     return [
    //         [[ 'clinic_id', 'date', 'from_time', 'to_time', 'appointment_fee', 'revisiting_fee', 'max'], 'required'],
    //         [['physician_id', 'clinic_id', 'max', 'created_by', 'updated_by'], 'integer'],
    //         [['date', 'from_time', 'to_time', 'created_at', 'updated_at'], 'safe'],
    //         [['appointment_fee', 'revisiting_fee'], 'number'],
    //         [['status'], 'string'],
    //         [['physician_id'], 'exist', 'skipOnError' => true, 'targetClass' => Physician::className(), 'targetAttribute' => ['physician_id' => 'id']],
    //         [['clinic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clinic::className(), 'targetAttribute' => ['clinic_id' => 'id']],
    //     ];
    // }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'availability_id' => Yii::t('app', 'availability_id'),
            'physician_id' => Yii::t('app', 'Availability ID'),
            'clinic_id' => Yii::t('app', 'Clinic ID'),
            'day' => Yii::t('app', 'Day'),
            'date' => Yii::t('app', 'Date'),
            'start_time' => Yii::t('app', 'start Time'),
            'end_time' => Yii::t('app', 'end Time'),
            'current_count' => Yii::t('app', 'Current Count'),
        ];
    }

    public function getClinic()
    {
        return $this->hasOne(Clinic::className(), ['id' => 'clinic_id']);
    }

    public function getDoctor()
    {
        return $this->hasOne(Physician::className(), ['id' => 'physician_id']);
    }

    /**
     * {@inheritdoc}
     * @return CalenderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CalenderQuery(get_called_class());
    }
}
