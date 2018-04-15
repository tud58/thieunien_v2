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

use app\models\Tag;
use app\models\NewsTag;
class TagController extends BaseController
{
    public function actionIndex(){
        $slug = trim(Yii::$app->request->get('slug', ''));
        if($slug == ''){
            return $this->goHome();
        }
        $tag = Tag::find()->where(['slug' => $slug])->one();
        if(empty($tag)){
            return $this->goHome();
        }
        $tagIds[] = $tag->id;
        $news = NewsTag::search([
            'tag_id' => $tagIds,
            'news.status' => NEWS_STATUS_PUBLISHED,
            'news.type' => [0,1,3,4],
        ],0,21);
        $videos = NewsTag::search([
            'tag_id' => $tagIds,
            'news.status' => NEWS_STATUS_PUBLISHED,
            'news.type' => 2,
        ],0,10);
        foreach ($news as $n){
            if (empty($n->logo)){
                $n->logo = '/frontend/img/news-item.jpg';
            }
        }
        foreach ($videos as $v){
            if (empty($v->logo)){
                $v->logo = '/frontend/img/news-item.jpg';
            }
        }
        $is_next = 0;
        if (count($news) >= 21) {
            $is_next = 1;
            array_pop($news);
        }
        //ads
        $ads = Ads::find()->where('status = ' . STATUS_ACTIVE . ' AND position > 20 AND position <= 40')->all();
        $adsWithKey = array();
        foreach ($ads as $a){
            $a->images = explode('(,)',$a->image);
            $a->htmls = explode('(,)',$a->html);
            $adsWithKey[$a->position] = $a;
        }
        //event
        $events = Event::find()
            ->where(['status' => STATUS_ACTIVE])
            ->offset(0)
            ->limit(5)
            ->orderBy(['create_time' => SORT_DESC])
            ->all();
        //popular news
        $newsPopular = NewsTag::search([
            'tag_id' => $tagIds,
            'news.status' => NEWS_STATUS_PUBLISHED,
            'news.type' => [0,1,3,4],
        ],0,5,['news.view_count' => SORT_DESC]);


        return $this->render('index',[
            'tag' => $tag,
            'news' => $news,
            'videos' => $videos,
            'ads' => $adsWithKey,
            'is_next' => $is_next,
            'events' => $events,
            'newsPopular' => $newsPopular,
        ]);
    }
}
