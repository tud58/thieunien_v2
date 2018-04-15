<?php
namespace app\controllers;

/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 9/25/2016
 * Time: 8:57 PM
 */
use app\helper\Functions;
use app\models\Ads;
use app\models\Comment;
use app\models\Event;
use app\models\NewsLiveContent;
use Yii;
use app\models\News;

use app\models\Category;
use app\models\NewsCategory;
use app\models\Tag;
use app\models\NewsTag;
use app\models\UserPost;

class NewsController extends BaseController
{
    public function actionIndex()
    {
        $cache = Yii::$app->cache;

        $tag_id = intval(Yii::$app->request->get('tag_id', 0));
        $slug = trim(Yii::$app->request->get('slug', ''));
        if (empty($slug)) {
            return $this->goHome();
        }

        //dunghq - 190317 - cache  news
        $news = $cache->get('news_detail_' . md5($slug));
        if ($news === false) {
            $news = News::find()->where(['slug' => $slug])->one();
            $cache->set('news_detail_' . md5($slug), $news, 30);
        }

        if (empty($news)) {
            return $this->goHome();
        }

        if ($news->status != NEWS_STATUS_PUBLISHED && (Yii::$app->user->id == 0 || !in_array($this->getUser()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR, ROLE_EDITOR, ROLE_CONTRIBUTOR]))) {
            throw new \yii\web\HttpException(404, "Liên kết không tồn tại");
        }
        //echo $news->active_time ,time();
        if ($news->active_time > time() && (Yii::$app->user->id == 0 || !in_array($this->getUser()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR, ROLE_EDITOR, ROLE_CONTRIBUTOR]))) {
            throw new \yii\web\HttpException(404, "Liên kết không tồn tại");
        }
        if ($news->publish_time > time() && (Yii::$app->user->id == 0 || !in_array($this->getUser()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR, ROLE_EDITOR, ROLE_CONTRIBUTOR]))) {
            throw new \yii\web\HttpException(404, "Liên kết không tồn tại");
        }
        Yii::$app->view->params['meta_image'] = $news->logo;
        Yii::$app->view->params['meta_description'] = strip_tags(html_entity_decode($news->description));
        //update view
        News::updateViewCount($news->id);
        //end
        $newsRelates = array();

        //dunghq - 190317 - cache category
        $category = $cache->get('news_category_' . $news->category_id);
        if ($category === false) {
            $category = Category::findOne($news->category_id);
            $cache->set('news_category_' . $news->category_id, $category, 30);
        }

        if (empty($category)) {
            return $this->goHome();
        }
        if ($category->parent_id > 0) {
            $categories = Category::find()->where(['AND', 'status=' . STATUS_ACTIVE, ['OR', 'id=' . $category->parent_id, 'parent_id=' . $category->parent_id]])
                ->orderBy(['parent_id' => SORT_ASC])->all();
        } else {
            $categories[] = $category;
        }

        $categoryIds = [$category->id];
        //dunghq - 190317 - cache same news
        $dailyNews = $cache->get('daily_news_' . $news->id);
        if ($dailyNews === false) {
            $dailyNews = News::search([
//                'category_id' => $categoryIds,
                'daily' => 1,
                'status' => NEWS_STATUS_PUBLISHED,
                'news.type' => [0, 1, 3, 4],
            ], 0, 10, ['news.id' => SORT_DESC], $news->id);
            $cache->set('daily_news_' . $news->id, $dailyNews, 30);
        }

        //weekly
        $weeklyNews = $cache->get('week_news_' . $news->id);
        if ($weeklyNews === false) {
            $weeklyNews = News::search([
                'category_id' => 17,
                'status' => NEWS_STATUS_PUBLISHED,
                'news.type' => [0, 1, 3, 4],
            ], 0, 3, ['news.id' => SORT_DESC], $news->id);
            $cache->set('week_news_' . $news->id, $weeklyNews, 30);
        }

        //lastest
        $lastestNews = $cache->get('lastest_news_' . $news->id);
        if ($lastestNews === false) {
            $lastestNews = News::search([
                'status' => NEWS_STATUS_PUBLISHED,
                'news.type' => [0, 1, 3, 4],
            ], 0, 3, ['news.id' => SORT_DESC], $news->id);
            $cache->set('lastest_news_' . $news->id, $lastestNews, 30);
        }

        //dunghq - 190317 - cache tags
        $tags = $cache->get('tags_detail_' . $news->id);
        if ($tags === false) {
            $newsTags = NewsTag::find()->where(['news_id' => $news->id])->all();

            $tagIds = [];
            foreach ($newsTags as $k => $nt) {
                $tagIds[] = $nt['tag_id'];
            }
            $tags = Tag::find()->where(['id' => $tagIds])->limit(5)->all();
            $cache->set('tags_detail_' . $news->id, $tags, 30);
        }

        //dunghq - 190317 - cache comments
        $comments = $cache->get('comments_' . $news->id);
        if ($comments === false) {
            $comments = Comment::find()->where(['status' => STATUS_ACTIVE, 'news_id' => $news->id])->limit(6)->orderBy(['create_time' => SORT_DESC])->all();
            $cache->set('comments_' . $news->id, $comments, 30);
        }

        $next_comment = 0;
        if (count($comments) >= 6) {
            $next_comment = 1;
            array_pop($comments);
        }

        //ads
        //dunghq - 180317 - cache ads
        if (Functions::isMobile()){
            $ads = $cache->get('ads_detail_mobile');
            if($ads === false) {
                $ads = Ads::find()
                    ->where('status = ' . STATUS_ACTIVE . ' AND position > 80 AND position <= 100')
                    ->orderBy(['position' => SORT_ASC])->all();
                $cache->set('ads_detail_mobile',$ads,30);
            }
        }else {
            $ads = $cache->get('ads_detail');
            if($ads === false) {
                $ads = Ads::find()
                    ->where('status = ' . STATUS_ACTIVE . ' AND position > 40 AND position <= 60')
                    ->orderBy(['position' => SORT_ASC])->all();
                $cache->set('ads_detail',$ads,30);
            }
        }

        $adsWithKey = array();
        foreach ($ads as $a) {
            $a->images = explode('(,)', $a->image);
            $a->htmls = explode('(,)', $a->html);
            $adsWithKey[$a->position] = $a;
        }

        $newsLive = array();
        if ($news->type == 3) {
            $newsLive = $cache->get('news_live_' . $news->id);
            if ($newsLive === false) {
                $newsLive = NewsLiveContent::find()
                    ->where(['status' => STATUS_ACTIVE, 'news_id' => $news->id])
                    ->orderBy(['create_time' => SORT_DESC])
                    ->all();
                $cache->set('news_live_' . $news->id, $newsLive, 30);
            }
        }

        return $this->render('index', [
            'news' => $news,
            'category' => $category,
            'tags' => $tags,
            'comments' => $comments,
            'next_comment' => $next_comment,
            'dailyNews' => $dailyNews,
            'weeklyNews' => $weeklyNews,
            'lastestNews' => $lastestNews,
            'ads' => $adsWithKey,
            'newsRelates' => $newsRelates,
            'newsLive' => $newsLive,
            'categories' => $categories,
        ]);
    }

    public function actionPost_submit()
    {
        $model = new UserPost;
        $request = Yii::$app->request;

        $success = false;
        $post = $request->post();
        $model->load($post);

        if ($request->isPost) {
            $model->user_id = $this->getUser()->id;
            $model->user_email = $this->getUser()->email;
            $model->user_full_name = $this->getProfile()->full_name;
            if ($model->validate()) {
                $model->create_time = time();
                if ($model->save()) {
                    $success = true;
                }
            }
        }
        return $this->render('post_submit', [
            'model' => $model,
            'success' => $success
        ]);
    }

    public function actionPreview()
    {
        $news = new News;

        $news->id = 1;
        $news->title = Yii::$app->request->post('news-title');
        $news->content = Yii::$app->request->post('news-content');
        $news->category_id = Yii::$app->request->post('news-category_id');

        $category = Category::findOne($news->category_id);
        if (empty($category)) {
            echo 'Chuyên mục không tồn tại';
            exit;
        }
        $cache = Yii::$app->cache;


        $categoryIds[] = $category->id;


        $categoryChilds = Category::find()
            ->where(['status' => [STATUS_ACTIVE], 'parent_id' => $category->id])
            ->orderBy(['number_order' => SORT_ASC])
            ->all();

        foreach ($categoryChilds as $c) {
            $categoryIds[] = $c->id;
        }


        $sameNews = NewsCategory::search([
            'category_id' => $categoryIds,
            'status' => NEWS_STATUS_PUBLISHED,
            'news.type' => [0, 1, 3, 4],
        ], 0, 10, ['news.id' => SORT_DESC], $news->id);


        $videos = NewsCategory::search([
            'category_id' => [$category->id],
            'news.status' => NEWS_STATUS_PUBLISHED,
            'news.type' => 2,
        ], 0, 10);


        //popular news
        $rand_keys = array_rand($sameNews, 3);
        $newsRelates[] = $sameNews[$rand_keys[0]];
        $newsRelates[] = $sameNews[$rand_keys[1]];
        $newsRelates[] = $sameNews[$rand_keys[2]];


        //ads
        //dunghq - 180317 - cache ads 
        $ads = $cache->get('ads_detail');
        if ($ads === false) {
            $ads = Ads::find()->where('status = ' . STATUS_ACTIVE . ' AND position > 40 AND position <= 60')->all();

            $cache->set('ads_detail', $ads, 30);
        }

        $adsMobile = $cache->get('ads_mobile_detail');
        if ($adsMobile === false) {
            $adsMobile = Ads::find()->where('status = ' . STATUS_ACTIVE . ' AND position > 80 AND position <= 100')->all();

            $cache->set('ads_mobile_detail', $adsMobile, 30);
        }

        $adsWithKey = array();
        foreach ($ads as $a) {
            $a->images = explode('(,)', $a->image);
            $a->htmls = explode('(,)', $a->html);
            $adsWithKey[$a->position] = $a;
        }
        foreach ($adsMobile as $a) {
            $a->images = explode('(,)', $a->image);
            $a->htmls = explode('(,)', $a->html);
            $adsWithKey[$a->position] = $a;
        }

        //dunghq - 190317 - cache event
        //event
        $events = $cache->get('events_detail');
        if ($events === false) {
            $events = Event::find()
                ->where(['status' => STATUS_ACTIVE])
                ->offset(0)
                ->limit(3)
                ->orderBy(['create_time' => SORT_DESC])
                ->all();
            $cache->set('events_detail', $events, 30);
        }
        foreach ($sameNews as $sn) {
            if ($sn->logo == "")
                $sn->logo = "/frontend/img/news-item.jpg";
        }
        foreach ($videos as $v) {
            if ($v->logo == "")
                $v->logo = "/frontend/img/news-item.jpg";
        }

        $newsLive = array();
        if ($news->type == 3) {
            $newsLive = $cache->get('news_live_' . $news->id);
            if ($newsLive === false) {
                $newsLive = NewsLiveContent::find()
                    ->where(['status' => STATUS_ACTIVE, 'news_id' => $news->id])
                    ->orderBy(['create_time' => SORT_DESC])
                    ->all();
                $cache->set('news_live_' . $news->id, $newsLive, 30);
            }
        }


        return $this->render('preview', [
            'news' => $news,
            'category' => $category,


            'sameNews' => $sameNews,
            'ads' => $adsWithKey,
            'events' => $events,

            'videos' => $videos,
            'newsLive' => $newsLive,

        ]);
    }

    public function actionUpdateViewCount()
    {
        $newsId = intval(Yii::$app->request->get('news_id', 0));
        News::updateViewCount($newsId);
        echo '0';
        exit;
    }
}
