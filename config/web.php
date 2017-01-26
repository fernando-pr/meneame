<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'ySLDzEdt2v4HsuU07nd8g2Ix562MEV6B',
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
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'usuario/<id:\d+>' => 'usuarios/view',
                'usuarios/update/<id:\d+>' => 'usuarios/update',
                'usuarios/index/<sort>' => 'usuarios/index',
                'usuarios/index/<page:\d+>/<per-page:\d+>' => 'usuarios/index',
                'noticia/<id:\d+>' => 'noticias/view',
                'noticias/update/<id:\d+>' => 'noticias/update',
                'noticias/index/<sort>' => 'noticias/index',
                'noticias/index/<page:\d+>/<per-page:\d+>' => 'noticias/index',
                'comentario/<id:\d+>' => 'comentarios/view',
                'comentarios/update/<id:\d+>' => 'comentarios/update',
                'comentarios/index/<sort>' => 'comentarios/index',
                'comentarios/index/<page:\d+>/<per-page:\d+>' => 'comentarios/index',
                'tipo-noticia/<id:\d+>' => 'tipo-noticias/view',
                'tipo-noticias/update/<id:\d+>' => 'tipo-noticias/update',
                'tipo-noticias/index/<sort>' => 'tipo-noticias/index',
                'tipo-noticias/index/<page:\d+>/<per-page:\d+>' => 'tipo-noticias/index',
            ],
        ],
    ],
    'params' => $params,
    'language' => 'es_ES',
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
