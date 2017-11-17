<?php

namespace app\controllers;

use Yii;
use app\models\Inventory;
use app\models\InventoryAccount;
use app\models\SystemAccount;
use app\models\InventorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InventoryController implements the CRUD actions for Inventory model.
 */
class InventoryController extends Controller
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

    /**
     * Lists all Inventory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InventorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $inventories = Inventory::find()->all();
        foreach ($inventories as $inventory) {
            $inventory_account = $inventory->account;
            $inventory_account->balance = 0;
            $stocks = $inventory->stocks;

            $stock_value = 0;
            foreach ($stocks as $stock) {
                $product = $stock->product;
                $stock_value += $stock->quantity * $product->buying_price;
            }
                $inventory_account->balance += $stock_value;
                $inventory_account->save();

        }
        $balance = InventoryAccount::find()->sum('balance');
        $sys = SystemAccount::find()->where(['group' => 'inventory'])->one();
        $sys->balance = $balance;
        $sys->save();


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Inventory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Inventory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Inventory();

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                $account = new InventoryAccount();
                $account->inventory_id = $model->id;
                // need more work//
                $SystemAccount = SystemAccount::find()->where(['group'=> $model->account_group])->one();
                $account->system_account_id = $SystemAccount->id ;
                // $account->obening_balance = 0;
                // $account->balance = 0;
                $account->save();
                //Set flash Success//
                // need more work//
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Inventory model.
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
     * Deletes an existing Inventory model.
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
     * Finds the Inventory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Inventory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Inventory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
