<?php

namespace app\controllers;

use Yii;
use app\models\Stocking;
use app\models\Stock;
use app\models\Product;
use app\models\StockingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class StockingController extends Controller
{
    /**
     * @inheritdoc
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


    public function actionIndex()
    {
        $searchModel = new StockingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Stocking();


        if ($model->load(Yii::$app->request->post())) {
           
            if($model->save()){

                ## need more work
                $product = Product::findOne($model->product_id);
                if(($product->buying_price != $model->buying_price) || ($product->selling_price != $model->selling_price)){
                    $product->buying_price = $model->buying_price;
                    $product->selling_price = $model->selling_price;
                    $product->save();
                }
                ## need more work

                $stock = Stock::find()
                        ->where(['product_id' => $model->product_id])
                        ->andWhere(['inventory_id' => $model->inventory_id])
                        ->one();
                if($stock){
                    $stock->quantity += $model->quantity;
                    $stock->product_name = $product->product_name ;
                    if($stock->save()){
                        
                        $stocked = True ;
                    }
                    ##### Begin A Transaction and reflect on journal Entry #####
                }else{
                    $stock = new Stock();
                    $stock->inventory_id = $model->inventory_id ;
                    $stock->product_id = $model->product_id ;
                    $stock->product_name = $product->product_name ;
                    $stock->quantity = $model->quantity ;
                    if($stock->save()){
                        $stocked = True ;
                    }
                    ##### Begin A Transaction and reflect on journal Entry #####

                }

                ### We don't have a transaction but we change the inventory stock value ###

            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
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


    public function actionDelete($id)
    {   
        $model = Stocking::findOne($id);
        $stock = $stock = Stock::find()
                        ->where(['product_id' => $model->product_id])
                        ->andWhere(['inventory_id' => $model->inventory_id])
                        ->one();
        $stock->quantity -= $model->quantity;
        $stock->save();
        ##### Begin A Transaction and reflect on journal Entry #####

        $model->delete();

        return $this->redirect(['index']);
    }


    protected function findModel($id)
    {
        if (($model = Stocking::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
