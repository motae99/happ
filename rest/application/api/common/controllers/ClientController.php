<?php
namespace api\common\controllers;
use \Yii as Yii;
use api\models\User;
use api\common\models\Client;
use yii\db\Expression;



class ClientController extends \api\components\ActiveController
{
    public $modelClass = '\api\common\models\Client';

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
                    'update',
                    'profile',
                    'google',

                ],
                'roles' => ['@'],
            ],
            [
                'allow' => true,
                'actions' => ['create', 'delete', 'index', 'eval', 'idname'],
                'roles' => ['@'],
                'scopes' => ['admin'],
            ],
        ];
    }

    public function actions(){
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['view']);
        return $actions;
    }

    public function actionIdname(){
        $clients = array();
        $users = Client::find()->select('id, name')->all();
        foreach ($users as $user) {
            $clients[] = $user->id.$user->name ;
        }
        return  array('users' => $clients);

    }

    public function actionIndex(){

        $users = Client::find()->select('id, name, dep_id, job_desc, email, photo, salary, technical_taste, evaluation')->all();
        return  array('users' => $users);

    }

    public function actionCreate(){
        $model = new User();
        $body = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        $model->load($body, '');
        $model->name = $body['name'];
        $model->dep_id = $body['dep_id'];
        $model->job_desc = $body['job_desc'];
        $model->email = $body['email'];
        $model->password = $body['password'];
        $model->salary = $body['salary'];
        $model->created_at = new Expression('NOW()');
        $model->generateAuthKey();

        if ($model->save()) {
            return array('success' => 1);
        }else{
            return array('success' => 0);
        }

    }

     public function actionUpdate($id){
        $model = Client::findOne($id) ;
        $body = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        $model->load($body, '');
        if(isset($body['name'])){
            $model->name = $body['name'];
        }
        if(isset($body['dep_id'])){
            $model->dep_id = $body['dep_id'];
        }
        if(isset($body['job_desc'])){
            $model->job_desc = $body['job_desc'];
        }
        if(isset($body['email'])){
            $model->email = $body['email'];
        }
        if(isset($body['salary'])){
            $model->salary = $body['salary'];
        }

        if ($model->save()) {
            return array('success' => 1);
        }else{
            return array('success' => 0);
        }

    }

    public function actionProfile(){
        $user =  Yii::$app->user->identity;
        $profile = Client::find()->select('id, name, dep_id, job_desc, email, photo, salary')->where(['id' => $user->id])->one();
        return array('profile' => $profile); 
    }

    public function actionGoogle(){
        $user =  Yii::$app->user->identity;
        $body = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        $user->load($body, '');
        $user->google_token = $body['google_token'];
        if ($user->save()) {
            return array('success' => 1);
        }else{
            return array('success' => 0);
        } 
    }

    public function actionEval($id){
        $user = Client::find()->where(['id' => $id])->one();
        $body = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        $user->load($body, '');
        $user->technical_taste = $body['technical_taste'];
        $user->evaluation = $body['evaluation'];
        if ($user->save()) {
            return array('success' => 1);
        }else{
            return array('success' => 0);
        } 
    }


}