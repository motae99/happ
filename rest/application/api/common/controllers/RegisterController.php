<?php
namespace api\common\controllers;
use \Yii as Yii;
use api\models\User;
use api\common\models\Register;
// use api\common\models\Profile;
use yii\db\Expression;
use \Unifonic\API\Client;



class RegisterController extends \api\components\ActiveController
{
    public $modelClass = '\api\common\models\Register';

    public function accessRules()
    {
        return [
            [
                'allow' => true,
                'roles' => ['?'],
            ],
            [
                'allow' => true,
                'actions' => [
                    'code',
                    'verify',
                ],
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

    public function actionCode(){
        $body = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        if ($body['phone_no']) {
            $client = new Client();
            $no = $body['phone_no'];
            $response = $client->Verify->GetCode($no , 'تطبيق طبيبي يرحب بكم', 'OTP');
            // if ($response) {
            return array('response' => $response);
        
        }else{
            return array('success' => 0, 'massege' => 'phone_no is required');
  
        }

    }

    public function actionVerify(){
        $body = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        if ($body['phone_no'] && $body['code']) {
            $client = new Client();
            $no = $body['phone_no'];
            $code = $body['code'];
            // if ($response) {
            $response = $client->Verify->VerifyNumber($no, $code);
            return array('response' => $response);
        }
        // }else{
        //     return array('success' => 0, 'massege' => 'username & password are required');
  
        // }

    }

    public function actionCreate(){
        // $user =  Yii::$app->user->identity;
        
        // $model = new Register();
        $body = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        if ($body['username'] && $body['password']) {
            $user = new User();
            $user->email = $body['username'];
            $user->password = $body['password'];
            $user->generateAuthKey();
            if ($user->save()) {
                return array('success' => 1);
            }else{
                return array('success' => 0);
            }
        }else{
            return array('success' => 0, 'massege' => 'username & password are required');
  
        }
        // if (isset($body['value']) && $body['value'] > 0 && is_integer($body['value'])) {
        //     $model->value = $body['value'];
        //     $model->created_at = new Expression('NOW()');
        //     if ($model->save()) {
        //         return array('success' => 1);
        //     }else{
        //         return array('success' => 0);
        //     }
        //     # code...
        // }else{
        //     return array('success' => 0);
        // }

    }

}