<?php

namespace app\commands;

use yii\console\Controller;

use app\models\News;
class ClearcacheController extends Controller
{

    public function actionIndex()
    {
		$list = News::find()->andWhere(['<', 'active_time', time()])->andWhere(['>', 'active_time', time() - 100])->all();
		if($list){
			foreach($list as $news){
				$this->clearCacheAfterUpdate($news);
			}
		}
		exit;
    }
	
	private function clearCacheAfterUpdate($model){
		//Dunghq 2103 - Clear cache sau khi luu lai
		$cache = Yii::$app->cache;
		$cache->set('news_detail_'.md5($model->slug), false);    
		$cache->set('news_live_'.$model->id, false);    
		$cache->set('tags_detail_'.$model->id, false);    
		$cache->set('comments_'.$model->id, false);    
		$cache->set('videos_'.$model->id, false);  
		$cache->set('same_news_'.$model->id, false);  
		$cache->set('events_detail',false);
		$cache->set('ads_detail',false);
		$cache->set('ads_mobile_detail',false);

		//dunghq 2203 - remove cache home
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

		//dunghq 2203 - remove cache category
		$categories = $cache->get('categories_header');
		if($categories !== false){
			foreach ($categories as $c){
				$cache->set('news_category_'.md5($c['slug']), false);
				$cache->set('videos_category_'.md5($c['slug']), false);
			}
		}
		$cache->set('categories_header', false);

		$cache->set('ads_category', false);
		$cache->set('events_category', false);
		$cache->set('news_popular_category', false);		
	}
}
