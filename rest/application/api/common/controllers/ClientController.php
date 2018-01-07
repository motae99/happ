<?php
namespace api\common\controllers;
use \Yii as Yii;
// use api\models\User;
use api\common\models\Client;
use yii\data\ActiveDataProvider;


class ClientController extends \api\components\ActiveController
{
    public $modelClass = '\api\common\models\Client';

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

    // public function actionIndex(){
    //     return new ActiveDataProvider([
    //         'query' => Client::find()->with('recivable'), // and the where() part, etc.
    //     ]);

    // }

}