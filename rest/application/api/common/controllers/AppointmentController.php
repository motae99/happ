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

use yii\db\Expression;


class AppointmentController extends \api\components\ActiveController
{
    public $modelClass = '\api\common\models\Appointment';

    public function accessRules()
    {
        return [
            [
                'allow' => true,
                'roles' => ['?'],
            ],
            [
                'allow' => true,
                'actions' => [
                    'view',
                    'index',
                    'update',
                    'booking',
                    'reserve',
                    'all'
                ],
                'roles' => ['?'],
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
            $cal = Calender::find()
                ->where(['clinic_id' => $clinic_id])
                ->andWhere(['physician_id' => $doctor_id])
                ->andWhere(['status' => 'available'])
                ->orderBy(['date' => SORT_ASC])
                ->one();

            if ($cal) {
                $availability = Availability::find($cal->availability_id)->one();
                
                if ($availability && $insured) {
                    $insurance_available = InsuranceAcceptance::find()
                        ->where(['availability_id' => $availability->id])
                        ->andWhere(['insurance_id' => $insurance_id])
                        ->one();
              // return  array('insurance_available' => $insurance_available); 
                    if ($insurance_available) {
                      // book an appointment with insurance discount 
                      return  array('book' => 'book an appointment with insurance discount'); 
                    }else{
                        // message your insurance is not available
                      return  array('message' => 'message your insurance is not available'); 
                    }

                }else{
                   // book an appointment with no insurance  
                      return  array('book' => 'book an appointment with no insurance'); 
                }
            }else{
                // no appointment available to book  
                return  array('message' => 'no appointment available to book'); 
            }
        }
        


        // $model->name = $body['name'];
        // $model = new Task();

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



     public function actionReserve()
    {
       //  $task = Task::findOne($id);
       //  $user =  Yii::$app->user->identity;
       //  $note = new Note();
       //  $body = json_decode(Yii::$app->getRequest()->getRawBody(), true);
       //  $note->load($body, '');
       //  $note->user_id = $user->id;
       //  $note->task_id = $task->id;
       //  $note->note = $body['note'];
       //  $note->created_at = new Expression('NOW()');
       //  if($note->save()){
       //      $gcm = Yii::$app->gcm;
       //      $gcm->send($user->google_token, $note);
       //     return array('success' => 1); 
       // }else{
       //      return array('success' => 0);
       //  }
        
    }
}