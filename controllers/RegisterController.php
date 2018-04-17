<?php

namespace app\controllers;

use Yii;
use app\models\Appointment;
use app\models\Schedule;
use app\models\Calender;
use app\models\DrugsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DrugsController implements the CRUD actions for Drugs model.
 */
class RegisterController extends Controller
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
     * Lists all Drugs models.
     * @return mixed
     */
    public function actionIndex()
    {
        // $searchModel = new DrugsSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // return $this->render('index', [
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        // ]);
        $model = Appointment::find()->all();
        return $this->render('index', ['model' => $model]);
    }

    public function actionPay($id)
    {   
        $model = Appointment::findOne($id);
        $user =  Yii::$app->user->identity;
        $model->status = 'confirmed';
        $model->confirmed_at = new \yii\db\Expression('NOW()');
        $model->confirmed_by = $user->id;
        $model->save(false);

        // echo $model->calender_id;
        // die();
        $scheduale = Schedule::find()
                    ->where(['calender_id' => $model->calender_id])
                    ->andWhere(['status' => 'available'])
                    ->orderBy(['schedule_time' => SORT_ASC])
                    ->one();
        $scheduale->appointment_id = $model->id;
        $scheduale->status = 'reserved';
        $scheduale->save();

        $status = Schedule::find()
                    ->where(['calender_id' => $model->calender_id])
                    ->andWhere(['status' => 'available'])
                    ->count();

        if ($status >=1) {
           
        }else{
            $cal = Calender::findOne($model->calender_id);
            $cal->status = "reserved";
            $cal->save();

        }
        return $this->redirect(['index']);
    }

    public function actionProccess($id)
    {   
        $model = Appointment::findOne($id);
        $model->stat = 'processing';
        $model->save(false);
        return $this->redirect(['index']);
    }

    public function actionFinish($id)
    {   
        $model = Appointment::findOne($id);
        $model->stat = 'done';
        $model->save(false);
        return $this->redirect(['index']);
    }
    /**
     * Displays a single Drugs model.
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
     * Creates a new Drugs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Drugs();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Drugs model.
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
     * Deletes an existing Drugs model.
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
     * Finds the Drugs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Drugs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Drugs::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
