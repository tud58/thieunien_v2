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
use Yii;
use app\models\News;

use app\models\Category;
use app\models\NewsCategory;
use app\models\Tag;
use app\models\NewsTag;
class VideoController extends BaseController
{
    public function actionIndex(){
        $videos = News::find()
            ->where(['status' => NEWS_STATUS_PUBLISHED,'type' => 2])
            ->offset(0)
            ->limit(16)
            ->orderBy(['publish_time' => SORT_DESC])
            ->all();
        $is_next = 0;
        if (count($videos) >= 16) {
            $is_next = 1;
            array_pop($videos);
        }
        foreach ($videos as $v){
            if (empty($v->logo))
                $v->logo = "/frontend/img/news-item.jpg";
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
            'videos' => $videos,
            'is_next' => $is_next,
            'ads' => $adsWithKey,
        ]);
    }
    public function actionDetail(){
        $slug = trim(Yii::$app->request->get('slug', ''));
        if ($slug == '')
            return $this->goHome();
        $video = News::find()->where(['slug' => $slug])->one();
        if (empty($video))
            return $this->goHome();
        $videoCategorys = NewsCategory::find()->where(['news_id' => $video->id])->all();
        $categoryIds = [];
        foreach ($videoCategorys as $v){
            $categoryIds[] = $v->category_id;
        }
        $videos = NewsCategory::search([
            'category_id' => $categoryIds,
            'news.status' => NEWS_STATUS_PUBLISHED,
            'news.type' => 2,
        ],0,7,['news.publish_time' => SORT_DESC],$video->id);
        $is_next = 0;
        if (count($videos) >= 7) {
            $is_next = 1;
            array_pop($videos);
        }
        foreach ($videos as $v){
            if (empty($v->logo))
                $v->logo = "/frontend/img/news-item.jpg";
        }
        //update view
        $video->view_count = $video->view_count + 1;
        $video->save();
		
        //ads
        $ads = Ads::find()->where('status = ' . STATUS_ACTIVE . ' AND position > 40 AND position <= 60')->all();
        $adsWithKey = array();
        foreach ($ads as $a){
            $a->images = explode('(,)',$a->image);
            $a->htmls = explode('(,)',$a->html);
            $adsWithKey[$a->position] = $a;
        }
        $newsTags = NewsTag::find()->where(['news_id' => $video->id])->all();
        $tagIds = [];
        foreach($newsTags as $k => $nt){
            $tagIds[] = $nt['tag_id'];
        }
        $tags = Tag::find()->where(['id' => $tagIds])->limit(5)->all();
        $comments = Comment::find()->where(['status' => STATUS_ACTIVE,'news_id' => $video->id])->limit(6)->orderBy(['create_time' => SORT_DESC])->all();
        $next_comment = 0;
        if (count($comments) >= 6) {
            $next_comment = 1;
            array_pop($comments);
        }
        return $this->render('detail',[
            'video' => $video,
            'videos' => $videos,
            'is_next' => $is_next,
            'ads' => $adsWithKey,
            'tags' => $tags,
            'comments' => $comments,
            'next_comment' => $next_comment,
        ]);
    }
}
