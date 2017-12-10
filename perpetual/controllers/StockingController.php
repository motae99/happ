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
            $model->rate = Yii::$app->mycomponent->rate();
            $buying = $_POST['Stocking']['buying_price']/$model->rate;
            $selling = $_POST['Stocking']['selling_price']/$model->rate;
            $model->buying_price = $buying;
            $model->selling_price = $selling;
            $model->transaction = 'in';
            $model->created_at = new \yii\db\Expression('NOW()');
            $amount = $model->buying_price*$model->rate;
            if($model->save(false)){
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
                            ->orWhere(['transaction' => 'returned'])
                            ->all();    
                        $highest_rate = Stocking::find()->where(['product_id' => $model->product_id, 'inventory_id' => $model->inventory_id])->max('rate');    
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
                    
                    //// Depiting Asset Increase  Asset Account + balance ////
                    $inventory = Yii::$app->mycomponent->increase($inventoryAccount, $amount, $start->id);

                    //// Credint Payable Increase Account + balance ////
                    $payableAccount = SystemAccount::find()->where(['account_no' => '2000'])->one();
                    $payable = Yii::$app->mycomponent->increase($payableAccount, $amount, $start->id);
                    
                    
                    }
                // Keeping journal entry  //
            }
            return $this->redirect(['inventory/index']);
        }

        return $this->renderAjax('_form', [
            'model' => $model,
        ]);
    }

    public function actionTransfere()
    {   
        $trans = new Inventory();
        if ($trans->load(Yii::$app->request->post())) {
            $allSet = (isset($_POST['Inventory']['from']) && isset($_POST['Inventory']['to']) && isset($_POST['Inventory']['item']) && isset($_POST['Inventory']['quantity']));
            if ($allSet){
                $from = $_POST['Inventory']['from'];
                $to = $_POST['Inventory']['to'];
                $stock_id = $_POST['Inventory']['item'];
                $quantity = $_POST['Inventory']['quantity'];
                $same = true;
                $qNot = true;
                
                if ($from == $to) {
                    $same = false;
                    Yii::$app->getSession()->setFlash('error', ['type' => 'error']);
                }

                $stock = Stock::findOne($stock_id);
                // if (!$stock) {
                //     $available = 0;
                // }else{
                //     $available = $stock->quantity;
                // }
                if ($stock->quantity < $quantity ) {
                    $qNot = false;
                    Yii::$app->getSession()->setFlash('error', ['type' => 'error']);
                }
            }
            if ($allSet && $same && $qNot) {
                $product = Product::findOne($stock->product_id);
                $from_inventory = Inventory::findOne($from);
                $to_inventory = Inventory::findOne($to);
                $fromAccount = SystemAccount::find()->where(['id' => $from_inventory->asset_account_id])->one();
                $toAccount = SystemAccount::find()->where(['id' => $to_inventory->asset_account_id])->one();
                $rate = $stock->highest_rate;
                $avg_cost = $stock->avg_cost;
                $selling = $product->selling_price;
                $buying = $product->buying_price;
                $inventory_cost = $avg_cost*$quantity;

                /// stock out ///
                $stocking_out = new Stocking();
                $stocking_out->inventory_id = $from_inventory->id;
                $stocking_out->product_id = $product->id;
                $stocking_out->buying_price = $avg_cost;
                $stocking_out->selling_price = $avg_cost;
                $stocking_out->quantity = $quantity;
                $stocking_out->transaction = "transfered";
                if ($stock->highest_rate > Yii::$app->mycomponent->rate() ) {
                    $rate = $stock->highest_rate;
                }else{
                    $rate = Yii::$app->mycomponent->rate();
                }
                $stocking_out->rate = $rate;
                $stocking_out->save(false);

                //// delete stock in ////
                $stockings = Stocking::find()
                                    ->where(['product_id' => $stock->product_id])
                                    ->andWhere(['inventory_id' => $from_inventory->id])
                                    ->andWhere(['transaction' => 'in'])
                                    ->orWhere(['transaction' => 'returned'])
                                    ->orderBy(['rate' => SORT_DESC])
                                    ->all();

                $q = $quantity;
                
                foreach ($stockings as $s) {
                    if ($s->quantity > $q) {
                        $s->quantity -= $q;
                        $s->save(false);
                        break;
                    }
                    elseif ($s->quantity <= $q) {
                        $q -= $s->quantity;
                        $s->delete(false);
                    }
                }

                //// fix stock rate /////
                $transfered_from = Stocking::find()
                                ->where(['product_id' => $product->id])
                                ->andWhere(['inventory_id' => $from_inventory->id])
                                ->andWhere(['transaction' => 'in'])
                                ->orWhere(['transaction' => 'returned'])
                                ->max('rate');

                if ($transfered_from != $stock->highest_rate) {
                    $stock->highest_rate = $transfered_from;
                }
                $stock->quantity -= $quantity;
                $stock->save(false);
                //// fix stock rate /////

                //// save minimum/////
                if ($stock->quantity < $product->minimum) {
                    $remainingQuantity = $product->minimum - $stock->quantity;
                    $min = Minimal::find()->where(['stock_id' => $stock->id])->one();
                    if ($min) {
                        $min->quantity = $remainingQuantity;
                        $min->save(false);
                    }else{
                        $minimum = new Minimal();
                        $minimum->stock_id = $stock->id;
                        $minimum->quantity = $remainingQuantity;
                        $minimum->save(false);
                    }
                }
                //// save minimum/////

                $in_stock = Stock::find()->where(['inventory_id'=>$to_inventory->id, 'product_id'=>$product->id])->one();
                if (!$in_stock) {
                    $in_stock = new Stock();
                    $in_stock->inventory_id = $to_inventory->id ;
                    $in_stock->product_id = $product->id ;
                    $in_stock->product_name = $product->product_name ;
                    $in_stock->quantity = 0 ;
                    $in_stock->avg_cost = 0;
                    $in_stock->highest_rate = 0;
                    $in_stock->save(false);

                }
                 


                /// stock in ///
                $stocking_in = new Stocking();
                $stocking_in->inventory_id = $to_inventory->id;
                $stocking_in->product_id = $product->id;
                $stocking_in->buying_price = $avg_cost;
                $stocking_in->selling_price = $avg_cost;
                $stocking_in->quantity = $quantity;
                $stocking_in->transaction = "in";
                $stocking_in->rate = $stocking_out->rate;
                $stocking_in->save(false);

                // if ($transfered_to > Yii::$app->mycomponent->rate() && $transfered_to > $transfered_from) {
                //     $rate = $transfered_to;
                // }elseif ($transfered_from > Yii::$app->mycomponent->rate() && $transfered_from > $transfered_to) {
                //     $rate = $transfered_from;
                // }else{
                //     $rate = Yii::$app->mycomponent->rate();
                // }

                $transfered_to = Stocking::find()
                                ->where(['product_id' => $product->id])
                                ->andWhere(['inventory_id' => $to_inventory->id])
                                ->andWhere(['transaction' => 'in'])
                                ->orWhere(['transaction' => 'returned'])
                                ->max('rate');


                if ($transfered_to > $in_stock->highest_rate) {
                    $in_stock->highest_rate = $transfered_to;
                }
                //// calculate cost of goods sold ////
                    $all_stock = Stocking::find()
                        ->where(['product_id' => $product->id])
                        ->andWhere(['inventory_id' => $to_inventory->id])
                        ->all();  

                    $line=0; $quan=0;
                    foreach ($all_stock as $s) {
                        $line += $s->buying_price*$s->quantity;
                        $quan += $s->quantity;
                    }
                        $costCal = $line/$quan ;
                //// calculate cost of goods sold ////

                $in_stock->quantity += $quantity;
                $in_stock->avg_cost = $costCal;
                $in_stock->save(false);
                //// fix stock rate /////

                //// save minimum/////
                if ($in_stock->quantity < $product->minimum) {
                    $remainingQuantity = $product->minimum - $in_stock->quantity;
                    $min = Minimal::find()->where(['stock_id' => $in_stock->id])->one();
                    if ($min) {
                        $min->quantity = $remainingQuantity;
                        $min->save(false);
                    }else{
                        $minimum = new Minimal();
                        $minimum->stock_id = $in_stock->id;
                        $minimum->quantity = $remainingQuantity;
                        $minimum->save(false);
                    }
                }
                //// save minimum/////

                $stocking_in->reference = $stocking_out->id;
                $stocking_out->reference = $stocking_in->id;
                $stocking_in->save(false);
                $stocking_out->save(false);
                //// save references ////



                // Keeping journal entry  //
                    $amount = $inventory_cost;
                    $start = new Transaction();
                    $start->description = "Stocking Product ";
                    $start->reference = $in_stock->id;
                    $start->reference_type = "Stock";
                    if($start->save(false)){
                    
                    // Depiting TO Inventory//
                        $t_inventory = new Entry();
                        $account = $toAccount;
                        $t_inventory->transaction_id = $start->id; 
                        $t_inventory->account_id = $account->id; 
                        $t_inventory->is_depit = 'yes'; 
                        $t_inventory->amount = $amount; 
                        $t_inventory->description = "inventory Value Increased"; 
                        $t_inventory->date = date('Y-m-d'); 
                        $t_inventory->balance = $account->balance + $amount; 
                        if($t_inventory->save(false)){
                            $account->balance += $amount;
                            $account->save(false); 
                        }
                    // Depiting TO Inventory//

                    // Crediting FROM Inventory//
                        $f_inventoy = new Entry();
                        $account = $fromAccount;
                        $f_inventoy->transaction_id = $start->id; 
                        $f_inventoy->account_id = $account->id; 
                        $f_inventoy->is_depit = 'no'; 
                        $f_inventoy->amount = $amount; 
                        $f_inventoy->description = "inventory Value Decreased"; 
                        $f_inventoy->date = date('Y-m-d'); 
                        $f_inventoy->balance = $account->balance - $amount; 
                        if($f_inventoy->save(false)){
                            $account->balance -= $amount;
                            $account->save(false); 
                        }
                    // Crediting FROM Inventory//
                    }
                // Keeping journal entry  //
                Yii::$app->getSession()->setFlash('success', ['type' => 'success']);
                return $this->redirect(['inventory/index']);

            }
            Yii::$app->getSession()->setFlash('error', ['type' => 'error']);
            return $this->redirect(['inventory/index']);
        }
        return $this->renderAjax('transfere', ['trans' => $trans]);

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
