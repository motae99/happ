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
        unset($actions['index']);
        unset($actions['view']);
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
        return $actions;
    }

    public function actionCreate(){
        // $user =  Yii::$app->user->identity;
        
        $model = new Dolar();
        $body = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        if (isset($body['value']) && $body['value'] > 0 && is_integer($body['value'])) {
            $model->value = $body['value'];
            $model->created_at = new Expression('NOW()');
            if ($model->save()) {
                return array('success' => 1);
            }else{
                return array('success' => 0);
            }
            # code...
        }else{
            return array('success' => 0);
        }

    }

    public function actionIndex(){
        $rate = Dolar::find()->orderBy(['created_at' => SORT_DESC])->one();
        return array('current_rate' => $rate->value);
    }

}