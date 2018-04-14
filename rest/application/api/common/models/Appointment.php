<?php

namespace api\common\models;

class Appointment extends \api\components\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{appointment}}';
    }

    public function fields()
    {
        return [
            'id',
            'patient_id',
            'patient' => function($model) { return $model->patient->name; },
            'clinic' => function($model) { return $model->clinic->name; },
            'doctor' => function($model) { return $model->doctor->name; },
            'date' => function($model) { return $model->calender->date; },
            'from_time' => function($model) { return $model->calender->start_time; },
            'to_time' => function($model) { return $model->calender->end_time; },
            'queue' => function($model) { return $model->queue($model); },
            'status',
            'stat',
            'fee',
            'insured_fee',
            'insured',
            // 'clinic_id',
            // 'physician_id',
        ];
    }

    public function extraFields() {
        return [
            'schedule' => function($model) { return $model->schedule; },
        ];
    }

    public function getScheduale()
    {
        return $this->hasMany(Schedule::className(), ['id' => 'calender_id']);
    }


    public function getCalender()
    {
        return $this->hasOne(Calender::className(), ['id' => 'calender_id']);
    }

    public function Queue($model)
    {
        $count = Appointment::find()
            ->where(['calender_id' => $model->calender_id])
            ->andWhere(['<', 'confirmed_at', $model->confirmed_at])
            ->count();
        return $count;
    }

    public function getDoctor()
    {
        return $this->hasOne(Physicain::className(), ['id' => 'physician_id']);
    }

    public function getPatient()
    {
        return $this->hasOne(Patient::className(), ['id' => 'patient_id']);
    }

    public function getClinic()
    {
        return $this->hasOne(Medical::className(), ['id' => 'clinic_id']);
    }


    public static function find() {
        return new AppointmentQuery(get_called_class());
    }
}

class AppointmentQuery extends \api\components\db\ActiveQuery
{
}