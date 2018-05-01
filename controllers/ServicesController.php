<?php

namespace app\controllers;

use Yii;
use app\models\Ads;
use app\models\Services;
use app\models\Servicerequest;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


/**
 * AmbulanceController implements the CRUD actions for Ambulance model.
 */
class ServicesController extends Controller
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
     * Lists all Ads models.
     * @return mixed
     */
    public function actionIndex()
    {
        $ads = Ads::find()->all();
        $services = Services::find()->all();
        $requests = Servicerequest::find()->all();


         return $this->render('index', [
            'ads' => $ads,
            'services' => $services,
            'requests' => $requests,
        ]);
    }

    public function actionService()
    {
        $service = new Services();

        if ($service->load(Yii::$app->request->post())) {
            $service->save();
            return $this->redirect(['index']);
        }

        return $this->renderAjax('service', [
            'service' => $service,
        ]);
    }

    public function actionAds()
    {
        $ads = new Ads();

        if ($ads->load(Yii::$app->request->post())) {
            // $post = $_POST['Ads'];
            // print_r($post);
            // die();
            // echo Yii::getAlias('@webroot');
            // echo "<br>";
            // echo Yii::getAlias('@web');
            // die();
            // if (isset($ads->img)){
                $ads->img = UploadedFile::getInstance($ads,'img');
                // $ads->img->saveAs(Yii::getAlias('@web').'/img/panners/'.$ads->img);
                $ads->img->saveAs(Yii::$app->basePath.'/web/img/panners/'.$ads->img);
                // echo $ads->img;
                // die();
                //  echo $ads->img;
                // die();
                // if ($ads->img->saveAs(Yii::$app->basePath.'/img/panners/' .$ads->img)) {
                //     echo $ads->img;
                //     die();
                // }else{
                //     echo "not saved";
                //     die();
                // }

            // }
            // if (isset($ads->data) && !empty($ads->data)) {
            //     $ads->data = UploadedFile::getInstance($ads,'img');
            //     $ads->img->saveAs(Yii::$app->basePath.'/web/img/panners/' .$ads->img);
            // }
            $ads->save(false);
            return $this->redirect(['index']);
        }

        return $this->renderAjax('ads', [
            'ads' => $ads,
        ]);
    }

    // public function actionRequest()
    // {

    //     $model = AdsRequest::find()->all();

    //      return $this->render('request', [
    //         'model' => $model,
    //     ]);
    // }

    // /**
    //  * Displays a single Ads model.
    //  * @param integer $id
    //  * @return mixed
    //  * @throws NotFoundHttpException if the model cannot be found
    //  */
    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    // /**
    //  * Creates a new Ads model.
    //  * If creation is successful, the browser will be redirected to the 'view' page.
    //  * @return mixed
    //  */
    // public function actionCreate()
    // {
    //     $model = new Ads();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    // /**
    //  * Updates an existing Ads model.
    //  * If update is successful, the browser will be redirected to the 'view' page.
    //  * @param integer $id
    //  * @return mixed
    //  * @throws NotFoundHttpException if the model cannot be found
    //  */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //     ]);
    // }

    // /**
    //  * Deletes an existing Ads model.
    //  * If deletion is successful, the browser will be redirected to the 'index' page.
    //  * @param integer $id
    //  * @return mixed
    //  * @throws NotFoundHttpException if the model cannot be found
    //  */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

    /**
     * Finds the Ads model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ads the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ads::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
