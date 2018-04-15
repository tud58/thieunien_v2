<?php
require(__DIR__ . '/const.inc');
$params = require(__DIR__ . '/params.php');


//ini_set('session.save_handler', 'memcache');
ini_set('session.save_path', "tcp://".MEMCACHE_SESSION_HOST.":".MEMCACHE_SESSION_PORT);

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    //'bootstrap' => ['log'],
    'language' => 'vi-VN',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'TckXH5F0gLOWG2fjki0-hrIDtgvIqrlIzzz',
        ],
        'cache' => [
			'class' => 'yii\caching\FileCache',
			/*'class' => 'yii\caching\MemCache',
			'servers' => [
				[
					'host' => MEMCACHE_SESSION_HOST,
					'port' => MEMCACHE_SESSION_PORT,
				],
			],
			'useMemcached' => true,
			'serializer' => false,
			'options' => [
				\Memcached::OPT_COMPRESSION => false,
			],*/
        ],
        'user' => [
            'class' => 'app\modules\user\components\User',
			'identityCookie' => [
				'name' => '_identity',
				'path' => '/',
				'domain' => ".hoahoctro.vn",
			],		
        ],
		'session' => [
			// ...
			'cookieParams' => [
				'path' => '/',
				'domain' => ".hoahoctro.vn",
			],
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
            'traceLevel' => YII_DEBUG ? 1 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => require(__DIR__ . '/rules.php'),
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '924720127671404',
                    'clientSecret' => '63640dcbf1fce34193f61c15385e653c',
                    'scope' => 'email',
                ],
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => '997464704890-s0ae29b13a9j4upg0066c4qdhmdr3pe2.apps.googleusercontent.com',
                    'clientSecret' => '04SeyqAJXJr0qHktsSpdeGqo',
                ],
            ],
        ],	
		
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'bundles' => [
                        'yii\web\JqueryAsset' => [
                            'js' => [
                                YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js'
                            ]
                        ],
                        'yii\bootstrap\BootstrapAsset' => [
                            'css' => [
                                YII_ENV_DEV ? 'css/bootstrap.css' :         'css/bootstrap.min.css',
                            ]
                        ],
                        'yii\bootstrap\BootstrapPluginAsset' => [
                            'js' => [
                                YII_ENV_DEV ? 'js/bootstrap.js' : 'js/bootstrap.min.js',
                            ]
                        ]
            ],
        ],	
    ],
    'params' => $params,
    'modules' => [
        'user' => [
            'class' => 'app\modules\user\Module',
            // set custom module properties here ...
        ],
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'layout' => 'admin'
        ],
/*        'ktapi' => [
            'class' => 'app\modules\ktapi\Module',
            'layout' => 'ktapi'
        ],*/
        'filemanager' => [
            'class' => 'pendalf89\filemanager\Module',
            // Upload routes
            'routes' => [
                // Base absolute path to web directory
                'baseUrl' => '',
                // Base web directory url
                'basePath' => '@app/web',
                // Path for uploaded files in web directory
                'uploadPath' => 'uploads',
            ],
            // Thumbnails info
            'thumbs' => [
                'small' => [
                    'name' => 'small',
                    'size' => [100, 75],
                ],
                'medium' => [
                    'name' => 'medium',
                    'size' => [300, 225],
                ],
                'large' => [
                    'name' => 'large',
                    'size' => [600, 450],
                ],
            ],
        ],
    ],
];
//if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => [ '127.0.0.1', '116.96.251.155', '14.162.164.138', '117.6.162.5', '116.96.90.106', '1.55.182.225', '14.231.212.159', '113.22.51.110'],

    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
//}

return $config;
