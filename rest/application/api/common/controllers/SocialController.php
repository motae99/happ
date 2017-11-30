<?php
namespace api\common\controllers;
use \Yii as Yii;
use api\models\User;
use api\common\models\Social;
use yii\db\Expression;
use yii\web\UploadedFile;




class SocialController extends \api\components\ActiveController
{
    public $modelClass = '\api\common\models\Social';

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
        $data = Social::find()->all();
        
        return array('Social' => $data);

    }

    public function actionCreate(){
        $model = new Social();
        $body = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        $user = Yii::$app->user->identity;
        $model->topic  = $body['topic'];
        $model->created_by = $user->id;
        $model->created_at = new Expression('NOW()');
        $file = UploadedFile::getInstance($body['photo']);
        $model->photo->saveAs(Yii::$app->basePath.$file);
        if ($model->save()) {
            $gcm = Yii::$app->gcm;
            $gcm->send($user->google_token, $model);
            return array('success' => 1);
        }else{
            return array('success' => 0);
        }
        
    }


    
}