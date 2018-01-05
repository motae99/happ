<?php

namespace app\controllers;

use yii\helpers\Html;

use Yii;
use app\models\Client;
use app\models\Invoices;
use app\models\SystemAccount;
use app\models\Transaction;
use app\models\ClientSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;


/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends Controller
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
     * Lists all Client models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionClear($id)
    {   
        $model = $model = Client::findOne($id);
        if($model->load(Yii::$app->request->post())){
          $amount = $model->clear;
          $clientAccount = $model->recievable;
          $cashAccount = SystemAccount::find()->where(['system_account_name' => 'cash'])->one();
            

        // Keeping journal entry by registering the cash in //
            $start = new Transaction();
            $start->description = "Clearing ".$model->id;
            $start->reference = $model->id;
            $start->reference_type = "Clearing";
            if($start->save(false)){
              //// Depit Cash account + balance////
              $cash = Yii::$app->mycomponent->increase($cashAccount, $amount, $start->id);
              //// Credut ClientRecievable account - balance////
              $recievable = Yii::$app->mycomponent->decrease($clientAccount, $amount, $start->id);

            
        // Keeping journal entry by registering the cash in //


            return $this->redirect(['view', 'id' => $model->id]);
          }
        }

        // return $this->renderAjax('cash', [
        //     'model' => $model,
        //     'payment' => $payment,
        // ]);

    }

    /**
     * Displays a single Client model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $model = Client::findOne($id);
        $invoices = $model->invoices;

        return $this->render('view', [
            'model' => $model,
            'invoices' => $invoices,
        ]);
    }

    // public function actionPdf($id, $start=NULL,$end=NULL)
    // {   
    //     $model = Client::findOne($id);
    //     $invoices = Invoices::find()
    //                 ->where(['client_id'=> $model->id])
    //                 ->all();
    //                 // ->andWhere(['between', 'date', $start, $end])
    //                 // ->count();

    //     $html = $this->renderPartial('font'
    //         ,[
    //             'model' => $model,
    //             'invoices' => $invoices,
    //         ]
    //         );
    //     // $s = Semester::find()->where(['id' => $sem_id])->one();
    //     // $level = $s->sem_name;

    //     $fName = $model->id." ".date('M-d');
    //     return Yii::$app->exportPdf->exportData('Attendance Report',$fName,$html);
    // }

    public function actionPdf($id, $start=NULL,$end=NULL) {
        $model = Client::findOne($id);
        $invoices = Invoices::find()
                    ->where(['client_id'=> $model->id])
                    ->all();
                    // ->andWhere(['between', 'date', $start, $end])
                    // ->count();

        // get your HTML raw content without any layouts or scripts
        // $content = $this->renderPartial('invoices',[ 'model' => $model,'invoices' => $invoices,]);
        $content = $this->renderPartial('font'
                        ,[
                            'model' => $model,
                            'invoices' => $invoices,
                        ]);
        $arr = [
          'odd' => [
            'L' => [
              'content' => '$title',
              'font-size' => 10,
              'font-style' => 'B',
              'font-family' => 'serif',
              'color'=>'#27292b'
            ],
            'C' => [
              'content' => 'Page - {PAGENO}/{nbpg}',
              'font-size' => 10,
              'font-style' => 'B',
              'font-family' => 'serif',
              'color'=>'#27292b'
            ],
            'R' => [ 
              'content' => 'Printed @ {DATE j-m-Y}',
              'font-size' => 10,
              'font-style' => 'B',
              'font-family' => 'serif',
              'color'=>'#27292b'
            ],
            'line' => 1,
          ],
          'even' => []
        ];
        $src = Yii::getAlias('@web').'/data/logo.png';
        $image=Html::img($src,['alt'=>'No Image','width'=>90, 'height'=>70]);
        $cssInline = ' body { font-family: AlBattar;}';
        // if(Yii::$app->language == 'ar') : $cssInline .= ' body { direction: rtl; } '; endif;
        $pdf = new Pdf([
            // 'defaultFont' => 'DroidKufi',
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required


            'cssInline' => $cssInline, 
             // set mPDF properties on the fly
            'options' => ['title' => 'My Title'],
             // call mPDF methods on the fly
            'methods' => [ 
                // 'SetHeader'=>['<table style="border-bottom:1.6px solid #999998;border-top:hidden;border-left:hidden;border-right:hidden;width:100%;"><tr style="border:hidden"><td vertical-align="center" style="width:35px;border:hidden" align="left">'.$image.'</td><td style="border:hidden;text-align:center;color:#555555;"><b style="font-size:22px;">'.'MBBS'.'</b><br/><span style="font-size:18px">'.'$level'.'<br>'.'$subject'.'</td></tr></table>'], 
                'SetFooter'=>[$arr],
            ]
        ]);
        $mpdf = $pdf->api;

        $mpdf->WriteHTML('<watermarkimage src='.$src.' alpha="0.33" size="100,80"/>');
        $mpdf->showWatermarkImage = true;
        
        // return the pdf output as per the destination setting
        return $pdf->render(); 
    }

    public function actionCreate()
    {
        $model = new Client();

        if ($model->load(Yii::$app->request->post())) {
          $model->account_id = 00;
          $model->created_at = new \yii\db\Expression('NOW()');
            if($model->save(false)){
                $account = new SystemAccount();
                $max = SystemAccount::find()->where(['group'=> 'client'])->max('account_no');
                if($max){
                    $account->account_no = $max+1;
                }else{
                    $account->account_no = 1200;
                }
                $account->system_account_name = $model->client_name;
                $account->account_type_id = 1;
                $account->description = "Client ".$model->client_name." Recievable account";
                if ($model->balance != "") {
                    $account->opening_balance = $model->balance;
                    $account->balance = $model->balance;
                }else{
                    $account->opening_balance = 0;
                    $account->balance = 0;
                }

                $account->group = "client";
                $account->to_increase = 'debit';
                $account->created_at = new \yii\db\Expression('NOW()');
                $account->created_by = 1;
                if($account->save(false)){
                    $model->account_id = $account->id;
                    $model->save(false);
                }

            }
            return $this->redirect(['index']);
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Client model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            // print_r($model);
            // die();
            $model->save(false);
            return $this->redirect(['index']);
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Client model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

    /**
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Client::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
