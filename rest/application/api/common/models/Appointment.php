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
            'status',
            'stat',
            'fee',
            'insured_fee',
            'insured',
            // 'clinic_id',
            // 'physician_id',
        ];
    }
    // $app->user_id= 1;
    // $app->patient_id= $patient->id;
    // $app->clinic_id= $clinic_id;
    // $app->physician_id= $doctor_id;
    // $app->availability_id = $availability->id;
    // $app->calender_id= $cal->id;
    // $app->fee = $availability->appointment_fee;
    // $app->insured = 'yes';
    // $app->insured_fee = $insurance_available->patient_payment;
    // // $app->created_at = new \yii\db\Expression('NOW()');
    // $app->status = 'booked';
    // $app->stat = 'schadueled';
    // $app->save(false);

    public function getCalender()
    {
        return $this->hasOne(Calender::className(), ['id' => 'calender_id']);
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