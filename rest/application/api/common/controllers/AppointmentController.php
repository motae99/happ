<?php
namespace api\common\controllers;
use \Yii as Yii;
use api\models\User;
use api\common\models\Medical;
use api\common\models\physicain;
use api\common\models\Specialization;
use api\common\models\InsuranceAcceptance;
use api\common\models\Availability;
use api\common\models\Calender;
use api\common\models\Patient;
use api\common\models\Appointment;
use \Unifonic\API\Client;

use yii\db\Expression;


class AppointmentController extends \api\components\ActiveController
{
    public $modelClass = '\api\common\models\Appointment';

    public function accessRules()
    {
        return [
            [
                'allow' => true,
                'actions' => [
                    'index',
                    'update',
                    'all'
                ],
                'roles' => ['@'],
            ],
            [
                'allow' => true,
                'actions' => [
                    'view',
                    'booking',
                    'reserve',
                ],
                'roles' => ['@'],
            ],
            // [
            //     'allow' => true,
            //     'actions' => ['create', 'delete', 'accept', 'reject', 'only', 'oname'],
            //     'roles' => ['@'],
            //     'scopes' => ['admin'],
            // ],
        ];
    }

    public function actions(){
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['create']);
        unset($actions['update']);
        return $actions;
    }

    public function actionBooking(){
        $user =  Yii::$app->user->identity;
        $body = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        // $model->load($body, '');
        // print_r($body);
        if (isset($body['clinic_id']) && isset($body['doctor_id']) && isset($body['name']) && isset($body['phone_no'])) {
            $clinic_id = $body['clinic_id'];
            $doctor_id = $body['doctor_id'];
            $name = $body['name'];
            $phone_no = $body['phone_no'];
            
        }else{
            return  array('message' => 'fill required fields'); 

        }
        if (isset($body['insurance_id']) && isset($body['insurance_no']) ) {
            $insurance_id = $body['insurance_id'];
            $insurance_no = $body['insurance_no'];
            $insured = true;
            
        }else{
            $insured = false;
        }
        if ($clinic_id && $doctor_id && $name && $phone_no) {
            $existed = Patient::find()->where(['contact_no' => $phone_no])->one();
            if ($existed) {
                $patient = $existed;
            }else{
                $patient = new Patient();
                $patient->name = $name;
                $patient->contact_no = $phone_no;
                //fix later
                // $patient->created_at = new Expression('NOW()');
                $patient->created_by = 1;

                if ($insured) {
                    $patient->has_insurance = 1;
                    $patient->insurance_id = $insurance_id;
                    $patient->insurance_no = $insurance_no;
                    $patient->save(false);
                }else{
                    $patient->has_insurance = 0;
                    $patient->save(false);
                }
            }
            $cal = Calender::find()
                ->where(['clinic_id' => $clinic_id])
                ->andWhere(['physician_id' => $doctor_id])
                ->andWhere(['status' => 'available'])
                ->orderBy(['date' => SORT_ASC])
                ->one();

            if ($cal) {
                $already = Appointment::find()
                            ->where(['calender_id' => $cal])
                            ->andWhere(['patient_id' => $patient->id])
                            ->one();
                if ($already) {
                     return  array('success' => 0 , 'message' => 'already booked'); 
                }
                $availability = Availability::findOne($cal->availability_id);
            // return  array('data' => $availability); 
                
                if ($availability && $insured) {
                    $insurance_available = InsuranceAcceptance::find()
                        ->where(['availability_id' => $availability->id])
                        ->andWhere(['insurance_id' => $insurance_id])
                        ->one();
              // return  array('insurance_available' => $insurance_available); 
                    if ($insurance_available) {
                      // book an appointment with insurance discount 
                        $app = new Appointment();
                        $app->user_id= $user->id;
                        $app->patient_id= $patient->id;
                        $app->clinic_id= $clinic_id;
                        $app->physician_id= $doctor_id;
                        $app->availability_id = $availability->id;
                        $app->calender_id= $cal->id;
                        $app->fee = $availability->appointment_fee;
                        $app->insured = 'yes';
                        $app->insured_fee = $insurance_available->patient_payment;
                        $app->created_at = new Expression('NOW()');
                        $app->status = 'booked';
                        $app->stat = 'schadueled';
                        $app->save(false);

                        $client = new Client();
                        $message = 'تم الحجز المبدئي لك بالرقم '.$app->id.' عليه نرجو تأكيد حجزك بالدفع المالي حتى ﻻ تفقد فرصتك مع تمنياتنا لك بدوام الصحة والعافية';
                        $response = $client->Messages->Send($patient->contact_no, $message);
                        return  array('success' => 1 , 'data' => $app); 
                    
                    }else{
                        // message your insurance is not available
                      return  array('success' => 0 , 'message' => 'message your insurance is not supported'); 
                    }

                }elseif($availability){
                   // book an appointment with no insurance
                    $app = new Appointment();
                    $app->user_id= $user->id;
                    $app->patient_id= $patient->id;
                    $app->clinic_id= $clinic_id;
                    $app->physician_id= $doctor_id;
                    $app->availability_id = $availability->id;
                    $app->calender_id= $cal->id;
                    $app->fee = $availability->appointment_fee;
                    $app->insured = 'no';
                    $app->created_at = new \yii\db\Expression('NOW()');
                    $app->status = 'booked';
                    $app->stat = 'schadueled';
                    $app->save(false); 
                    return  array('success' => 1 , 'data' => $app);
                }
            }else{
                // no appointment available to book  
                return  array('success' => 0 , 'message' => 'no appointment available to book'); 
            }
        }
        


        // $model->name = $body['name'];
        // $model = new Task();

    }

    public function actionReserve(){
        $user =  Yii::$app->user->identity;
        $reserve = Appointment::find()->where(['user_id' => $user->id])->all();
        return  array('reservations' => $reserve);

    }

    public function actionAll(){
        $medical = Medical::find()->all();
        $doctors = Availability::find()->all();
        $insurance = InsuranceAcceptance::find()->all();
        // $data = Appointment::find()->where(['assigned_to' => $client->id])->all();
        // return array('medical' => $doctors, 'doctors' => $doctors);
        return  array('medical' => $medical, 'doctors' => $doctors, 'insurance' => $insurance);

    }


    // public function actionIndex(){

    //     $user = Yii::$app->user->identity;
    //     $data = Task::find()->where(['created_by' => $user->id])->orWhere(['assigned_to' => $user->id])->all();
    //     $note = array();
    //     foreach ($data as $d) {
    //         $task_notes = Note::find()->where(['task_id' => $d->id])->all();
    //         foreach ($task_notes as $n ) {
    //          array_push($note, $n);
    //         }
    //     }
    //     return  array('tasks' => $data, 'notes' => $note);

    // }

    // public function actionUpdate($id){

    //     $model = Task::findOne($id);
    //     $user =  Yii::$app->user->identity;
    //     if($model->assigned_to === $user->id){
    //         $model->submitted_at = new Expression('NOW()');
    //         $model->status = "submitted";
    //         if ($model->save()) {
    //             $gcm = Yii::$app->gcm;
    //             $gcm->send($user->google_token, $model);
    //             return ['success' => 1];
    //         }else{
    //             return array('success' => 0);
    //         }
    //     }
    // }


    // public function actionCreate(){
    //     $user =  Yii::$app->user->identity;
        
    //     $model = new Task();
    //     $body = json_decode(Yii::$app->getRequest()->getRawBody(), true);
    //     $model->load($body, '');
    //     $model->name = $body['name'];
    //     $model->description = $body['description'];
    //     $model->due_date = $body['due_date'];
    //     $c = $body['assigned_to'];
    //     $client = client::find()->where(['name' => $c])->one();
    //     $model->assigned_to = $client->id;
    //     $model->created_by = 1;
    //     if($body['priority'] == 1){
    //         $model->priority = 1;
    //     }else{
    //         $model->priority = 0;
    //     }
    //     $model->status = 'pending';
    //     $model->created_at = new Expression('NOW()');
    //     if ($model->save()) {
    //         $gcm = Yii::$app->gcm;
    //         $gcm->send($user->google_token, $model);
    //         return array('success' => 1);
    //     }else{
    //         return array('success' => 0);
    //     }

    // }



   
}