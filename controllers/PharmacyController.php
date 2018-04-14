<?php

namespace app\controllers;

use Yii;
use app\models\Pharmacy;
use app\models\Drugs;
use app\models\PharmacySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\PharInsu;
use yii\filters\VerbFilter;

/**
 * PharmacyController implements the CRUD actions for Pharmacy model.
 */
class PharmacyController extends Controller
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

    public function actionInsu($id)
    {
        $model = $this->findModel($id);
        $insu = new PharInsu();

        if ($insu->load(Yii::$app->request->post())) {
            $insu->phar_id = $model->id;
            $insu->save();
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->renderAjax('insu', [
            'insu' => $insu,
            'model' => $model
        ]);
    }

    public function actionDrug($id)
    {
        $model = $this->findModel($id);
        $drug = new Drugs();
        $user =  Yii::$app->user->identity;

        if ($drug->load(Yii::$app->request->post())) {
            $drug->phar_id = $model->id;
            $drug->created_at = new \yii\db\Expression('NOW()');
            $drug->created_by = $user->id;
            $drug->save();
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->renderAjax('drug', [
            'drug' => $drug,
            'model' => $model
        ]);
    }

    /**
     * Lists all Pharmacy models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PharmacySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pharmacy model.
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
     * Creates a new Pharmacy model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pharmacy();

        if ($model->load(Yii::$app->request->post()) ) {
            $working_days = $_POST['Pharmacy']['working_days'];
            $days = "";
            foreach ($working_days as $d) {
                $days .= $d." ";
            }
            $start = $_POST['Pharmacy']['from_hour'];
            $end = $_POST['Pharmacy']['to_hour'];
            $model->working_days = $days;
            $model->from_hour = date("H:i", strtotime($start));
            $model->to_hour = date("H:i", strtotime($end));
            $model->save(false);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Pharmacy model.
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
     * Deletes an existing Pharmacy model.
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
     * Finds the Pharmacy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pharmacy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pharmacy::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
