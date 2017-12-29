<?php

namespace app\controllers;

use Yii;

use app\models\Inventory;
use app\models\Stock;
use app\models\Stocking;
use app\models\Minimal;
use app\models\Product;
use app\models\Transaction;
use app\models\Entry;
use app\models\SystemAccount;
use app\models\InventorySearch;
use app\models\StockSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use yii\data\ActiveDataProvider;



class InventoryController extends Controller
{
    
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
                $product = $stock->product;
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
    public function actionProduct() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $inventory_id = $parents[0];
                $products = Stock::find()
                            ->where(['inventory_id' => $inventory_id])
                            ->andWhere('quantity > 0')
                            ->all();
                foreach ($products as $p) {
                    $out[] = ['id' => $p->id, 'name' => $p->product_name];
                }
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function actionStock($id) {
        $out = [];
        $inventory_id = $id;
        if (isset($inventory_id)) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $inventory_id = $parents[0];
                $products = Stock::find()
                            ->where(['inventory_id' => $inventory_id])
                            ->andWhere('quantity > 0')
                            ->all();
                foreach ($products as $p) {
                    $out[] = ['id' => $p->id, 'name' => $p->product_name];
                }
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
    
    public function actionIndex()
    {   
        $inventories = Inventory::find()->all();
        // $searchModel = new StockSearch();
        $dataProvider =  new ActiveDataProvider([
            'query' => \app\models\Stock::find(),
            'sort'=> ['defaultOrder' => ['inventory_id'=>SORT_DESC, ]],
            // 'pagination' => false,

        ]);
        // $searchModel->search(Yii::$app->request->queryParams);
        
        // $inventories = Inventory::find()->all();
        // // foreach ($inventories as $inventory) {
        // //     $inventory_account = $inventory->account;
        // //     $inventory_account->balance = 0;
        // //     $stocks = $inventory->stocks;

        // //     $stock_value = 0;
        // //     foreach ($stocks as $stock) {
        // //         $product = $stock->product;
        // //         $stock_value += $stock->quantity * $product->buying_price;
        // //     }
        // //         $inventory_account->balance += $stock_value;
        // //         $inventory_account->save();

        // // }
        // $balance = InventoryAccount::find()->sum('balance');
        // $sys = SystemAccount::find()->where(['group' => 'inventory'])->one();
        // $sys->balance = $balance;
        // $sys->save();


        return $this->render('index', [
            // 'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'inventories' => $inventories,
        ]);
    }

    
    public function actionView($id)
    {   
        $model = $this->findModel($id);   
        // $dataProvider =  new ActiveDataProvider([
        //     'query' => Stock::find()->where(['inventory_id'=>$model->id])->all(),
        //     // 'sort'=> ['defaultOrder' => ['date'=>SORT_DESC, 'account_id'=>SORT_ASC, 'timestamp'=>SORT_ASC]],

        // ]);
        // $searchModel = new StockSearch();

        return $this->render('view', [
            'model' => $model,
            // 'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider,
        ]);
    }

    
    public function actionCreate()
    {
        $model = new Inventory();

        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = new \yii\db\Expression('NOW()');
            $model->created_by = 1;
            $model->asset_account_id = 000;
            $model->expense_account_id = 000;


            if($model->save(false)){
                
                //// CREATING ASSET ACCOUNT ////
                    $asset = new SystemAccount();
                    $max = SystemAccount::find()->where(['group'=> 'inventory'])->max('account_no');
                    if($max){
                        $asset->account_no = $max+1;
                    }else{
                        $asset->account_no = 1140;
                    }
                    $asset->system_account_name = $model->alias.' Value';
                    $asset->account_type_id = 1;
                    $asset->description = $model->name;
                    $asset->opening_balance = 0;
                    $asset->balance = 0;
                    $asset->group = 'inventory';
                    $asset->to_increase = 'debit';
                    $asset->color_class = $model->color_class;
                    $asset->created_at = new \yii\db\Expression('NOW()');
                    $asset->created_by = 1;
                    $asset->save(false);
                //// CREATING ASSET ACCOUNT ////
                
                //// CREATING EXPENSE ACCOUNT ////
                    $expense = new SystemAccount();
                    $max = SystemAccount::find()->where(['group'=> 'inventory expense'])->max('account_no');
                    if($max){
                        $expense->account_no = $max+1;
                    }else{
                        $expense->account_no = 5140;
                    }
                    $expense->system_account_name = $model->alias.' Cost';
                    $expense->account_type_id = 5;
                    $expense->description = $model->name.' Cost Of Goods Sold';
                    $expense->opening_balance = 0;
                    $expense->balance = 0;
                    $expense->group = 'inventory expense';
                    $expense->to_increase = 'debit';
                    $expense->color_class = $model->color_class;
                    $expense->created_at = new \yii\db\Expression('NOW()');
                    $expense->created_by = 1;
                    $expense->save(false);
                //// CREATING EXPENSE ACCOUNT ////

                //// Saving Values to Inventory////
                    $model->asset_account_id = $asset->id;
                    $model->expense_account_id = $expense->id;
                    $model->save(false);
                //// Saving Values to Inventory////


                //// Set flash Properties//
                    Yii::$app->getSession()->setFlash('success', ['type' => 'success']);
                //// Set flash Properties//

            }else{
                //// Set flash Properties//
                    Yii::$app->getSession()->setFlash('error', ['type' => 'error']);
                //// Set flash Properties//
            }
            return $this->redirect(['index']);
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->save(false);
            //// Set flash Properties//
                Yii::$app->getSession()->setFlash('success', ['type' => 'success']);
            //// Set flash Properties//

            return $this->redirect(['index']);
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        

        return $this->redirect(['index']);
    }

    
    protected function findModel($id)
    {
        if (($model = Inventory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
