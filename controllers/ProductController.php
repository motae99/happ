<?php

namespace app\controllers;

use Yii;
use app\models\Product;
use app\models\Stock;
use app\models\ProductSearch;
// use app\components\MyComponent;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\db\Query;



class ProductController extends Controller
{
    
    // public function behaviors()
    // {
    //     return [
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'delete' => ['POST'],
    //             ],
    //         ],
    //     ];
    // }

    
    public function actionFetch($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
          $query = new Query;
          $query->select('id, product_name AS text')
              ->from('product')
              ->where(['like', 'product_name', $q]);
              // ->andWhere(['type' => 'supplier'])
              // ->limit(20);
          $command = $query->createCommand();
          $data = $command->queryAll();
          $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
          $out['results'] = ['id' => $id, 'text' => Product::find($id)->product_name];
        }
        return $out;

    }

    public function actionInproduct($q = null, $inventory_id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q) && !is_null($inventory_id)) {
          $query = new Query;
          $query->select('product_id AS id, product_name AS text')
              ->from('stock')
              ->where(['like', 'product_name', $q])
              ->andWhere(['>', 'quantity', 0])
              ->andWhere(['inventory_id' => $inventory_id]);
              // ->limit(20);
          $command = $query->createCommand();
          $data = $command->queryAll();
          $out['results'] = array_values($data);
        }
        return $out;

    }

    public function actionDetail($id)
    {
        if($id){
            $model = Product::findOne($id);
            return \yii\helpers\Json::encode([
                'id'=>$model->id,
                'product_name'=>$model->product_name,
                'active'=>$model->active,
                'percentage'=>$model->percentage,
                'buying_price'=>Yii::$app->mycomponent->rate()*$model->buying_price,
                'selling_price'=>Yii::$app->mycomponent->rate()*$model->selling_price,

            ]);

        }else{
            return \yii\helpers\Json::encode(['detail'=>"Check Products"]);
        }


    }

    public function actionProdetail($product_id, $inventory_id)
    {
        if($product_id && $inventory_id){
            $product = Product::find()->where(['id' => $product_id])->one();
            $stock = Stock::find()
                        ->where(['product_id' => $product->id])
                        ->andWhere(['inventory_id' => $inventory_id])->one();

            $current_rate = Yii::$app->mycomponent->rate();
            $highest_rate = $stock->highest_rate;
            if ($current_rate > $highest_rate) {
               $price = round($product->selling_price*$current_rate); 
            }else{
              $price = round($product->selling_price*$highest_rate); 
            }
            
            return \yii\helpers\Json::encode([
                'selling_price'=>$price,
                'quantity'=>$stock->quantity,
            ]);   
            

        }else{
            return \yii\helpers\Json::encode(['detail'=>"Check Products"]);
        }


    }

    // public function actionIndex()
    // {
    //     $searchModel = new ProductSearch();
    //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    //     return $this->render('index', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    
    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    
    public function actionCreate()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post())) {
            $model->buying_price = $_POST['Product']['buying_price'] / Yii::$app->mycomponent->rate();
            $model->selling_price = $_POST['Product']['selling_price'] / Yii::$app->mycomponent->rate();
            $model->save();
            //// Set flash Properties//
                Yii::$app->getSession()->setFlash('success', ['type' => 'success']);
            //// Set flash Properties//

            return $this->redirect(['inventory/index']);
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }


    
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         //// Set flash Properties//
    //             Yii::$app->getSession()->setFlash('success', ['type' => 'success']);
    //         //// Set flash Properties//

    //         return $this->redirect(['index']);
    //     }

    //     return $this->renderAjax('update', [
    //         'model' => $model,
    //     ]);
    // }


    
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

    
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
