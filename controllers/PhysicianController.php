<?php

namespace app\controllers;

use Yii;
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
 * PhysicianController implements the CRUD actions for Physician model.
 */
class PhysicianController extends Controller
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

    public function actionModify($id)
    {
        $model = Calender::findOne($id);

        if ($model->load(Yii::$app->request->post()) ) {
            $model->start_time = date("H:i", strtotime($_POST['Calender']['start_time']));
            $model->end_time = date("H:i", strtotime($_POST['Calender']['end_time']));
            $model->date = date("Y-m-d", strtotime($_POST['Calender']['date']));
            $model->status = $_POST['Calender']['status'];
            $model->save();
           
            return $this->redirect(['view', 'id' => $model->doctor->id]);
        }

        return $this->renderAjax('cal', [
            'model' => $model,
        ]);
    }

     public function actionTable($start=NULL,$end=NULL,$_=NULL, $id){
        $doctor = $this->findModel($id);
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

    /**
     * Lists all Physician models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PhysicianSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Physician model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {   
        $model = $this->findModel($id);
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

    public function actionAdd($id)
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
                    $days .= "السبت | " ;
                }elseif ($working == 0) {
                    $days .= "الأحد | " ;
                }elseif ($working == 1) {
                    $days .= "الأثنين | " ;
                }elseif ($working == 2) {
                    $days .= "الثﻻثاء | " ;
                }elseif ($working == 3) {
                    $days .= "الأربعاء | " ;
                }elseif ($working == 4) {
                    $days .= "الخميس | " ;
                }elseif ($working == 5) {
                    $days .= "الجمعه | " ;
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
                // echo date('w', strtotime("2018-03-25"));
            }
                
            $available->physician_id = $model->id;
            $available->date = $days;
            
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
                             }

                        }
                     }
                     if ($flag) {
                         $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
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
                    $days .= "السبت | " ;
                }elseif ($working == 0) {
                    $days .= "الأحد | " ;
                }elseif ($working == 1) {
                    $days .= "الأثنين | " ;
                }elseif ($working == 2) {
                    $days .= "الثﻻثاء | " ;
                }elseif ($working == 3) {
                    $days .= "الأربعاء | " ;
                }elseif ($working == 4) {
                    $days .= "الخميس | " ;
                }elseif ($working == 5) {
                    $days .= "الجمعه | " ;
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
                        return $this->redirect(['view', 'id' => $model->id]);
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

    /**
     * Creates a new Physician model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Physician();
       

        if ($model->load(Yii::$app->request->post())) {
            $model->photo = UploadedFile::getInstance($model,'photo');
            $model->photo->saveAs(Yii::$app->basePath.'/web/img/' .$model->photo.$model->id);
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('_form', [
            'model' => $model,
            // 'availability' => $availability,
            // 'availability' => (empty($availability)) ? [new Availability] : $availability,
            // 'insurance' => (empty($insurance)) ? [[new Insurance]] : $insurance,
        ]);
    }

        public function actionCr()

    {
        $modelPerson = new Person;
        $modelsHouse = [new House];
        $modelsRoom = [[new Room]];
        if ($modelPerson->load(Yii::$app->request->post())) {
            $modelsHouse = Model::createMultiple(House::classname());
            Model::loadMultiple($modelsHouse, Yii::$app->request->post());
            // validate person and houses models
            $valid = $modelPerson->validate();
            $valid = Model::validateMultiple($modelsHouse) && $valid;
            if (isset($_POST['Room'][0][0])) {
                foreach ($_POST['Room'] as $indexHouse => $insurances) {
                    foreach ($rooms as $indexRoom => $room) {
                        $data['Room'] = $room;
                        $modelRoom = new Room;
                        $modelRoom->load($data);
                        $modelsRoom[$indexHouse][$indexRoom] = $modelRoom;
                        $valid = $modelRoom->validate();
                    }
                }
            }
            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelPerson->save(false)) {
                        foreach ($modelsHouse as $indexHouse => $modelHouse) {
                            if ($flag === false) {
                                break;
                            }
                            $modelHouse->person_id = $modelPerson->id;
                            if (!($flag = $modelHouse->save(false))) {
                                break;
                            }
                            if (isset($modelsRoom[$indexHouse]) && is_array($modelsRoom[$indexHouse])) {
                                foreach ($modelsRoom[$indexHouse] as $indexRoom => $modelRoom) {
                                    $modelRoom->house_id = $modelHouse->id;
                                    if (!($flag = $modelRoom->save(false))) {
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelPerson->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        return $this->render('create', [
            'modelPerson' => $modelPerson,
            'modelsHouse' => (empty($modelsHouse)) ? [new House] : $modelsHouse,
            'modelsRoom' => (empty($modelsRoom)) ? [[new Room]] : $modelsRoom,
        ]);

    }
    /**
     * Updates an existing Physician model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Physician model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Physician model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Physician the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Physician::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
