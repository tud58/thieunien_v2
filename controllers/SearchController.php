<?php
namespace app\controllers;
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 9/25/2016
 * Time: 8:57 PM
 */
use app\models\Ads;
use app\models\Event;
use Yii;
use app\models\News;

use app\models\Category;
use app\models\NewsCategory;
use app\helper\Solr;

class SearchController extends BaseController
{
    public function actionIndex(){
        $keyword = htmlspecialchars(trim(Yii::$app->request->get('keyword', '')));
        $where = [];
        if($keyword != ""){
            $where['keyword'] = $keyword;
        }
        $where['status'] = NEWS_STATUS_PUBLISHED;
		if(SOLR_SEARCH){
			$newsList = Solr::searchNews($where, 0,16);
		}else{
			$newsList = News::search($where, 0,16,['news.id' => SORT_DESC]);			
		}

        $is_next = 0;
        if (count($newsList) >= 16) {
            $is_next = 1;
            array_pop($newsList);
        }
        foreach ($newsList as $n){
            if ($n->logo == ""){
                if ($n->type == 2){
                    $n->logo = "/frontend/img/news-item.jpg";
                }else{
                    $n->logo = "/frontend/img/news-item.jpg";
                }
            }
        }
        //ads
        $ads = Ads::find()->where('status = ' . STATUS_ACTIVE . ' AND position > 20 AND position <= 40')->all();
        $adsWithKey = array();
        foreach ($ads as $a){
            $a->images = explode('(,)',$a->image);
            $a->htmls = explode('(,)',$a->html);
            $adsWithKey[$a->position] = $a;
        }
        return $this->render('index',[
            'keyword' => $keyword,
            'newsList' => $newsList,
            'ads' => $adsWithKey,
            'is_next' => $is_next,
        ]);
    }
}
