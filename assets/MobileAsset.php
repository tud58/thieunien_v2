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
class MobileAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'frontend/mobile/css/bootstrap.min.css',
        'frontend/mobile/css/font-awesome.min.css',
        'frontend/mobile/css/owl.carousel.css',
        'frontend/mobile/css/header.css',
        'frontend/mobile/css/footer.css',
        'frontend/mobile/css/home.css',
        'frontend/mobile/css/news.css',
        'frontend/mobile/css/style.css',

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
