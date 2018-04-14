<?php

namespace app\controllers;

use Yii;
use app\models\Clinic;
use app\models\Specialization;
use app\models\ClinicSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


/**
 * ClinicController implements the CRUD actions for Clinic model.
 */
class ClinicController extends Controller
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
    public function actionIndex()
    {
        $searchModel = new ClinicSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
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
            return $this->redirect(['view', 'id' => $id]);
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
    public function actionView($id)
    {
        // $user =  Yii::$app->user->identity;
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Clinic model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Clinic();

        if ($model->load(Yii::$app->request->post())) {
            // print_r($model);
            $working_days = $_POST['Clinic']['working_days'];
            // echo "<br>";
            // echo "<br>";
            // echo "<br>";
            // print_r($working_days);
            $start = $_POST['Clinic']['start'];
            $end = $_POST['Clinic']['end'];
                $days = "";
            foreach ($working_days as $d) {
                // echo $d."<br>";
                $days .= $d." ";
                # code...
            }
            $model->working_days = $days;
            $model->photo = UploadedFile::getInstance($model,'photo');
            $model->primary_contact = $_POST['Clinic']['primary_contact'];
            $model->secondary_contact = $_POST['Clinic']['secondary_contact'];
            $model->photo->saveAs(Yii::$app->basePath.'/web/img/' .$model->photo.$model->id);
            $model->start = date("H:i", strtotime($start));
            $model->end = date("H:i", strtotime($end));
            $model->special_services = $_POST['Clinic']['special_services'];
            $model->app_service = $_POST['Clinic']['app_service'];
            // print_r($model);
            // die();
            $model->save();
            // echo $model->working_days;
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Clinic model.
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
     * Deletes an existing Clinic model.
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
