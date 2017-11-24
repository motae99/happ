<?php

namespace app\controllers;

use Yii;
use app\models\Invoices;
use yii\helpers\ArrayHelper;


use app\models\InvoiceProduct;
use app\models\Product;
use app\models\Stock;
use app\models\Stocking;
use app\models\Model;
use app\models\Payments;
use app\models\Client;
use app\models\Outstanding;
use app\models\SystemAccount;
use app\models\Transaction;
use app\models\Entry;
use app\models\Inventory;
use app\models\InvoicesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InvoicesController implements the CRUD actions for Invoices model.
 */
class InvoicesController extends Controller
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

    public function actionReconcileDelete($id)
    {
        $outstanding = Outstanding::findOne($id);
        $model = $this->findModel($outstanding->invoice_id);
        $outstanding->delete();
        return $this->redirect(['view', 'id' => $model->id]);

    }
    
    public function actionReconcile($account_id, $invoice_id, $outstanding_id)
    {
        $model = Invoices::findOne($invoice_id);
        $cashAccount = SystemAccount::find()->where(['id' => $account_id])->one();
        $client = Client::findOne($model->client_id);
        $clientAccount = SystemAccount::find()->where(['id' => $client->account_id])->one();
        
        $payment = new Payments();

        $outstanding = Outstanding::findOne($outstanding_id);

        if($outstanding->type == 'cheque'){
            $payment->mode = "cheque";
            $payment->bank_name = $outstanding->bank;
            $payment->cheque_no = $outstanding->cheque_no;
            $payment->cheque_date = $outstanding->cheque_date;
        }else{
            $payment->mode = "cash";
        }


        // Saving the payment //
            $payment->amount = $outstanding->amount;
            $payment->invoice_id = $model->id;
            $payment->system_account_id = $cashAccount->id ;
            $payment->save(false);
        // Saving the payment //

        // Fixing outstanding Status//
            $outstanding->payment_id = $payment->id;
            $outstanding->status = 'clear';
            $outstanding->save(false);
        // Fixing outstanding Status//

        // Fixing Invoice Status //
            $total_cash = $model->payments;
            $total_paid = 0;
            if($total_cash){
                foreach ($total_cash as $p) {
                    $total_paid += $p->amount ;
                }
            }
            $remaining = $model->amount - $total_paid ;

            if($remaining > 0){
                $model->status = "partially";
                $model->save(false);

            }else{
                $model->status = "paid";
                $model->save(false);
            }
        // Fixing Invoice Status //

        // Keeping journal entry by registering the cash in //
            $start = new Transaction();
            $start->description = "Reconciling payment for invoice ".$model->id;
            $start->reference = $model->id;
            $start->reference_type = "Invoices";
            if($start->save(false)){
            
            // Depiting Cash//
                $cash = new Entry();
                $account = $cashAccount;
                $cash->transaction_id = $start->id; 
                $cash->account_id = $account->id; 
                $cash->is_depit = 'yes'; 
                $cash->amount = $payment->amount; 
                $cash->description = "Cash Increased because of selling products in this invoice"; 
                $cash->date = date('Y-m-d'); 
                $cash->balance = $account->balance + $payment->amount; 
                if($cash->save(false)){
                    $account->balance += $payment->amount;
                    $account->save(false); 
                }
            // Depiting Cash//

            // Crediting Client Account//
                $recievable = new Entry();
                $account = $clientAccount;
                $recievable->transaction_id = $start->id; 
                $recievable->account_id = $account->id; 
                $recievable->is_depit = 'no'; 
                $recievable->amount = $payment->amount; 
                $recievable->description = "recievable Amount decreased for paying this invoice"; 
                $recievable->date = date('Y-m-d'); 
                $recievable->balance = $account->balance - $payment->amount; 
                if($recievable->save(false)){
                    $account->balance -= $payment->amount;
                    $account->save(false); 
                }
            // Crediting Client Account//

            // Linking Payment with this transaction //
                $payment->transaction_id = $start->id;
                $payment->save(false);
            // Linking Payment with this transaction //
            }
        // Keeping journal entry by registering the cash in //


        return $this->redirect(['view', 'id' => $model->id]);

    }

    public function actionDetails($product_id, $inventory_id)
    {
        $product = Product::find()->where(['id' => $product_id])->one();
        $stock = Stock::find()
                    ->where(['product_id' => $product->id])
                    ->andWhere(['inventory_id' => $inventory_id])->one();
        $current_rate = Yii::$app->mycomponent->rate();
        $highest_rate = $stock->highest_rate;
        if ($current_rate > $highest_rate) {
           $price = $product->selling_price*$current_rate; 
        }else{
          $price = $product->selling_price*$highest_rate; 
        }
        // if($product){
            return \yii\helpers\Json::encode([
                'selling_price'=>$price,
                'quantity'=>$stock->quantity,
            ]);   
        // }

    }

    public function actionCash($id)
    {   
        $model = $this->findModel($id);
        $payment = new Payments();

        if($payment->load(Yii::$app->request->post())){
            
            $cashAccount = SystemAccount::find()->where(['system_account_name' => 'cash'])->one();
            $client = Client::findOne($model->client_id);
            $clientAccount = SystemAccount::find()->where(['id' => $client->account_id])->one();
        // Saveing the payment //
            $payment->invoice_id = $model->id;
            $payment->system_account_id = $cashAccount->id ;
            $payment->mode = "cash";
            $payment->save(false);
        // Saveing the payment //

        // Fixing Invoice Status //
            $total_cash = $model->payments;
            $total_paid = 0;
            if($total_cash){
                foreach ($total_cash as $p) {
                    $total_paid += $p->amount ;
                }
            }
            $remaining = $model->amount - $total_paid ;

            if($remaining > 0){
                $model->status = "partially";
                $model->save(false);

            }else{
                $model->status = "paid";
                $model->save(false);
            }
        // Fixing Invoice Status //

        // Keeping journal entry by registering the cash in //
            $start = new Transaction();
            $start->description = "Paying for invoice ".$model->id;
            $start->reference = $model->id;
            $start->reference_type = "Invoices";
            if($start->save(false)){
            
            // Depiting Cash//
                $cash = new Entry();
                $account = $cashAccount;
                $cash->transaction_id = $start->id; 
                $cash->account_id = $account->id; 
                $cash->is_depit = 'yes'; 
                $cash->amount = $payment->amount; 
                $cash->description = "Cash Increased because of paying for this invoice"; 
                $cash->date = date('Y-m-d'); 
                $cash->balance = $account->balance + $payment->amount; 
                if($cash->save(false)){
                    $account->balance += $payment->amount;
                    $account->save(false); 
                }
            // Depiting Cash//

            // Crediting Client Account//
                $recievable = new Entry();
                $account = $clientAccount;
                $recievable->transaction_id = $start->id; 
                $recievable->account_id = $account->id; 
                $recievable->is_depit = 'no'; 
                $recievable->amount = $payment->amount; 
                $recievable->description = "recievable amount decreased because of paying this invoice"; 
                $recievable->date = date('Y-m-d'); 
                $recievable->balance = $account->balance - $payment->amount; 
                if($recievable->save(false)){
                    $account->balance -= $payment->amount;
                    $account->save(false); 
                }
            // Crediting Client Account//

            // Linking Payment with this transaction //
                $payment->transaction_id = $start->id;
                $payment->save(false);
            // Linking Payment with this transaction //
            }
        // Keeping journal entry by registering the cash in //


            return $this->redirect(['view', 'id' => $model->id]);

        }
        return $this->renderAjax('cash', [
            'model' => $model,
            'payment' => $payment,
        ]);

    }

    public function actionCheque($id)
    {   
        $model = $this->findModel($id);
        $outstanding = new Outstanding();

        if($outstanding->load(Yii::$app->request->post())){

            $outstanding->invoice_id = $model->id;
            $outstanding->client_id = $model->client_id ;
            $outstanding->type = "cheque";
            $outstanding->status = "outstanding";
            $outstanding->save(false);
            //set flash success

            return $this->redirect(['view', 'id' => $model->id]);

        }
        return $this->renderAjax('cheque', [
            'model' => $model,
            'outstanding' => $outstanding,
        ]);

    }

    public function actionPromise($id)
    {   
        $model = $this->findModel($id);
        $outstanding = new Outstanding();

        if($outstanding->load(Yii::$app->request->post())){

            $outstanding->invoice_id = $model->id;
            $outstanding->client_id = $model->client_id ;
            $outstanding->type = "promise";
            $outstanding->status = "outstanding";
            $outstanding->save(false);
            //set flash success

            return $this->redirect(['view', 'id' => $model->id]);

        }

        return $this->renderAjax('promise', [
            'model' => $model,
            'outstanding' => $outstanding,
        ]);

    }

    public function actionIndex()
    {
        $searchModel = new InvoicesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {   
        $model = $this->findModel($id);
        // $products = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    
    public function actionCreate($id)
    {
        $model = new Invoices();
        $modelsItem = [new InvoiceProduct];
        $inventory = Inventory::findOne($id);

        if($model->load(Yii::$app->request->post()) ){

            $modelsItem = Model::createMultiple(InvoiceProduct::classname());
            Model::loadMultiple($modelsItem, Yii::$app->request->post());

            
            $client_id = $_POST['Invoices']['client_id'];
            $client = Client::findOne($client_id);
            $clientAccount = SystemAccount::find()->where(['id' => $client->account_id])->one();
            $cashAccount = SystemAccount::find()->where(['system_account_name' => 'cash'])->one();
            $expense = 0;

            if(!($clientAccount)){
                // we have a problem
                // set flash error with massage 
                return $this->render('_form', [
                    'model' => $model,
                    'modelsItem' => (empty($modelsItem)) ? [new InvoiceProduct] : $modelsItem,
                    'inventory' => $inventory
                ]);    
            }
            
            if($model->amount == $model->pay){
                //invoice method cash, status paid
                $invoiceMethod = "cash";
                $invoiceDate = date('Y-m-d');
                $invoiceStatus = "paid";

                // new payment data 
                $paymentAvailable = True;
                $paymentSystemAccountId = $cashAccount->id;
                $paymentAmount = $model->amount;
                $paymentMode = "cash";

                // use Cash account on transaction 
                $fullPaymentCash = True;
                $partialPaymentCash = False;
                $noCash = False;


                $cashPaid = $model->amount;

                // use sales account with Total 
                $salesAmount = $model->amount;

            }elseif(($model->pay > 0) && ($model->pay < $model->amount)){
                //invoice method credit, status partiallyPaid
                $invoiceMethod = "credit";
                $invoiceDate = date('Y-m-d');
                $invoiceStatus = "partially";

                // new payment with amount of model->pay 
                $paymentAvailable = True;
                $paymentSystemAccountId = $cashAccount->id;
                $paymentAmount = $model->pay;
                $paymentMode = "cash";

                // use Cash account with model->pay amount 
                $fullPaymentCash = False;
                $partialPaymentCash = True;
                $noCash = False;
                $cashPaid = $model->pay;
                // use client account with ($model->amount - $model->pay) 
                $recievableAmount = $model->amount - $model->pay;

                // use sales account with Total 
                $salesAmount = $model->amount;

            }else{
                //invoice method credit, status unPaid
                $invoiceMethod = "credit";
                $invoiceDate = date('Y-m-d');
                $invoiceStatus = "unpaid";

                //We have no payment
                $paymentAvailable = false;

                // use client account with model->amount 
                $fullPaymentCash = False;
                $partialPaymentCash = False;
                $noCash = True;
                $recievableAmount = $model->amount;

                // use sales account with Total 
                $salesAmount = $model->amount;
            }
            $model->method = $invoiceMethod;
            $model->date = $invoiceDate;
            $model->status = $invoiceStatus;
            $model->cost = 0;
        
            // validate all models
            $valid = $model->validate();
            //$valid = Model::validateMultiple($modelsItem) && $valid;


           if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if($flag = $model->save(false)) {
                        if($paymentAvailable){
                            $payment = new Payments();
                            $payment->invoice_id = $model->id;
                            $payment->system_account_id = $paymentSystemAccountId;
                            $payment->amount = $paymentAmount ;
                            $payment->mode = $paymentMode ;
                            $payment->save(false);
                        }
                       
                        foreach ($modelsItem as $modelItem){       
                            $modelItem->invoice_id = $model->id;

                            /// see the stock ///
                            $stock = Stock::find()
                                    ->where(['product_id' => $modelItem->product_id])
                                    ->andWhere(['inventory_id' => $inventory->id])->one();

                            if($modelItem->quantity <= $stock->quantity && $modelItem->quantity > 0){
                                $product = Product::findOne($stock->product_id);
                                $modelItem->product_id = $product->id;
                                $modelItem->buying_rate = $product->buying_price;

                                

                                // So far we do not allow seller to sell for more or less
                                $current_rate = Yii::$app->mycomponent->rate();
                                $highest_rate = $stock->highest_rate;
                                if($modelItem->selling_rate == $product->selling_price*$current_rate){
                                    $modelItem->d_rate = $current_rate;
                                }else{
                                    $modelItem->d_rate = $highest_rate;
                                }                                
                                $modelItem->selling_rate = $product->selling_price;
                                //calculate total cost of item sold using buying_price
                                $stockings = Stocking::find()
                                    ->where(['product_id' => $modelItem->product_id])
                                    ->andWhere(['inventory_id' => $inventory->id])
                                    ->andWhere(['transaction' => 'in'])
                                    ->orderBy(['rate' => SORT_DESC])
                                    ->all();
                                $q = $modelItem->quantity;
                                
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
                                    
                                

                                $stocking_out = new Stocking();
                                $stocking_out->inventory_id = $stock->inventory_id;
                                $stocking_out->product_id = $stock->product_id;
                                $stocking_out->buying_price = $stock->avg_cost;
                                $stocking_out->selling_price = $modelItem->selling_rate;
                                $stocking_out->quantity = $modelItem->quantity;
                                $stocking_out->rate = $modelItem->d_rate;
                                $stocking_out->transaction = "out";
                                $stocking_out->save(false);



                                $stock->quantity -= $modelItem->quantity;
                                $stock->save(false);

                                //// save minimum/////
                                if ($stock->quantity < $product->minimum) {
                                    $minimum = new minimal();
                                    $minimum->stock_id = $stock->id;
                                    $minimum->quantity = $remaining;
                                    $minimum->save(false);
                                }
                                //// save minimum/////
                                

                                $expense += ($stock->avg_cost*$modelItem->quantity); 
                                //set flash success
                                if (! ($flag = $modelItem->save(false))) {
                                    $transaction->rollBack();
                                    //set flash success
                                    break;
                                }
                            }
                        }

                        /// temperory until we fix invoices to specific inventory
                            $inventory = Inventory::find()->where(['id' => $stock->inventory_id])->one();
                            $inventoryAccount = SystemAccount::find()->where(['id' => $inventory->asset_account_id])->one();
                            $inventoryExpenseAccount = SystemAccount::find()->where(['id' => $inventory->expense_account_id])->one();
                        /// temperory until we fix invoices to specific inventory
                    }
                    if ($flag) {
                        $transaction->commit();

                        // Record Entry if payment is cash ////
                $start = new Transaction();
                $start->description = "Selling Products";
                $start->reference = $model->id;
                $start->reference_type = "Invoices";
                if($start->save(false)){
                    if($fullPaymentCash){
                        //// Depit Cash account + balance////
                            $cash = new Entry();
                            $account = $cashAccount;
                            $cash->transaction_id = $start->id; 
                            $cash->account_id = $account->id; 
                            $cash->is_depit = 'yes'; 
                            $cash->amount = $cashPaid; 
                            $cash->description = "Cash Increased because of selling products in this invoice"; 
                            $cash->date = date('Y-m-d'); 
                            $cash->balance = $account->balance + $cashPaid; 
                            if($cash->save(false)){
                                $account->balance += $cashPaid;
                                $account->save(false); 
                            }
                        //// Depit Cash account + balance////

                        //// Credit Sales account + balance////
                            $sales = new Entry();
                            $account = SystemAccount::find()->where(['system_account_name' => 'sales'])->one();
                            $sales->transaction_id = $start->id; 
                            $sales->account_id = $account->id; 
                            $sales->is_depit = 'no'; 
                            $sales->amount = $salesAmount; 
                            $sales->description = "Revenue is been counted for this sale"; 
                            $sales->date = date('Y-m-d'); 
                            $sales->balance = $account->balance + $salesAmount; 
                            if($sales->save(false)){
                                $account->balance += $salesAmount;
                                $account->save(false); 
                            }
                        //// Credit Sales account + balance ////

                        //// Depit Sale_expenses account + balance////
                            $sales_expenses = new Entry();
                            $account = $inventoryExpenseAccount;
                            $sales_expenses->transaction_id = $start->id; 
                            $sales_expenses->account_id = $account->id; 
                            $sales_expenses->is_depit = 'yes'; 
                            $sales_expenses->amount = $expense; 
                            $sales_expenses->description = "Cost is been counted for this sale"; 
                            $sales_expenses->date = date('Y-m-d'); 
                            $sales_expenses->balance = $account->balance + $expense; 
                            if($sales_expenses->save(false)){
                                $account->balance += $expense;
                                $account->save(false); 
                            }
                        //// Depit Sale_expenses account + balance////

                        //// Credit inventory account - balance////
                            $inventory_expenses = new Entry();
                            $account = $inventoryAccount ;
                            $inventory_expenses->transaction_id = $start->id; 
                            $inventory_expenses->account_id = $account->id; 
                            $inventory_expenses->is_depit = 'no'; 
                            $inventory_expenses->amount = $expense; 
                            $inventory_expenses->description = "Cost of products for this sale"; 
                            $inventory_expenses->date = date('Y-m-d'); 
                            $inventory_expenses->balance = $account->balance - $expense; 
                            if($inventory_expenses->save(false)){
                                $account->balance -= $expense;
                                $account->save(false); 
                            }
                        //// Credit inventory account - balance////

                        // Linking Payment with this transaction //
                            $payment->transaction_id = $start->id;
                            $payment->save(false);
                        // Linking Payment with this transaction //

                    }elseif($partialPaymentCash){
                        //// Depit Cash account + balance////
                            $cash = new Entry();
                            $account = $cashAccount;
                            $cash->transaction_id = $start->id; 
                            $cash->account_id = $account->id; 
                            $cash->is_depit = 'yes'; 
                            $cash->amount = $cashPaid; 
                            $cash->description = "Cash Increased because of selling products in this invoice"; 
                            $cash->date = date('Y-m-d'); 
                            $cash->balance = $account->balance + $cashPaid; 
                            if($cash->save(false)){
                                $account->balance += $cashPaid;
                                $account->save(false); 
                            }
                        //// Depit Cash account + balance////

                        //// Depit ClientRecievable account + balance////
                            $recievable = new Entry();
                            $account = $clientAccount;
                            $recievable->transaction_id = $start->id; 
                            $recievable->account_id = $account->id; 
                            $recievable->is_depit = 'yes'; 
                            $recievable->amount = $recievableAmount; 
                            $recievable->description = "recievable Cash Increased because of selling products in this invoice"; 
                            $recievable->date = date('Y-m-d'); 
                            $recievable->balance = $account->balance + $recievableAmount; 
                            if($recievable->save(false)){
                                $account->balance += $recievableAmount;
                                $account->save(false); 
                            }
                        //// Depit ClientRecievable account + balance////

                        //// Credit Sales account + balance////
                            $sales = new Entry();
                            $account = SystemAccount::find()->where(['system_account_name' => 'sales'])->one();
                            $sales->transaction_id = $start->id; 
                            $sales->account_id = $account->id; 
                            $sales->is_depit = 'no'; 
                            $sales->amount = $salesAmount; 
                            $sales->description = "Revenue is been counted for this sale"; 
                            $sales->date = date('Y-m-d'); 
                            $sales->balance = $account->balance + $salesAmount; 
                            if($sales->save(false)){
                                $account->balance += $salesAmount;
                                $account->save(false); 
                            }
                        //// Credit Sales account + balance ////

                        //// Depit Sale_expenses account + balance////
                            $sales_expenses = new Entry();
                            $account = $inventoryExpenseAccount;
                            $sales_expenses->transaction_id = $start->id; 
                            $sales_expenses->account_id = $account->id; 
                            $sales_expenses->is_depit = 'yes'; 
                            $sales_expenses->amount = $expense; 
                            $sales_expenses->description = "Cost is been counted for this sale"; 
                            $sales_expenses->date = date('Y-m-d'); 
                            $sales_expenses->balance = $account->balance + $expense; 
                            if($sales_expenses->save(false)){
                                $account->balance += $expense;
                                $account->save(false); 
                            }
                        //// Depit Sale_expenses account + balance////

                        //// Credit inventory account - balance////
                            $inventory_expenses = new Entry();
                            $account = $inventoryAccount ;
                            $inventory_expenses->transaction_id = $start->id; 
                            $inventory_expenses->account_id = $account->id; 
                            $inventory_expenses->is_depit = 'no'; 
                            $inventory_expenses->amount = $expense; 
                            $inventory_expenses->description = "Cost of products for this sale"; 
                            $inventory_expenses->date = date('Y-m-d'); 
                            $inventory_expenses->balance = $account->balance - $expense; 
                            if($inventory_expenses->save(false)){
                                $account->balance -= $expense;
                                $account->save(false); 
                            }
                        //// Credit inventory account - balance////  

                        // Linking Payment with this transaction //
                            $payment->transaction_id = $start->id;
                            $payment->save(false);
                        // Linking Payment with this transaction //                      

                    }elseif($noCash){
                        //// Depit ClientRecievable account + balance////
                            $recievable = new Entry();
                            $account = $clientAccount;
                            $recievable->transaction_id = $start->id; 
                            $recievable->account_id = $account->id; 
                            $recievable->is_depit = 'yes'; 
                            $recievable->amount = $recievableAmount; 
                            $recievable->description = "recievable Cash Increased because of selling products in this invoice"; 
                            $recievable->date = date('Y-m-d'); 
                            $recievable->balance = $account->balance + $recievableAmount; 
                            if($recievable->save()){
                                $account->balance += $recievableAmount;
                                $account->save(); 
                            }
                        //// Depit ClientRecievable account + balance////

                        //// Credit Sales account + balance////
                            $sales = new Entry();
                            $account = SystemAccount::find()->where(['system_account_name' => 'sales'])->one();
                            $sales->transaction_id = $start->id; 
                            $sales->account_id = $account->id; 
                            $sales->is_depit = 'no'; 
                            $sales->amount = $salesAmount; 
                            $sales->description = "Revenue is been counted for this sale"; 
                            $sales->date = date('Y-m-d'); 
                            $sales->balance = $account->balance + $salesAmount; 
                            if($sales->save()){
                                $account->balance += $salesAmount;
                                $account->save(); 
                            }
                        //// Credit Sales account + balance ////

                        //// Depit Sale_expenses account + balance////
                            $sales_expenses = new Entry();
                            $account = $inventoryExpenseAccount;
                            $sales_expenses->transaction_id = $start->id; 
                            $sales_expenses->account_id = $account->id; 
                            $sales_expenses->is_depit = 'yes'; 
                            $sales_expenses->amount = $expense; 
                            $sales_expenses->description = "Cost is been counted for this sale"; 
                            $sales_expenses->date = date('Y-m-d'); 
                            $sales_expenses->balance = $account->balance + $expense; 
                            if($sales_expenses->save()){
                                $account->balance += $expense;
                                $account->save(); 
                            }
                        //// Depit Sale_expenses account + balance////

                        //// Credit inventory account - balance////
                            $inventory_expenses = new Entry();
                            $account = $inventoryAccount ;
                            $inventory_expenses->transaction_id = $start->id; 
                            $inventory_expenses->account_id = $account->id; 
                            $inventory_expenses->is_depit = 'no'; 
                            $inventory_expenses->amount = $expense; 
                            $inventory_expenses->description = "Cost of products for this sale"; 
                            $inventory_expenses->date = date('Y-m-d'); 
                            $inventory_expenses->balance = $account->balance - $expense; 
                            if($inventory_expenses->save()){
                                $account->balance -= $expense;
                                $account->save(); 
                            }
                        //// Credit inventory account - balance////
                    }
                
                    $model->transaction_id = $start->id;
                    $model->save(false);
                    } ///end of transaction saved



                    }
                } //end of try
                 catch (Exception $e) {
                    $transaction->rollBack();
                } //end of catch

                return $this->redirect(['view', 'id' => $model->id]);
            } //end of if(valid)

            return $this->redirect(['index']);

        }// end of (model->load()) 
            return $this->render('_form', [
                'model' => $model,
                'inventory' => $inventory,
                'modelsItem' => (empty($modelsItem)) ? [new InvoiceProduct] : $modelsItem
            ]);                      
    }

    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsItem = $model->invoiceProducts;

        if ($model->load(Yii::$app->request->post())) {
            

            $oldIDs = ArrayHelper::map($modelsItem, 'id', 'id');
            $modelsItem = Model::createMultiple(InvoiceProduct::classname(), $modelsItem);
            Model::loadMultiple($modelsItem, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsItem, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsItem),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            
            // $valid = Model::validateMultiple($modelsItem) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            InvoiceProduct::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsItem as $modelItem) {
                            $modelItem->invoice_id = $model->id;
                            if (! ($flag = $modelItem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('_try', [
            'model' => $model,
            'modelsItem' => (empty($modelsItem)) ? [new InvoiceProduct] : $modelsItem
        ]);
    }

    /**
     * Deletes an existing Invoices model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Invoices model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invoices the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoices::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
