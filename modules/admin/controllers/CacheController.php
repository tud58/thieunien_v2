<?php
namespace app\modules\admin\controllers;

use yii\web\Controller;
use yii;

class CacheController extends BaseController
{
    public $layout = "admin";
    public function actions()
    {

        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }
    public function actionIndex(){
        $cache = Yii::$app->cache;
	    $message = '';

        $submit = Yii::$app->request->get('submit', '');

        if($submit == 'submit'){
            $cmd = Yii::$app->request->get('cmd', '');

            switch ($cmd) {
                case 'danh-muc':
                    $slug = Yii::$app->request->get('slug', '');

                    $cache->set('news_category_'.md5($slug), false);
                    $cache->set('videos_category_'.md5($slug), false);
                    $cache->set('ads_category', false);
                    $cache->set('events_category', false);
                    $cache->set('news_popular_category', false);

                    $message = "Xóa cache trang '<strong>".$slug."</strong>' thành công";
                    break;
                case 'tin-tuc':
                    # code...
                    break;
                
                default:
                    $categories = $cache->get('categories_home');
                    if($categories !== false){
                        foreach ($categories as $c){
                            $cache->set('news_category_home_'.$c->id, false);
                        }
                    }
                    $cache->set('categories_home', false);
                    $cache->set('news_category_video_home', false);
                    $cache->set('news_category_news_home', false);
                    $cache->set('news_video_home', false);
                    $cache->set('ads_home', false);

                    $message = "Xóa cache trang chủ thành công";
                    break;
            }
        }

        return $this->render("index", [
            'message' => $message,
        ]);
    }

    public function actionPermission_denied(){
        return $this->render('permission_denied');
    }
}