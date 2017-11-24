<?php

namespace app\controllers;

use Yii;
use app\models\Stocking;
use app\models\Stock;
use app\models\Minimal;
use app\models\Product;
use app\models\Transaction;
use app\models\SystemAccount;
use app\models\Entry;
use app\models\Inventory;
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
            $product = Product::findOne($model->product_id);
            $inventory = Inventory::findOne($model->inventory_id);
            $inventoryAccount = SystemAccount::find()->where(['id' => $inventory->asset_account_id])->one();
            $buying = Yii::$app->mycomponent->rateSdp($_POST['Stocking']['buying_price']);
            $selling = Yii::$app->mycomponent->rateSdp($_POST['Stocking']['selling_price']);
            $model->buying_price = $buying;
            $model->selling_price = $selling;
            $model->rate = 22;
            $model->transaction = 'in';
            $model->created_at = new \yii\db\Expression('NOW()');
            $amount = $model->buying_price*$model->rate;
            if($model->save()){
                $saveBoth = ($product->buying_price < $model->buying_price && $product->selling_price < $model->selling_price);
                $saveBuying = ($product->buying_price < $model->buying_price && $product->selling_price > $model->selling_price);
                $saveSelling = ($product->buying_price > $model->buying_price && $product->selling_price < $model->selling_price);
                //// recalculate Product ////
                // if($saveBoth){
                    $product->buying_price = $model->buying_price;
                    $product->selling_price = $model->selling_price;
                    $product->percentage = $model->percentage;
                    $product->save(false);
                // }elseif ($saveBuying) {
                //     # code...
                // }elseif ($saveSelling) {
                //     # code...
                // }
                //// recalculate Product ////

                $stock = Stock::find()
                        ->where(['product_id' => $model->product_id])
                        ->andWhere(['inventory_id' => $model->inventory_id])
                        ->one();
                if($stock){
                    //// calculate cost of goods sold ////
                        $stocking = Stocking::find()
                            ->where(['product_id' => $model->product_id])
                            ->andWhere(['inventory_id' => $model->inventory_id])
                            ->andWhere(['transaction' => 'in'])
                            ->all();    
                        $highest_rate = Stocking::find()->where(['product_id' => $model->product_id])->max('rate');    
                        $line=0; $q=0;
                        foreach ($stocking as $s) {
                            $line += $s->buying_price*$s->quantity;
                            $q += $s->quantity;
                        }
                            $cost = $line/$q ;
                    //// calculate cost of goods sold ////

                    $stock->quantity += $model->quantity;
                    $stock->avg_cost = $cost;
                    $stock->highest_rate = $highest_rate;
                    // $stock->product_name = $product->product_name ;
                    if($stock->save(false)){
                        
                        $stocked = True ;
                    }
                }else{
                    $stock = new Stock();
                    $stock->inventory_id = $model->inventory_id ;
                    $stock->product_id = $model->product_id ;
                    $stock->product_name = $product->product_name ;
                    $stock->quantity = $model->quantity ;
                    $stock->avg_cost = $model->buying_price;
                    $stock->highest_rate = $model->rate;
                    if($stock->save()){
                        $stocked = True ;
                    }

                }
                //// Update minimal ////
                    $min = Minimal::find()->where(['stock_id' => $stock->id])->one();
                    // print_r($min);
                    // die();
                    if ($min) {
                        if ($stock->quantity < $product->minimum) {
                                $min->quantity = $stock->quantity;
                                $min->save(false);
                        }else{
                            $min->delete(false);
                        }
                    }
                //// Update minimal ////

                // Keeping journal entry  //
                    $amount = $model->buying_price*$model->quantity;
                    $start = new Transaction();
                    $start->description = "Stocking Product ";
                    $start->reference = $stock->id;
                    $start->reference_type = "Stock";
                    if($start->save(false)){
                    
                    // Depiting Inventory//
                        $inventory = new Entry();
                        $account = $inventoryAccount;
                        $inventory->transaction_id = $start->id; 
                        $inventory->account_id = $account->id; 
                        $inventory->is_depit = 'yes'; 
                        $inventory->amount = $amount; 
                        $inventory->description = "inventory Value Increased"; 
                        $inventory->date = date('Y-m-d'); 
                        $inventory->balance = $account->balance + $amount; 
                        if($inventory->save(false)){
                            $account->balance += $amount;
                            $account->save(false); 
                        }
                    // Depiting Inventory//

                    // Crediting Payable//
                        $payable = new Entry();
                        $account = SystemAccount::find()->where(['account_no' => '2000'])->one();
                        $payable->transaction_id = $start->id; 
                        $payable->account_id = $account->id; 
                        $payable->is_depit = 'no'; 
                        $payable->amount = $amount; 
                        $payable->description = "payable Account Increased"; 
                        $payable->date = date('Y-m-d'); 
                        $payable->balance = $account->balance + $amount; 
                        if($payable->save(false)){
                            $account->balance += $amount;
                            $account->save(false); 
                        }
                    // Crediting Payable//
                    }
                // Keeping journal entry  //
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
