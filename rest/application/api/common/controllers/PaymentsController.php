<?php
namespace api\common\controllers;
use \Yii as Yii;
// use api\models\User;
use api\common\models\Payments;


class PaymentsController extends \api\components\ActiveController
{
    public $modelClass = '\api\common\models\Payments';

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

}