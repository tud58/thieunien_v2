<?php
namespace app\helper;

use Yii;
use app\models\Category;
use app\models\News;

class BlockManager{
	public static function renderHomeBlock($blockId, $categoryId){
		$category = Category::findOne($categoryId);
		
		$where = [
			'status' => NEWS_STATUS_PUBLISHED,
			'category_id' => $categoryId
		];
		
		$newsList = News::find()->where($where)->limit(20)->orderBy(['news.publish_time' => SORT_DESC])->all();
		
		
		
		return Yii::$app->controller->renderPartial('@app/views/blocks/home/block-'.$blockId, [
			'category' => $category,
			'newsList' => $newsList,
		]);
	}
}