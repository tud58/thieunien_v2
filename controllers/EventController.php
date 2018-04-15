<?php
namespace app\controllers;
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 9/25/2016
 * Time: 8:57 PM
 */
use app\models\Ads;
use app\models\Comment;
use app\models\Event;
use app\models\News;
use Yii;

use app\models\Tag;
use app\models\NewsTag;
class EventController extends BaseController
{
    public function actionIndex(){
        $slug = trim(Yii::$app->request->get('slug', ''));
        if($slug == ''){
            return $this->goHome();
        }
        $event = Event::find()->where(['slug' => $slug])->one();
        if(empty($event)){
            return $this->goHome();
        }
        $news = News::find()
            ->where(['status' => NEWS_STATUS_PUBLISHED,'event_id'=>$event->id])
            ->offset(0)
            ->limit(11)
            ->orderBy(['publish_time' => SORT_DESC])
            ->all();
        $is_next = 0;
        if (count($news) >= 11) {
            $is_next = 1;
            array_pop($news);
        }
        foreach ($news as $n){
            if (empty($n->logo)){
                $n->logo = '/frontend/img/news-item.jpg';
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
            'event' => $event,
            'news' => $news,
            'ads' => $adsWithKey,
            'is_next' => $is_next,
        ]);
    }

    public function actionDetail(){
        $slug = trim(Yii::$app->request->get('slug', ''));
        if ($slug == '')
            return $this->goHome();
        $news = News::find()->where(['slug' => $slug])->one();
        if (empty($news))
            return $this->goHome();
        $event_id = Yii::$app->request->get('event_id', 0);
        if ($event_id <= 0)
            return $this->goHome();
        $event = Event::findOne($event_id);
        if (empty($event))
            return $this->goHome();
        $newsSame = News::find()
            ->where('status='.NEWS_STATUS_PUBLISHED.' AND event_id='.$event->id.' AND id <> ' .$news->id)
            ->offset(0)
            ->limit(11)
            ->orderBy(['publish_time' => SORT_DESC])
            ->all();
        $is_next = 0;
        if (count($newsSame) >= 11) {
            $is_next = 1;
            array_pop($newsSame);
        }
        foreach ($newsSame as $n){
            if (empty($n->logo)){
                $n->logo = '/frontend/img/news-item.jpg';
            }
        }
        //ads
        $ads = Ads::find()->where('status = ' . STATUS_ACTIVE . ' AND position > 40 AND position <= 60')->all();
        $adsWithKey = array();
        foreach ($ads as $a){
            $a->images = explode('(,)',$a->image);
            $a->htmls = explode('(,)',$a->html);
            $adsWithKey[$a->position] = $a;
        }
        $newsTags = NewsTag::find()->where(['news_id' => $news->id])->all();
        $tagIds = [];
        foreach($newsTags as $k => $nt){
            $tagIds[] = $nt['tag_id'];
        }
        $tags = Tag::find()->where(['id' => $tagIds])->limit(5)->all();
        $comments = Comment::find()->where(['status' => STATUS_ACTIVE,'news_id' => $news->id])->limit(5)->all();
        return $this->render('detail',[
            'event' => $event,
            'news' => $news,
            'newsSame' => $newsSame,
            'is_next' => $is_next,
            'ads' => $adsWithKey,
            'comments' => $comments,
            'tags' => $tags,
        ]);
    }
}
