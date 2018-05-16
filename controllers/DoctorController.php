<?php

namespace app\controllers;

use Yii;
use app\models\Doctor;
use app\models\Appointment;
use app\models\DoctorSearch;
use app\models\AppointmentSearch;
use app\models\Physician;
use app\models\Availability;
use app\models\Model;
use app\models\InsuranceAcceptance;
use app\models\PhysicianSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\db\Query;
use app\models\Calender;
use app\models\Schedule;

/**
 * ClinicController implements the CRUD actions for Clinic model.
 */
class DoctorController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Clinic models.
     * @return mixed
     */

    public function actionCancel($id){
        $user =  Yii::$app->user->identity;
        $app = Appointment::findOne($id);
        $current_schedule = Schedule::find()->where(['appointment_id' => $app->id])->one();
        if (($app->status == "booked" || $app->status == "confirmed") && ($app->stat == "schadueled")) {
            $app->status = "doctor_cancel";
            $app->stat = "canceled";
            $app->canceled_by = $user->id;
            $app->canceled_at = new \yii\db\Expression('NOW()');    
            if ($app->save(false)) {
                return $this->redirect(['index']);
            }else{
                return $this->redirect(['site/index']);
                
            }
            

            if ($current_schedule) {
               $current_schedule->appointment_id = "";
               $current_schedule->status = "available";
               $current_schedule->save(false);
            }

            return $this->redirect(['index']);
        }else{
            return $this->redirect(['site/index']);
        }
    }

    public function actionPay($id)
    {   
        $model = Appointment::findOne($id);
        $user =  Yii::$app->user->identity;

        // echo $model->calender_id;
        // die();
        $scheduale = Schedule::find()
                    ->where(['calender_id' => $model->calender_id])
                    ->andWhere(['status' => 'available'])
                    ->orderBy(['queue' => SORT_ASC])
                    ->one();
        if ($scheduale) { // if we don't then propably we are full
            # code...
            $scheduale->appointment_id = $model->id;
            $scheduale->status = 'reserved';
            $scheduale->save();

            $model->status = 'confirmed';
            $model->schedual_id = $scheduale->id;
            $model->confirmed_at = new \yii\db\Expression('NOW()');
            $model->confirmed_by = $user->id;
            $model->save(false);
        }


        $status = Schedule::find()
                    ->where(['calender_id' => $model->calender_id])
                    ->andWhere(['status' => 'available'])
                    ->count();

        if ($status >= 1) {
           
        }else{
            $cal = Calender::findOne($model->calender_id);
            $cal->status = "reserved";
            $cal->save();

        }
        return $this->redirect(['index']);
    }

    public function actionProccess($id)
    {   
        // $app = new Appointment();
        // $app = Appointment::findOne($id);
        // // print_r($app);
        // // die();
        // $app->stat = 'processing';
        // if ($app->save(false)) {
        //     return $this->redirect(['index']);
        // }else{
        //     var_dump($app->errors); //return $this->redirect(['site/index']);
        // }

        $saved = Yii::$app->db->createCommand()
         ->update('appointment', ['stat' => 'processing'], 'id=:id')
         ->bindValue(':id', $id)
         ->execute();

        if ($saved) {
            return $this->redirect(['index']);
        }else{
            return $this->redirect(['site/index']);
        }
    }

    public function actionFinish($id)
    {   
        $model = Appointment::findOne($id);
        $model->stat = 'done';
        $model->save(false);
        return $this->redirect(['index']);
    }

    public function actionIndex()
    {   
        $user = Yii::$app->user->identity;
        $searchModel = new AppointmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['appointment.physician_id'=>$user->reference]);
        //have to add date
        $dataProvider->query->andWhere(['date'=> date('Y-m-d')]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReport()
    {   
        $user = Yii::$app->user->identity;
        $searchModel = new AppointmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['appointment.physician_id'=>$user->reference]);
        //have to add where stat is done
        // $dataProvider->query->andWhere(['date'=> date('Y-m-d')]);

        return $this->render('report', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionModify($id)
    {
        $model = Calender::findOne($id);

        if ($model->load(Yii::$app->request->post()) ) {
            $model->start_time = date("H:i", strtotime($_POST['Calender']['start_time']));
            $model->end_time = date("H:i", strtotime($_POST['Calender']['end_time']));
            $model->date = date("Y-m-d", strtotime($_POST['Calender']['date']));
            $model->status = $_POST['Calender']['status'];
            $model->save();
           
            return $this->redirect(['setting']);
        }

        return $this->renderAjax('cal', [
            'model' => $model,
        ]);
    }

    public function actionTable($start=NULL,$end=NULL,$_=NULL, $id){
        $user = Yii::$app->user->identity;
        $doctor = $this->findModel($user->reference);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $events = array();
        $timeTable = $doctor->cal;
        // $n = 9;
        foreach ($timeTable as $value) {
            $Event = new \yii2fullcalendar\models\Event();
            $Event->id = $value->id;
            $Event->start = $value->date." ".$value->start_time;
            $Event->end = $value->date." ".$value->end_time;
            $Event->title = $value->clinic->name;
            if($value->status == 'canceled'){
                $Event->className = 'bg-red';
            }else{
              $Event->className = $value->clinic->color;
            }

            // $Event->className = $Event->className.' fa fa-times-circle';
            // $Event->className = $Event->className.' fa fa-check-circle';
            // $Event->className = $Event->className.' fa fa-times-circle';
            // $Event->amount = $value->amount;
            // $Event->url = Url::toRoute(['invoices/view', 'id'=>$value->invoice_id]);
            // $status = $value->status;
            // // $Event->stat = $status;

            // //." ".$value->start_time
            
            // if ($value->type == 'promise') {
            //     $Event->className = $Event->className.' fa fa-dollar';
            //     $Event->start = $value->due_date;
            //     $Event->end = $value->due_date;
            // }else{
            //     $Event->className = $Event->className.' fa fa-money';
            //     $Event->start = $value->cheque_date;
            //     $Event->end = $value->cheque_date; 
            // }
            
            $events[] = $Event;
            // $n++;
        }
        // var_dump($events);
        return $events;
    }

    //
    public function actionSetting()
    {
        $user = Yii::$app->user->identity;
        $model = $this->findModel($user->reference);
        $available = new Availability;

        if ($available->load(Yii::$app->request->post())) {
            $available->physician_id = $model->id;
            $available->status = 0;
            $available->created_at = new \yii\db\Expression('NOW()');
            $available->created_by = 1;
            $available->save(false);
        }
        return $this->render('view', [
            'model' => $model,
            'available' => $available,
        ]);
    }

     public function actionAvailability($id, $start=NULL,$end=NULL)
    {   
        $model = $this->findModel($id);
        $available = new Availability;
        $insurance = [new InsuranceAcceptance];

        if ($available->load(Yii::$app->request->post())) {
            $current = strtotime(date('Y-m-d'));
            $last = strtotime('next month');
            $i = 1;
            $dates = array();
            $days = "";
            foreach ($available->date as $working) {
                if ($working == 6) {
                    $days .= "السبت  " ;
                }elseif ($working == 0) {
                    $days .= "الأحد  " ;
                }elseif ($working == 1) {
                    $days .= "الأثنين  " ;
                }elseif ($working == 2) {
                    $days .= "الثﻻثاء  " ;
                }elseif ($working == 3) {
                    $days .= "الأربعاء  " ;
                }elseif ($working == 4) {
                    $days .= "الخميس  " ;
                }elseif ($working == 5) {
                    $days .= "الجمعه  " ;
                }
                
            }
            
            while( $current <= $last) {

                $day = date('Y-m-d', $current);

                $dayofweek = date('w', strtotime($day));

                if (in_array($dayofweek, $available->date)) 
                 {
                    $dates[$i]['day']  = $dayofweek;
                    $dates[$i]['date'] = date('Y-m-d', $current);
                    $i++;
                 }

                $current = strtotime('+1 day', $current);
            }
            $available->physician_id = $model->id;
            $available->date = $days;
            $duration = $available->duration;
            $available->from_time = date("H:i", strtotime($available->from_time));
            $available->to_time = date("H:i", strtotime($available->to_time));
            // print_r($available);
            // die();
            
            $insurance = Model::createMultiple(InsuranceAcceptance::classname());
            Model::loadMultiple($insurance, Yii::$app->request->post());
            $valid = $available->validate();
            // $valid = Model::validateMultiple($insurance) && $valid;
             if ($valid) {
                 $transaction = \Yii::$app->db->beginTransaction();
                 try {
                     if ($flag = $available->save(false) ) {
                         foreach ($insurance as $ins) {
                             $ins->availability_id = $available->id;
                             $ins->physician_id = $available->physician_id;
                             $ins->clinic_id = $available->clinic_id;
                             if (! ($flag = $ins->save(false))) {
                                 $transaction->rollBack();
                                 break;
                             }
                         }

                        foreach ($dates as $date => $v) {
                            $cal = new Calender();
                            $cal->availability_id = $available->id;
                            $cal->physician_id = $available->physician_id;
                            $cal->clinic_id = $available->clinic_id;
                            $cal->day = $v['day'];
                            $cal->date = $v['date'];
                            $cal->start_time = date("H:i", strtotime($available->from_time));
                            $cal->end_time = date("H:i", strtotime($available->to_time));
                            // print_r($cal);
                            // die();
                            if (! ($flag = $cal->save(false))) {
                                 $transaction->rollBack();
                                 break;
                            }else{
                              
                              $start = strtotime($cal->start_time);
                              $end = strtotime($cal->end_time);
                              $i=1; 
                              while ($start <= $end && $i <= $available->max ) {
                                $schedule = new Schedule();
                                $schedule->calender_id = $cal->id;
                                $schedule->schedule_time = date("H:i",strtotime('+'.$duration.' minutes',$start));
                                $schedule->queue = $i;
                                $schedule->status = 'available';
                                $schedule->save(false);
                                $start = strtotime($schedule->schedule_time);
                                $i++;
                               
                              }

                             
                            }

                        }



                     }
                     if ($flag) {
                         $transaction->commit();
                        return $this->redirect(['setting']);
                     }
                 } catch (Exception $e) {
                     $transaction->rollBack();
                 }
             }
           
            

            return $this->redirect(['index']);

        }
        return $this->renderAjax('avail', [
            'model' => $model,
            'start' => $start,
            'end' => $end,
            'available' => $available,
            'insurance' => (empty($insurance)) ? [new InsuranceAcceptance] : $insurance,

        ]);
    }

    public function actionClinic($q = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
          $query = new Query;
          $query->select('id, name AS text')
              ->from('clinic')
              ->where(['like', 'name', $q]);
          $command = $query->createCommand();
          $data = $command->queryAll();
          $out['results'] = array_values($data);
        }
        return $out;

    }

    protected function findModel($id)
    {
        if (($model = Physician::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
