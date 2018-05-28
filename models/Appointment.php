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

    public $date; // defining virtual attribute
    public $queue; // defining virtual attribute
    public $time; // defining virtual attribute
    public $age; // defining virtual attribute
    public $patientName; // defining virtual attribute
    public $patientPhone; // defining virtual attribute
    public $paiedTo; // defining virtual attribute
    public $provider;

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

    // this method is called after using Video::find()
    // you can set values for your virtual attributes here for example
    public function afterFind()
    {
        parent::afterFind();


        $this->date = $this->calender->date;
        $this->patientName = $this->patient->name;
        $this->patientPhone = $this->patient->contact_no;
        if ($s = $this->scheduale) {
            $this->queue = $s->queue;
            $this->time = $s->schedule_time;
        }else{
            $this->queue =300;
            $this->time ='00:00:00';
            
        }
        // $this->queue = $this->sche($this);
        $this->age = $this->age($this);

        // $registers = User::find('reference')->where('type' => 'doctorRegister')
        // $by = User::findOne($this->confirmed_by)
        if ($this->status == 'confirmed') {
            // $by = User::findOne($this->confirmed_by);
            // if ($by->type == 'app') {
                $this->paiedTo = 'app';
        //     }else{
        //         $this->paiedTo = 'registers';
        //     }
        // }
        // else{
        //     $this->paiedTo = 'NA';
        }
        

        
    }

    public function Age($model){
        if ($model->patient->dob) {
            //explode the date to get month, day and year
            // $birthDate = explode("/", $model->patient->dob);
            // //get age from date or birthdate
            // $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
            // ? ((date("Y") - $birthDate[2]) - 1)
            // : (date("Y") - $birthDate[2]));
            $age = date_diff(date_create($model->patient->dob), date_create('now'))->y;
            return $age;
        }else{
            return 50;
        }
    }

    public function getCalender()
    {
        return $this->hasOne(Calender::className(), ['id' => 'calender_id']);
    }

    public function getScheduale()
    {   
        return $this->hasOne(Schedule::className(), ['appointment_id' => 'id']);
    }


    // public function sche($model)
    // {
    //     $s = Schedule::find()->where(['calender_id' => $model->calender_id, 'appointment_id' => $model->id])->one();
    //     if ($s) {
    //         return $s->queue;
    //     }else{
    //         return 500;
    //     }
    // }


    public function getDoctor()
    {
        return $this->hasOne(Physician::className(), ['id' => 'physician_id']);
    }

    public function getInsurance()
    {
        return $this->hasOne(Insurance::className(), ['id' => 'insurance_id']);
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

    // this method is called right before inserting record to DB
    // after calling save() on model
    // public function beforeSave($insert)
    // {
    //     // if (parent::beforeSave($insert)) {
    //     //     if ($insert) {
    //     //         // if new record is inserted into db
    //     //     } else {
    //     //         // if existing record is updated
    //     //         // you can use something like this 
    //     //         // to prevent updating certain data
    //     //         // $this->status = $this->oldAttributes['status'];
    //     //     }

    //     //     $this->start_time = $this->video_date . ' '. $this->video_time;

    //     //     return true;
    //     // }

    //     // return false;
    // }
    

    /**
     * {@inheritdoc}
     * @return AppointmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppointmentQuery(get_called_class());
    }
}
