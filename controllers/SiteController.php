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
//        echo '1: '. date('Y/m/d H:i:s', time()) . '</br>';
        $cache = Yii::$app->cache;
        //dunghq - 180317 - cache category home
        $categories = false;
        $categories = $cache->get('categories_home');
        if ($categories === false) {
            $categories = Category::find()->where('status = ' . STATUS_ACTIVE . ' AND show_home > 0')->orderBy(['show_home' => SORT_ASC])->all();

            $cache->set('categories_home', $categories, 30);
        }
//        echo '2: '. date('Y/m/d H:i:s', time()) . '</br>';

        $categoryIds = [];
        foreach ($categories as $c) {
            $categoryIds[] = $c->id;
        }

        foreach ($categories as $c) {
//            echo '2.0 '. $c->id.': '. date('Y/m/d H:i:s', time()) . '</br>';
            $c->news = [];

            $newsCategory = $cache->get('news_category_home_' . $c->id);
            // $newsCategory = false;
            if ($newsCategory === false) {
                $categoryIdsChild = array();
                //dunghq 0707 lay ca trong dm con
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

//                echo '2.0.1 '. $c->id.': '. date('Y/m/d H:i:s', time()) . '</br>';

                if ($c->id == 25 || $c->id == 17) {
                    $newsCategory = NewsCategory::search([
                        'category_id' => [$c->id],
                        'status' => NEWS_STATUS_PUBLISHED,
                        'show_home' => 1,
                        'type' => [0, 1, 3, 4],
                    ], 0, $c->show_home_limit);
                } else {
//                    echo '2.0.1.0 '. $c->id.': '. date('Y/m/d H:i:s', time()) . '</br>';
                    $newsCategory = News::searchIndex([
                        'category_id' => $c->id,
                        'status' => NEWS_STATUS_PUBLISHED,
                        'show_home' => 1,
                        'type' => [0, 1, 3, 4],
                    ], 0, $c->show_home_limit);
//                    echo '2.0.1.1 '. $c->id.': '. date('Y/m/d H:i:s', time()) . '</br>';
                }

//                echo '2.0.2 '. $c->id.': '. date('Y/m/d H:i:s', time()) . '</br>';

                $cache->set('news_category_home_' . $c->id, $newsCategory, 30);
            }

//            echo '2.1 '. $c->id.': '. date('Y/m/d H:i:s', time()) . '</br>';

            foreach ($newsCategory as $nc) {
                if (empty($nc->logo))
                    $nc->logo = '/frontend/img/news-item.jpg';
                $c->news[] = $nc;
            }
//            echo '2.2 '. $c->id.': '. date('Y/m/d H:i:s', time()) . '</br>';
        }
//        echo '3: '. date('Y/m/d H:i:s', time()) . '</br>';

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
        $videosHot = array();
        $videosHotView = array();
        $videosHotComment = array();
        $newsHot = array();
        if ($categoryHot) {
            //dunghq - 180317 - cache news category video home
            $videosHot = $cache->get('news_category_video_home');
            if ($videosHot === false) {
                $videosHot = News::searchIndex([
                    'category_id' => $categoryHot->id,
                    'status' => NEWS_STATUS_PUBLISHED,
                    'type' => 2,
                ], 0, 6);
                $cache->set('news_category_video_home', $videosHot, 30);
            }

            foreach ($videosHot as $v)
                if ($v->logo == "")
                    $v->logo = "/frontend/img/news-item.jpg";
            $videosHotView = $videosHot;
            usort($videosHotView, function ($a, $b) {
                return $b->view_count - $a->view_count;
            });
            $videosHotComment = $videosHot;
            usort($videosHotComment, function ($a, $b) {
                return $b->comment_count - $a->comment_count;
            });

            //dunghq - 180317 - cache news category news home
            $newsHot = $cache->get('news_category_news_home');
            if ($newsHot === false) {
                $newsHot = News::searchIndex([
                    'category_id' => $categoryHot->id,
                    'status' => NEWS_STATUS_PUBLISHED,
                    'type' => [0, 1, 3, 4],
                ], 0, 6);
                $cache->set('news_category_news_home', $newsHot, 30);
            }
            foreach ($newsHot as $n)
                if ($n->logo == "")
                    $n->logo = "/frontend/img/news-item.jpg";
        }
//        echo '4: '. date('Y/m/d H:i:s', time()) . '</br>';

        if (isset($rights[0]) && $rights[0]->news) {
            $rights[0]->order_read = $rights[0]->news;
            usort($rights[0]->order_read, function ($a, $b) {
                return $b->view_count - $a->view_count;
            });
            $rights[0]->order_new = $rights[0]->news;
            usort($rights[0]->order_new, function ($a, $b) {
                return $b->publish_time - $a->publish_time;
            });
            $rights[0]->order_comment = $rights[0]->news;
            usort($rights[0]->order_comment, function ($a, $b) {
                return $b->comment_count - $a->comment_count;
            });
        }

        //dunghq - 180317 - cache video home
        $videos = $cache->get('news_video_home');
        if ($videos === false) {
            $videos = News::find()
                ->where(['status' => NEWS_STATUS_PUBLISHED, 'show_home' => 1, 'type' => 2])
                ->orderBy(['publish_time' => SORT_DESC])
                ->limit(10)
                ->all();
            $cache->set('news_video_home', $videos, 30);
        }
        foreach ($videos as $v)
            if ($v->logo == "")
                $v->logo = "/frontend/img/news-item.jpg";

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
//        echo '5: '. date('Y/m/d H:i:s', time()) . '</br>';

        $adsWithKey = array();
        foreach ($ads as $a) {
            $a->images = explode('(,)', $a->image);
            $a->htmls = explode('(,)', $a->html);

            $adsWithKey[$a->position] = $a;
        }
        //dunghq - 190317 - cache same news
        $dailyNews = $cache->get('daily_news_home');
        if ($dailyNews === false) {
            $dailyNews = News::search([
//                'category_id' => $categoryIds,
                'daily' => 1,
                'status' => NEWS_STATUS_PUBLISHED,
                'news.type' => [0, 1, 3, 4],
            ], 0, 10, ['news.id' => SORT_DESC]);
            $cache->set('daily_news_home', $dailyNews, 30);
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
        $contestNews = $cache->get('contest_news_home');
        if ($contestNews === false) {
            $contestNews = News::search([
                'contest' => 1,
                'status' => NEWS_STATUS_PUBLISHED,
                'news.type' => [0, 1, 3, 4],
            ], 0, 5, ['news.id' => SORT_DESC]);
            $cache->set('contest_news_home', $contestNews, 30);
        }
//        echo '6: '. date('Y/m/d H:i:s', time()) . '</br>';

//        die();

        return $this->render('index', [
            'categories' => $categories,
            'categoryHot' => $categoryHot,
            'newsHot' => $newsHot,
            'videosHot' => $videosHot,
            'videosHotView' => $videosHotView,
            'videosHotComment' => $videosHotComment,
            'lefts' => $lefts,
            'rights' => $rights,
            'videos' => $videos,
            'ads' => $adsWithKey,
            'dailyNews' => $dailyNews,
            'lastestNews' => $lastestNews,
            'contestNews' => $contestNews,
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
