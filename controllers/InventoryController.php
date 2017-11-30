<?php

namespace app\controllers;

use Yii;

use app\models\Inventory;
use app\models\Stock;
use app\models\SystemAccount;
use app\models\InventorySearch;
use app\models\StockSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


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

    public function actionTest()
    {
        return $this->render('_stocking');
    }
    
    public function actionIndex()
    {   
        $inventories = Inventory::find()->all();
        $searchModel = new StockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
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
            'searchModel' => $searchModel,
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
            // $transaction = \Yii::$app->db->beginTransaction();
            //  try {
            //         $flag = $model->save(false)
            //         if (! ($flag = $modelItem->save(false))) {
            //             $transaction->rollBack();
            //             //set flash success
            //             break;
            //         }
            //         if ($flag) {
            //             $transaction->commit();
            //         }
            //     }
            //     catch (Exception $e) {
            //         $transaction->rollBack();
            //     }
            // // $transaction ////

            if($model->save()){
                
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
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
