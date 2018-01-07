<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo', 'id' =>'anchor']) ?>

    <nav class="navbar navbar-static-top" role="navigation">


        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="<?= Yii::t('app', 'Select Language') ?>">
                        <i class="fa fa-language fa-lg"></i>
                    </a>
                    <ul class="dropdown-menu" style="<?= (Yii::$app->language == 'ar') ? 'left: 0 !important; right: auto !important;' : '';?>">
                        <li class="header">
                            <?= Html::beginForm( Url::to(['/site/language']), NULL, ['style' => 'margin: 10px; padding-bottom: 35px;'] ) ?>
                            <div class="col-sm-6 col-xs-6 no-padding">
                            <?= Html::label(Yii::t('app', 'Select Language'), 'language') ?>
                            </div>
                            <div class="col-sm-6 col-xs-6" style="padding-left:7px;">
                            <?= Html::dropDownList('language', Yii::$app->language, ['en' => Yii::t('app', 'English'), 'fr' => Yii::t('app', 'French (français)'), 'ar' => Yii::t('app', 'Arabic (العربية)')], ['class'=> 'form-control', 'onchange' => 'this.form.submit()', 'style' => 'padding: 5px;', 'title' => Yii::t('app', 'Select Language')]) ?>
                            </div>

                            <?= Html::endForm() ?>
                        </li>
                    </ul>
                </li>

                
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-dollar"></i>
                        <span class="label label-warning"><?= Yii::$app->mycomponent->rate()?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">
                            <?php 

                                $dollar = new app\models\Dolar();
                                $form = ActiveForm::begin([   
                                    'id' => 'dollar-exchange-form',
                                    'options'=>['method' => 'post'],
                                    'action' => Url::to(['site/dollar']),
                                    
                                ]); 
                            

                                echo $form->field($dollar, 'value', [
                                        'feedbackIcon' => [
                                            'default' => 'ok',
                                            'error' => 'exclamation-sign',
                                            'defaultOptions' => ['class'=>'text-primary']
                                        ],

                                        'addon' => [
                                            // 'append' => [
                                            //     'content' => Yii::$app->mycomponent->rate(),

                                            // ],
                                            'append' => [
                                                'content' => Html::submitButton('<i class="fa fa-dollar"></i>', ['class'=>'btn btn-flat bg-orange']),
                                                'asButton' => true
                                            ]
                                        ]
                                    ])->textInput()->label(false); 
                            

                                ActiveForm::end(); 
                            ?>
                        </li>
                    </ul>
                </li>
                
                <!-- User Account: style can be found in dropdown.less -->
        
                <?php $user = Yii::$app->user->identity; ?>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= Yii::getAlias('@web')?>/data/avatar.png" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?=  $user->username ;?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= Yii::getAlias('@web')?>/data/mine.png" class="img-thumbnail"
                                 alt="User Image"/>

                            <p>
                                <?=Yii::$app->mycomponent->name() ?>
                                <small><?=Yii::$app->mycomponent->address() ?></small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
               <!--  <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li> -->
            </ul>
        </div>
    </nav>
</header>
