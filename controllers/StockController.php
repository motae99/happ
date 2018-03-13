<?php

namespace app\controllers;

use Yii;
use app\models\Stock;
use app\models\StockSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Model;


/**
 * StockController implements the CRUD actions for Stock model.
 */
class StockController extends Controller
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
     * Lists all Stock models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Stock model.
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
     * Creates a new Stock model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        // $model = new Stock();
        $model = [new Stock];


        return $this->render('_form', [
            // 'model' => $model,
            'model' => (empty($model)) ? [new Stock] : $model,

        ]);
    }

    public function actionAdd()
    {   
         // $model = [new Stock];
        // var_dump($model);
        // die();
        if (isset($_POST['Stock'])) {
            $model = Model::createMultiple(Stock::classname());
            // Model::loadMultiple($model, Yii::$app->request->post());
            if (Model::loadMultiple($model, Yii::$app->request->post())) {
                echo "multiple Models loaded";
            }
            else{
                die();
            }

            $valid = true;

            // if ($valid) {
            //     $transaction = \Yii::$app->db->beginTransaction();
            //     try {
            //         // if ($flag = $valid) {
            //         //     foreach ($model as $m) {
            //         //         if (! ($flag = $m->save(false))) {
            //         //             $transaction->rollBack();
            //         //             break;
            //         //         }
            //         //     }
            //         // }
            //         if ($flag) {
            //             $transaction->commit();
            //             return $this->redirect(['index']);
            //         }
            //     } catch (Exception $e) {
            //         $transaction->rollBack();
            //     }
            // }
        }
        
    }

    /**
     * Updates an existing Stock model.
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
     * Deletes an existing Stock model.
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
     * Finds the Stock model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Stock the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Stock::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
