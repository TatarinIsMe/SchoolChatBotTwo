<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
//    'layout' => 'basic',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'hwjewhekj23jj3h',
            // 'parser' => [
            //     'application/json' => 'yii/web/JsonParser',
            // ]
        ],
        'cors' => [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['http://127.0.0.1:5500/'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
            ],
        ],

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
//        'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => false,
//            'transport' => [
////                'class' => 'Swift_SmtpTransport',
//                'scheme' => 'smtps',
//                'host' => 'smtp.mail.ru',
//                'username' => 'ibnrinat02@mail.ru',
//                'password' => 'Ah06JQqseydH7Ru7FMuW',
//                'port' => '465',
//                'encryption' => 'ssl',
//                'dsn' => 'native://default',
//            ],
            'transport' => [
                'dsn' => 'smtp://ibnrinat02@mail.ru:Ah06JQqseydH7Ru7FMuW@smtp.mail.ru:25',
            ],
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
                 //['class' => 'yii/rest/UrlRule','controller' => 'user'],
                 '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
             ],
         ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
