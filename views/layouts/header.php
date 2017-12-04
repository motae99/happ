<?php
use yii\helpers\Html;

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
                            <?= Html::beginForm( yii\helpers\Url::to(['/site/language']), NULL, ['style' => 'margin: 10px; padding-bottom: 35px;'] ) ?>
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
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">10</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 10 notifications</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-warning text-yellow"></i> Very long description here that may
                                        not fit into the page and may cause design problems
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-red"></i> 5 new members joined
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-user text-red"></i> You changed your username
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">View all</a></li>
                    </ul>
                </li>
                
                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= $directoryAsset ?>/img/mine.png" class="user-image" alt="User Image"/>
                        <span class="hidden-xs">Mo Taha</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= $directoryAsset ?>/img/mine.jpg" class="img-circle"
                                 alt="User Image"/>

                            <p>
                                Mo Taha - Infrastructure Engineer
                                <small>Developed . 2017</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="#"><?= Yii::t('app', 'Inventory')?></a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#"></a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#"><?= Yii::t('app', 'Client')?></a>
                            </div>
                        </li>
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
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
