<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'language' => 'en',
    'name' => 'HealthApp',
    'timeZone' => 'Africa/Khartoum',
    
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
            [
                'class' => 'app\components\LanguageSelector',
                'supportedLanguages' => ['en','ar', 'fr'],
            ],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => /*'@app/views/layouts/left.php',*/ 'right-menu',
            'mainLayout' => '@app/views/layouts/main.php',
        ],
       'gridview' =>  [
            'class' => '\kartik\grid\Module',
            // enter optional module parameters below - only if you need to  
            // use your own export download action or custom translation 
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => [
            //         'class' => 'yii\i18n\PhpMessageSource',
            //         'basePath' => '@app/messages',
            //         'forceTranslation' => true,
                
            // ],
        ]
    ],
    
    'components' => [
        'fcm' => [
            'class' => 'understeam\fcm\Client',
            'apiKey' => 'AIzaSyDaOsu_ufjkwalfek3mQBmoIIJlzMtz8XA', 
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    /*'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],*/
                ],
                'invo*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
                'client*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
                'inventory*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
                
                // 'yii*' => [
                //     'class' => 'yii\i18n\PhpMessageSource',
                //     'basePath' => '@app/messages',
                // ],
                'kvgrid*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
            ],
        ],
        'formatter' => [
            'dateFormat' => 'Y-m-d',
            'datetimeFormat' => 'php:Y-m-d H:i:s',
            'timeFormat' => 'php:H:i:s',
            'decimalSeparator' => '.',
            'thousandSeparator' => ',',
            'currencyCode' => 'Sdp.',
            'class' => 'yii\i18n\Formatter',
        ],
        'mycomponent' => [
            'class' => 'app\components\MyComponent',
        ],
        'exportPdf'=>[
            'class'=>'app\components\ExportToPdf',
        ],
        'pdf' => [
            'class' => \kartik\mpdf\Pdf::classname(),
            // 'format' => Pdf::FORMAT_A4,
            // 'orientation' => Pdf::ORIENT_PORTRAIT,
            // 'destination' => Pdf::DEST_BROWSER,
            // refer settings section for all configuration options
        ],
        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-blue',
                ],
                'wbraganca\dynamicform\DynamicFormAsset' => [
                    'sourcePath' => '@app/web/js',
                    'js' => [
                        'yii2-dynamic-form.js'
                    ],
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '5mUHJNEqKH9lrS-tiENv-aTfnFnPpVVw',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\PhpManager'
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        
    ],
    // 'as beforeRequest' => [
    //     'class' => 'yii\filters\AccessControl',
    //     'rules' => [
    //         [
    //             'allow' => true,
    //             'actions' => ['login'],
    //         ],
    //         [
    //             'allow' => true,
    //             'roles' => ['@'],
    //         ],
    //     ],
    //     'denyCallback' => function () {
    //         return Yii::$app->response->redirect(['site/login']);
    //     },
    // ],
        'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/login',
            'site/error',
            'site/logout',
            // 'admin/*',
            // 'some-controller/some-action',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['41.240.121.54', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        // 'allowedIPs' => ['154.97.196.228', '::1'],
    ];
}

return $config;
