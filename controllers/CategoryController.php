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

class CategoryController extends BaseController
{
    public function actionIndex()
    {
        $cache = Yii::$app->cache;

        $slug = trim(Yii::$app->request->get('slug', ''));
        if ($slug == '') {
            return $this->goHome();
        }
        $category = Category::find()->where(['slug' => $slug])->one();
        if (empty($category)) {
            return $this->goHome();
        }
        $slugChild = trim(Yii::$app->request->get('slug_child', ''));
        $categoryChild = "";
        if ($slugChild != '') {
            $categoryChild = Category::find()->where(['slug' => $slugChild])->one();
            if (empty($categoryChild))
                return $this->goHome();
        }
        $categoryChilds = $cache->get('category_child_' . $category->id);
        if ($categoryChilds === false) {
            $categoryChilds = Category::find()
                ->where(['status' => [STATUS_ACTIVE], 'parent_id' => $category->id])
                ->orderBy(['number_order' => SORT_ASC])
                ->all();
            $cache->set('category_child_' . $category->id, $categoryChilds, 30);
        }

        if ($categoryChild) {
            $categoryIds[] = $categoryChild->id;
        } else {
            $categoryIds[] = $category->id;
            foreach ($categoryChilds as $c) {
                $categoryIds[] = $c->id;
            }
        }

        //dunghq - 190317 - cache same news
        $dailyNews = $cache->get('daily_news_cat' . $category->id);
        if ($dailyNews === false) {
            $dailyNews = News::search([
//                'category_id' => $categoryIds,
                'daily' => 1,
                'status' => NEWS_STATUS_PUBLISHED,
                'news.type' => [0, 1, 3, 4],
            ], 0, 10, ['news.id' => SORT_DESC]);
            $cache->set('daily_news_' . $category->id, $dailyNews, 30);
        }

        //weekly
        $weeklyNews = $cache->get('week_news_cat' . $category->id);
        if ($weeklyNews === false) {
            $weeklyNews = News::search([
                'category_id' => 17,
                'status' => NEWS_STATUS_PUBLISHED,
                'news.type' => [0, 1, 3, 4],
            ], 0, 3, ['news.id' => SORT_DESC]);
            $cache->set('week_news_' . $category->id, $weeklyNews, 30);
        }

        //lastest
        $lastestNews = $cache->get('lastest_news_cat' . $category->id);
        if ($lastestNews === false) {
            $lastestNews = News::search([
                'status' => NEWS_STATUS_PUBLISHED,
                'news.type' => [0, 1, 3, 4],
            ], 0, 3, ['news.id' => SORT_DESC]);
            $cache->set('lastest_news_cat' . $category->id, $lastestNews, 30);
        }
        $newsIds = [];
        foreach ($dailyNews as $dl) {
            $newsIds[] = $dl->id;
        }
        foreach ($weeklyNews as $wl) {
            $newsIds[] = $wl->id;
        }
        foreach ($lastestNews as $ln) {
            $newsIds[] = $ln->id;
        }

        $order = ['news.publish_time' => SORT_DESC];
        $type = trim(Yii::$app->request->get('t', ''));
        if ($type == "new")
            $order = ['news.publish_time' => SORT_DESC];
        elseif ($type == "share") {
            $order = ['news.view_count' => SORT_DESC];
        }

        //dunghq - 190317 - cache news category 
        $news = $cache->get('news_category_' . md5($slug . $slugChild));
        // $news = false;
        if ($news === false) {
            $news = NewsCategory::search([
                'category_id' => $categoryIds,
//                'not_news' => $newsIds,
                'news.status' => NEWS_STATUS_PUBLISHED,
                'news.type' => [0, 1, 2, 3, 4],
            ], 0, 26, $order);
            $cache->set('news_category_' . md5($slug . $slugChild), $news, 30);
        }

        foreach ($news as $n) {
            if (empty($n->logo)) {
                $n->logo = '/frontend/img/news-item.jpg';
            }
        }

        $is_next = 0;
        if (count($news) >= 26) {
            $is_next = 1;
            array_pop($news);
        }

        //dunghq - 190317 - cache ads
        //ads
        $ads = $cache->get('ads_category');
        if ($ads === false) {
            $ads = Ads::find()->where('status = ' . STATUS_ACTIVE . ' AND position > 20 AND position <= 40')->all();

            $cache->set('ads_category', $ads, 30);
        }
        $adsWithKey = array();
        foreach ($ads as $a) {
            $a->images = explode('(,)', $a->image);
            $a->htmls = explode('(,)', $a->html);
            $adsWithKey[$a->position] = $a;
        }

        return $this->render('index', [
            'category' => $category,
            'categoryChild' => $categoryChild,
            'categoryChilds' => $categoryChilds,
            'news' => $news,
            'ads' => $adsWithKey,
            'is_next' => $is_next,
            'type' => $type,
            'dailyNews' => $dailyNews,
            'weeklyNews' => $weeklyNews,
            'lastestNews' => $lastestNews,
        ]);
    }
}
