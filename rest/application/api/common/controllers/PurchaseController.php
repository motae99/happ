<?php
namespace api\common\controllers;
use \Yii as Yii;
use api\models\User;
use api\common\models\Purchase;
use api\common\models\Client;
use yii\db\Expression;


class PurchaseController extends \api\components\ActiveController
{
    public $modelClass = '\api\common\models\Purchase';

    public function accessRules()
    {
        return [
            [
                'allow' => false,
                'roles' => ['?'],
            ],
            [
                'allow' => true,
                'actions' => [
                    'view',
                    'create',
                    'index',
                ],
                'roles' => ['@'],
            ],
            [
                'allow' => true,
                'actions' => ['update', 'accept', 'reject', 'only'],
                'roles' => ['@'],
                'scopes' => ['admin'],
            ]
        ];
    }

    public function actions(){
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['create']);
        // unset($actions['update']);
        return $actions;
    }

     public function actionOnly($id){
        $client = Client::findOne($id);
        $data = Purchase::find()->where(['created_by' => $client->id])->all();
        return array('Purchase' => $data);

    }

    public function actionIndex(){
        $user = Yii::$app->user->identity;
         if ($user->id === 1) {
            $data = Purchase::find()->all();
        }else{
            $data = Purchase::find()->where(['created_by' => $user->id])->all();
        }
        return  array('Purchases' => $data);

    }

    // public function actionUpdate($id){
    //     $model = Purchase::findOne($id);
    //     $model->updated_by = 1;
    //     $model->updated_at = new Expression('NOW()');
    //     $model->status = 'accepted';
    //     if ($model->save()) {
    //         return array('success' => 1);
    //     }else{
    //         return array('success' => 0);
    //     }
    // }


    public function actionCreate(){
        $model = new Purchase();
        $user = Yii::$app->user->identity;
        $body = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        $model->load($body, '');
        $model->required_item = $body['required_item'];
        $model->amount = $body['amount'];
        $model->created_by = $user->id;
        $model->created_at = new Expression('NOW()');
        $model->status = 'pending';
        if ($model->save()) {
            $gcm = Yii::$app->gcm;
            $gcm->send($user->google_token, $model);
            return array('success' => 1);
        }else{
            return array('success' => 0);
        }
  
    }

    public function actionAccept($id)
    {   
        $user = Yii::$app->user->identity;
        $model = Purchase::findOne($id);
        $model->updated_by = 1;
        $model->updated_at = new Expression('NOW()');
        $model->status = "granted";
        if ($model->save()) {
            $gcm = Yii::$app->gcm;
            $gcm->send($user->google_token, $model);
            return array('success' => 1);
        }else{
            return array('success' => 0);
        }
        
    }


    public function actionReject($id)
    {
        $user = Yii::$app->user->identity;
        $model = Purchase::findOne($id);
        $model->updated_by = 1;
        $model->updated_at = new Expression('NOW()');
        $model->status = "rejected";
        if ($model->save()) {
            $gcm = Yii::$app->gcm;
            $gcm->send($user->google_token, $model);
            return ['success' => 1];
        }else{
            return ['success' => 0];
        }
        
    }
 

}