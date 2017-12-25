<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Outstanding;
use app\models\Dolar;
use app\models\ContactForm;


class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionDollar()
    {   
        $model = new Dolar();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
    }

    public function actionLanguage()
    {   

        if(isset($_REQUEST['language'])) {
            $language = Yii::$app->request->post()['language'];
            Yii::$app->language = $language;

            $languageCookie = new \yii\web\Cookie([
                'name' => 'language',
                'value' => $language,
                'expire' => time() + 60 * 60 * 24 * 30, // 30 days
            ]);
            \Yii::$app->response->cookies->add($languageCookie);
            return $this->goBack();
        }
        return $this->renderAjax('language-form');
    }

    public function actionTable($start=NULL,$end=NULL,$_=NULL){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $events = array();
        $outstanding = Outstanding::find()->all();
        // $n = 9;
        foreach ($outstanding as $value) {
            $Event = new \yii2fullcalendar\models\Event();
            $Event->id = $value->id;
            $Event->title = $value->amount;
            $Event->className = $value->client->color_class;
            $Event->amount = $value->amount;
            $Event->url = Url::toRoute(['invoices/view', 'id'=>$value->invoice_id]);
            $status = $value->status;
            // $Event->stat = $status;

            if($status == 'clear'){
                $Event->className = 'bg-green fa fa-check-circle';
            }elseif($status == 'outstanding'){
                $Event->className = $Event->className.' fa fa-times-circle';
            }
            //." ".$value->start_time
            
            if ($value->type == 'promise') {
                $Event->className = $Event->className.' fa fa-dollar';
                $Event->start = $value->due_date;
                $Event->end = $value->due_date;
            }else{
                $Event->className = $Event->className.' fa fa-money';
                $Event->start = $value->cheque_date;
                $Event->end = $value->cheque_date; 
            }
            
            $events[] = $Event;
            // $n++;
        }
        // var_dump($events);
        return $events;
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
