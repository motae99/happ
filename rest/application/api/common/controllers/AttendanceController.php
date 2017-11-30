<?php
namespace api\common\controllers;
use \Yii as Yii;
use api\models\User;
use api\common\models\Attendance;



class AttendanceController extends \api\components\ActiveController
{
    public $modelClass = '\api\common\models\Attendance';

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
                    'index',
                    'create'
                ],
                'roles' => ['@'],
            ]
        ];
    }

    public function actions(){
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex(){
        $user = Yii::$app->user->identity;
        if ($user->id === 1) {
            $data = Attendance::find()->all();
        }else{
            $data = Attendance::find()->where(['user_id' => $user->id])->all();
        }
        return array('Attendance' => $data);

    }

    public function actionCreate(){
        $model = new Attendance();
        $body = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        // print_r($body);
        $user = Yii::$app->user->identity;
        $model->attended_at  = $body['attended_at'];
        $model->user_id = $user->id;
        if ($model->save()) {
            $gcm = Yii::$app->gcm;
            $gcm->send($user->google_token, $model);
            return array('success' => 1);
        }else{
            return array('success' => 0);
        }
        
    }


    
}