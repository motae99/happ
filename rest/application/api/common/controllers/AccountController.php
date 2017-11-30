<?php
namespace api\common\controllers;
use \Yii as Yii;
use api\models\User;
use api\common\models\Account;



class AccountController extends \api\components\ActiveController
{
    public $modelClass = '\api\common\models\Account';

    public function accessRules()
    {
        return [
            [
                'allow' => false,
                'roles' => ['?'],
            ],
            [
                'allow' => true,
                'actions' => ['index'],
                'roles' => ['@'],
            ]
        ];
    }

    public function actions(){
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['create']);
        unset($actions['view']);
        unset($actions['update']);
        unset($actions['delete']);
        return $actions;
    }

    public function actionIndex(){
    	$user = Yii::$app->user->identity;
        $model = new Account();
		$actual_salary = $user->salary;
		$calculate = $model->calculate($user->id, $user->salary);   
		$report = $model->report($user->id);   
        $report['technical_taste'] = $user->technical_taste;
        $report['evaluation'] = $user->evaluation;
		return ['account' => $calculate, 'report' => $report];


    }


    
}