<?php
namespace api\common\controllers;
use \Yii as Yii;
use api\models\User;
use api\common\models\Vacation;
use api\common\models\Client;
use yii\db\Expression;



class VacationController extends \api\components\ActiveController
{
    public $modelClass = '\api\common\models\Vacation';

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
                    'index',
                    'create',
                    'delete'
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
        unset($actions['create']);
        unset($actions['index']);
        unset($actions['update']);
        return $actions;
    }

    public function actionOnly($id){
        $client = Client::findOne($id);
        $data = Vacation::find()->where(['created_by' => $client->id])->all();
        return array('Vacation' => $data);

    }

    public function actionIndex(){
        $user = Yii::$app->user->identity;
        if ($user->id === 1) {
            $data = Vacation::find()->all();
        }else{
            $data = Vacation::find()->where(['created_by' => $user->id])->all();
        }
        return ['Vacation' => $data];

    }

    public function actionCreate(){
        $model = new Vacation();
        $body = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        $user = Yii::$app->user->identity;
        $model->type = $body['type'];
        $model->purpose = $body['purpose'];
        $model->remaining = $body['remaining'];
        $model->contact_no = $body['contact_no'];
        $model->date = $body['date'];
        $model->status = 'pending';
        $model->created_by = $user->id;
        $model->created_at = new Expression('NOW()');
        if ($model->save()) {
            $gcm = Yii::$app->gcm;
            $gcm->send($user->google_token, $model);
            return array('success' => 1);
        }else{
            return array('success' => 0);
        }
        
    }

    // public function actionUpdate($id){
    //     $model = Vacation::findOne($id);

    //     $model->updated_by = 1;
    //     $model->updated_at = new Expression('NOW()');
    //     $model->status = 'granted';
    //     if ($model->save()) {
    //         return array('success' => 1);
    //     }else{
    //         return array('success' => 0);
    //     }
    // }

    public function actionAccept($id)
    {   
        $user = Yii::$app->user->identity;

        $model = Vacation::findOne($id);
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
        
        $model = Vacation::findOne($id);
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