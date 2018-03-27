<?php

namespace app\models;

use Yii;




class Schedule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'schedule';
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
            'calender_id' => Yii::t('app', 'calender ID'),
            'schedule_time' => Yii::t('app', 'schedule_time'),
            'queue' => Yii::t('app', 'queue'),
            'status' => Yii::t('app', 'status'),
            'appointment_id' => Yii::t('app', 'appointment_id'),
        ];
    }

    

    /**
     * {@inheritdoc}
     * @return ScheduleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ScheduleQuery(get_called_class());
    }
}
