<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'frontend/css/bootstrap.min.css',
        'frontend/css/font-awesome.min.css',
        'frontend/css/owl.carousel.css',
//        'frontend/css/header.css',
        'frontend/css/footer.css',
//        'frontend/css/home.css',
        'frontend/css/profile.css',
//        'frontend/css/news.css',
//        'frontend/css/style.css?v=0.2',

    ];
    public $js = [
        'frontend/js/owl.carousel.js',
        'frontend/js/script.js?v=0.10',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
