<?php

namespace app\controllers;

use Yii;
use app\models\Clinic;
use app\models\Specialization;
use app\models\AppointmentSearch;
use app\models\Appointment;
use app\models\ClinicSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


use app\models\User;
use app\models\Role;
use \Unifonic\API\Client;


/**
 * ClinicController implements the CRUD actions for Clinic model.
 */
class MedicalController extends Controller
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
    public function actionReport()
    {
        $user = Yii::$app->user->identity;
        $searchModel = new AppointmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['appointment.clinic_id'=>$user->reference]);
        //have to add date
        // $dataProvider->query->andWhere(['date'=> date('Y-m-d')]);

        return $this->render('report', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSpecial($id)
    {
        $model = $this->findModel($id);
        $special = new Specialization();

        if ($special->load(Yii::$app->request->post())) {
            $special->clinic_id = $id;
            $special->save();
            return $this->redirect(['setting']);
        }

        return $this->renderAjax('special', [
            'special' => $special,
            'model' => $model
        ]);
    }

    /**
     * Displays a single Clinic model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionSetting()
    {
        $user =  Yii::$app->user->identity;
        return $this->render('config', [
            'model' => $this->findModel($user->reference),
        ]);
    }


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

    public function actionRegister()
    {
        // add register for this clinic
    }


    /**
     * Finds the Clinic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Clinic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Clinic::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
