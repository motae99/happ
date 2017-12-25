<?php
namespace api\common\controllers;
use \Yii as Yii;
// use api\models\User;
use api\common\models\Dolar;
use yii\db\Expression;


class DolarController extends \api\components\ActiveController
{
    public $modelClass = '\api\common\models\Dolar';

    public function accessRules()
    {
        return [
            [
                'allow' => true,
                'roles' => ['?'],
            ],
           
        ];
    }

    public function actions(){
        $actions = parent::actions();
        // unset($actions['index']);
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
        return $actions;
    }

    public function actionCreate(){
        // $user =  Yii::$app->user->identity;
        
        $model = new Dolar();
        $body = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        $model->value = $body['value'];
        $model->created_at = new Expression('NOW()');
        if ($model->save()) {
            return array('success' => 1);
        }else{
            return array('success' => 0);
        }

    }

}