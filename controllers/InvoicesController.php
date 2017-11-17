<?php

namespace app\controllers;

use Yii;
use app\models\Invoices;

use app\models\InvoiceProduct;
use app\models\Product;
use app\models\Stock;
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

    public function actionDetails($id)
    {
        $stock = Stock::findOne($id);
        $product = Product::find()->where(['id' => $stock->product_id])->one();
        // if($product){
            return \yii\helpers\Json::encode([
                'selling_price'=>$product->selling_price,
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
            $payment->save();
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
                $model->save();

            }else{
                $model->status = "paid";
                $model->save();
            }
        // Fixing Invoice Status //

        // Keeping journal entry by registering the cash in //
            $start = new Transaction();
            $start->description = "Paying for invoice ".$model->id;
            $start->reference = $model->id;
            $start->reference_type = "Invoices";
            if($start->save()){
            
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
                if($cash->save()){
                    $account->balance += $payment->amount;
                    $account->save(); 
                }
            // Depiting Cash//

            // Crediting Client Account//
                $recievable = new Entry();
                $account = $clientAccount;
                $recievable->transaction_id = $start->id; 
                $recievable->account_id = $account->id; 
                $recievable->is_depit = 'no'; 
                $recievable->amount = $payment->amount; 
                $recievable->description = "recievable Cash Increased because of selling products in this invoice"; 
                $recievable->date = date('Y-m-d'); 
                $recievable->balance = $account->balance + $payment->amount; 
                if($recievable->save()){
                    $account->balance -= $payment->amount;
                    $account->save(); 
                }
            // Crediting Client Account//
            }
        // Keeping journal entry by registering the cash in //


            return $this->render('view', [
                'model' => $model,
            ]);

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

            return $this->render('view', [
            'model' => $model,
        ]);

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

            return $this->render('view', [
            'model' => $model,
        ]);

        }

        return $this->renderAjax('promise', [
            'model' => $model,
            'outstanding' => $outstanding,
        ]);

    }

    /**
     * Lists all Invoices models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InvoicesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Invoices model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $model = $this->findModel($id);
        // $products = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Invoices model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Invoices();
        $modelsItem = [new InvoiceProduct];

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
                    'modelsItem' => (empty($modelsItem)) ? [new InvoiceProduct] : $modelsItem
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
                            $stock = Stock::find()->where(['id' => $modelItem->product_id])->one();

                            if($modelItem->quantity <= $stock->quantity && $modelItem->quantity > 0){
                                $product = Product::findOne($stock->product_id);
                                $modelItem->product_id = $product->id;
                                $modelItem->buying_rate = $product->buying_price;

                                // So far we do not allow seller to sell for more or less
                                $modelItem->selling_rate = $product->selling_price;
                                
                                //calculate total cost of item sold using buying_price
                                $expense += ($product->buying_price * $modelItem->quantity); 

                                $stock->quantity -= $modelItem->quantity;
                                $stock->save();
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
                            $inventoryAccount = SystemAccount::find()->where(['id' => $inventory->system_account_id])->one();
                        /// temperory until we fix invoices to specific inventory
                    }
                    if ($flag) {
                        $transaction->commit();

                        // Record Entry if payment is cash ////
                $start = new Transaction();
                $start->description = "Selling Products";
                $start->reference = $model->id;
                $start->reference_type = "Invoices";
                if($start->save()){
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
                            if($cash->save()){
                                $account->balance += $cashPaid;
                                $account->save(); 
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
                            if($sales->save()){
                                $account->balance += $salesAmount;
                                $account->save(); 
                            }
                        //// Credit Sales account + balance ////

                        //// Depit Sale_expenses account + balance////
                            $sales_expenses = new Entry();
                            $account = SystemAccount::find()->where(['system_account_name' => 'sales expenses'])->one();
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
                            if($cash->save()){
                                $account->balance += $cashPaid;
                                $account->save(); 
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
                            $account = SystemAccount::find()->where(['system_account_name' => 'sales expenses'])->one();
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
                            $account = SystemAccount::find()->where(['system_account_name' => 'sales expenses'])->one();
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
                
            } ///end of transaction saved


                        return $this->redirect(['index']);
                    }
                } //end of try
                 catch (Exception $e) {
                    $transaction->rollBack();
                } //end of catch
            } //end of if(valid)

        }// end of (model->load()) 
            return $this->render('_form', [
                'model' => $model,
                'modelsItem' => (empty($modelsItem)) ? [new InvoiceProduct] : $modelsItem
            ]);                      
    }

    /**
     * Updates an existing Invoices model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
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
