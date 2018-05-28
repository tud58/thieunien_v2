<?php

namespace app\controllers;

use app\helper\Functions;
use app\models\Ads;
use app\models\Category;
use app\models\News;
use app\models\NewsCategory;
use app\models\NewsTag;
use app\models\HomeLayout;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class SiteController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {

        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $cache = Yii::$app->cache;
        //dunghq - 180317 - cache category home
        $categories = false;
        $categories = $cache->get('categories_home');
        if ($categories === false) {
            $categories = Category::find()->where('status = ' . STATUS_ACTIVE . ' AND show_home > 0')->orderBy(['show_home' => SORT_ASC])->all();

            $cache->set('categories_home', $categories, 30);
        }

        $categoryIds = [];
        foreach ($categories as $c) {
            $categoryIds[] = $c->id;
        }

        foreach ($categories as $c) {
            $c->news = [];

            $newsCategory = $cache->get('news_category_home_' . $c->id);
            if ($newsCategory === false) {
                $categoryIdsChild = array();
                $categoryChilds = $cache->get('category_child_'.$c->id);
                if ($categoryChilds === false) {
                    $categoryChilds = Category::find()
                        ->where(['status' => [STATUS_ACTIVE],'parent_id' => $c->id])
                        ->orderBy(['number_order' => SORT_ASC])
                        ->all();
                    $cache->set('category_child_'.$c->id, $categoryChilds, 30);
                }

                $categoryIdsChild[] = $c->id;
                foreach ($categoryChilds as $cc) {
                    $categoryIdsChild[] = $cc->id;
                }

                $newsCategory = News::searchIndex([
                    'category_id' => $categoryIdsChild,
                    'status' => NEWS_STATUS_PUBLISHED,
                    'show_home' => 1,
                    'type' => [0, 1, 3, 4],
                ], 0, $c->show_home_limit);

                $cache->set('news_category_home_' . $c->id, $newsCategory, 30);
            }

            foreach ($newsCategory as $nc) {
                if (empty($nc->logo))
                    $nc->logo = '/frontend/img/news-item.jpg';
                $c->news[] = $nc;
            }
        }

        $lefts = array();
        $rights = array();
        $categoryHot = array();
        foreach ($categories as $c) {
            if ($c->is_hot == 1) {
                if (empty($categoryHot)) {
                    $categoryHot = $c;
                }
            } else {
                if ($c->show_home > 100 && $c->show_home < 200)
                    $lefts[] = $c;
                elseif ($c->show_home > 200)
                    $rights[] = $c;
            }
        }

        //dunghq - 180317 - cache adv home
        $ads = $cache->get('ads_home');
        if ($ads === false) {
            if (Functions::isMobile()) {
                $ads = Ads::find()
                    ->where('status = ' . STATUS_ACTIVE . ' AND position > 60 AND position <= 80')
                    ->orderBy(['position' => SORT_ASC])->all();
            } else {
                $ads = Ads::find()
                    ->where('status = ' . STATUS_ACTIVE . ' AND position > 0 AND position <= 20')
                    ->orderBy(['position' => SORT_ASC])->all();
            }
            $cache->set('ads_home', $ads, 30);
        }

        $adsWithKey = array();
        foreach ($ads as $a) {
            $a->images = explode('(,)', $a->image);
            $a->htmls = explode('(,)', $a->html);

            $adsWithKey[$a->position] = $a;
        }

        //lastest
        $lastestNews = $cache->get('lastest_news_home');
        if ($lastestNews === false) {
            $lastestNews = News::search([
                'status' => NEWS_STATUS_PUBLISHED,
                'news.type' => [0, 1, 3, 4],
            ], 0, 5, ['news.id' => SORT_DESC]);
            $cache->set('lastest_news_home', $lastestNews, 30);
        }

        //contest
        $hotNews = $cache->get('hot_news_home');
        if ($hotNews === false) {
            $hotNews = News::search([
                'status' => NEWS_STATUS_PUBLISHED,
                'news.type' => [0, 1, 3, 4],
            ], 0, 5, ['news.view_count' => SORT_DESC]);
            $cache->set('hot_news_home', $hotNews, 30);
        }

        return $this->render('index', [
            'categories' => $categories,
            'lefts' => $lefts,
            'rights' => $rights,
            'ads' => $adsWithKey,
            'lastestNews' => $lastestNews,
            'hotNews' => $hotNews,
        ]);
    }

    public function actionIndex2()
    {
        $layoutData = HomeLayout::find()->orderBy(['number_order' => SORT_DESC, 'id' => SORT_ASC])->all();
        return $this->render('index2', [
            'layoutData' => $layoutData,
        ]);
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionClear()
    {
        $cache = Yii::$app->cache;

        $cmd = Yii::$app->request->get('cmd', '');

        switch ($cmd) {
            case 'danh-muc':
                $slug = Yii::$app->request->get('slug', '');

                $cache->set('news_category_' . md5($slug), false);
                $cache->set('videos_category_' . md5($slug), false);
                $cache->set('ads_category', false);
                $cache->set('events_category', false);
                $cache->set('news_popular_category', false);
                break;
            case 'tin-tuc':
                # code...
                break;

            default:
                $categories = $cache->get('categories_home');
                if ($categories !== false) {
                    foreach ($categories as $c) {
                        $cache->set('news_category_home_' . $c->id, false);
                    }
                }
                $cache->set('categories_home', false);
                $cache->set('news_category_video_home', false);
                $cache->set('news_category_news_home', false);
                $cache->set('news_video_home', false);
                $cache->set('ads_home', false);

                break;
        }

        echo 'done';
        die;
    }
}
