<?php
namespace api\common\controllers;
use \Yii as Yii;
use api\models\User;
use api\common\models\Insurance;
// use api\common\models\Profile;
use yii\db\Expression;


class InsuranceController extends \api\components\ActiveController
{
    public $modelClass = '\api\common\models\Insurance';

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
        unset($actions['view']);
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
        return $actions;
    }


}