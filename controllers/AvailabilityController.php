<?php

namespace app\controllers;

use Yii;
use app\models\Availability;
use app\models\AvailabilitySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AvailabilityController implements the CRUD actions for Availability model.
 */
class AvailabilityController extends Controller
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
     * Lists all Availability models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AvailabilitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Availability model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Availability model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionCreate()
    // {
    //     $model = new Availability();

    //     if ($model->load(Yii::$app->request->post())) {

    //         $current = strtotime(date('Y-m-d'));
    //         $last = strtotime('next month')
    //         $i = 1;
    //         $dates = array();

    //         while( $current <= $last) {

    //             $day = date('Y-m-d', $current);
    //             $dayofweek = date('w', strtotime($day));
    //             if (in_array($dayofweek, $days)) 
    //              {
    //                 $dates[$i]['day']  = $dayofweek;
    //                 $dates[$i]['date'] = date('Y-m-d', $current);
    //                 $dates[$i]['start_time'] = $time[$dayofweek]['start'];
    //                 $dates[$i]['end_time'] = $time[$dayofweek]['end'];    
    //                 $i++;
    //              }

    //             $current = strtotime('+1 day', $current);
    //         }

            
    //         foreach ($dates as $date => $v) {
    //             // $cal = new Calender();
    //             // $cal->sub_id = $v['sub_id'];
    //             // $cal->day = $v['day'];
    //             // $cal->date = $v['date'];
    //             // $cal->start_time = $v['start_time'];
    //             // $cal->end_time = $v['end_time'];
    //             // $cal->save(false);
    //         }


    //         $model->save();
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->renderAjax('create', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Updates an existing Availability model.
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
     * Deletes an existing Availability model.
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
     * Finds the Availability model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Availability the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Availability::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
