<?php

namespace app\controllers;

use Yii;
use app\models\Lab;
use app\models\LabSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use app\models\LabInsu;


/**
 * LabController implements the CRUD actions for Lab model.
 */
class LabController extends Controller
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
     * Lists all Lab models.
     * @return mixed
     */

    public function actionInsu($id)
    {
        $model = $this->findModel($id);
        $insu = new LabInsu();

        if ($insu->load(Yii::$app->request->post())) {
            $insu->lab_id = $model->id;
            $insu->save();
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->renderAjax('insu', [
            'insu' => $insu,
            'model' => $model
        ]);
    }

    public function actionIndex()
    {
        $searchModel = new LabSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Lab model.
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
     * Creates a new Lab model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Lab();

        if ($model->load(Yii::$app->request->post())) {
            $working_days = $_POST['Lab']['working_days'];
            $start = $_POST['Lab']['from_hour'];
            $end = $_POST['Lab']['to_hour'];
                $days = "";
            foreach ($working_days as $d) {
                // echo $d."<br>";
                $days .= $d." ";
                # code...
            }
            $model->working_days = $days;
            $model->photo = UploadedFile::getInstance($model,'photo');
            $model->photo->saveAs(Yii::$app->basePath.'/web/img/' .$model->photo.$model->id);
            $model->from_hour = date("H:i", strtotime($start));
            $model->to_hour = date("H:i", strtotime($end));
            $model->save(false);
            // echo $model->working_days;
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Lab model.
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
     * Deletes an existing Lab model.
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
     * Finds the Lab model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lab the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lab::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
