<?php
namespace api\common\controllers;
use \Yii as Yii;
use api\models\User;
use api\common\models\Task;
use api\common\models\Note;
use api\common\models\Client;
use yii\db\Expression;


class TaskController extends \api\components\ActiveController
{
    public $modelClass = '\api\common\models\Task';

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
                    'update',
                    'custom',
                    'note'
                ],
                'roles' => ['@'],
            ],
            [
                'allow' => true,
                'actions' => ['create', 'delete', 'accept', 'reject', 'only', 'oname'],
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
        return $actions;
    }

    public function actionOnly($id){
        $client = Client::findOne($id);
        $data = Task::find()->where(['assigned_to' => $client->id])->all();
        return array('tasks' => $data);

    }


    public function actionIndex(){

        $user = Yii::$app->user->identity;
        $data = Task::find()->where(['created_by' => $user->id])->orWhere(['assigned_to' => $user->id])->all();
        $note = array();
        foreach ($data as $d) {
            $task_notes = Note::find()->where(['task_id' => $d->id])->all();
            foreach ($task_notes as $n ) {
             array_push($note, $n);
            }
        }
        return  array('tasks' => $data, 'notes' => $note);

    }

    public function actionUpdate($id){

        $model = Task::findOne($id);
        $user =  Yii::$app->user->identity;
        if($model->assigned_to === $user->id){
            $model->submitted_at = new Expression('NOW()');
            $model->status = "submitted";
            if ($model->save()) {
                $gcm = Yii::$app->gcm;
                $gcm->send($user->google_token, $model);
                return ['success' => 1];
            }else{
                return array('success' => 0);
            }
        }
    }


    public function actionCreate(){
        $user =  Yii::$app->user->identity;
        
        $model = new Task();
        $body = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        $model->load($body, '');
        $model->name = $body['name'];
        $model->description = $body['description'];
        $model->due_date = $body['due_date'];
        $c = $body['assigned_to'];
        $client = client::find()->where(['name' => $c])->one();
        $model->assigned_to = $client->id;
        $model->created_by = 1;
        if($body['priority'] == 1){
            $model->priority = 1;
        }else{
            $model->priority = 0;
        }
        $model->status = 'pending';
        $model->created_at = new Expression('NOW()');
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
        $user =  Yii::$app->user->identity;

        $model = Task::findOne($id);
        $model->status = "done";
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
        $user =  Yii::$app->user->identity;

        $model = Task::findOne($id);
        $model->status = "review";
        if ($model->save()) {
            $gcm = Yii::$app->gcm;
            $gcm->send($user->google_token, $model);
            return ['success' => 1];
        }else{
            return ['success' => 0];
        }
        
    }


     public function actionNote($id)
    {
        $task = Task::findOne($id);
        $user =  Yii::$app->user->identity;
        $note = new Note();
        $body = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        $note->load($body, '');
        $note->user_id = $user->id;
        $note->task_id = $task->id;
        $note->note = $body['note'];
        $note->created_at = new Expression('NOW()');
        if($note->save()){
            $gcm = Yii::$app->gcm;
            $gcm->send($user->google_token, $note);
           return array('success' => 1); 
       }else{
            return array('success' => 0);
        }
        
    }
}