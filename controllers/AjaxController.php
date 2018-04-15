<?php
namespace app\controllers;
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 9/25/2016
 * Time: 8:57 PM
 */
use app\helper\Solr;
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
use app\models\Dataweather;
use app\models\Keyweather;

class AjaxController extends BaseController
{
    public function actionIndex(){
        $category_id = intval(Yii::$app->request->post('category_id', 0));
        $tag_id = intval(Yii::$app->request->post('tag_id', 0));
        $type = trim(Yii::$app->request->post('type', ""));
        $anchor_index = Yii::$app->request->post('anchor_index', 0);
        $newsIds = array_map('trim',Yii::$app->request->post('newsIds', []));
        if(($category_id <= 0 && $tag_id <= 0) || $anchor_index <= 0){
            return "";
        }
        $news = array();
        $offset = (20 + $anchor_index*5);
        if ($category_id > 0){
            $category = Category::findOne($category_id);
            if (empty($category)){
                return "";
            }
            $categoryIds = [];
            $category_child_id = Yii::$app->request->post('category_child_id', 0);
            if ($category_child_id > 0){
                $categoryChild = Category::findOne($category_child_id);
                if (empty($categoryChild)){
                    return "";
                }
                $categoryIds[] = $categoryChild->id;
            }else{
                $categoryIds[] = $category->id;
                $categoryChilds = Category::find()
                    ->where(['status' => [STATUS_ACTIVE],'parent_id' => $category->id])
                    ->orderBy(['number_order' => SORT_ASC])
                    ->all();
                foreach ($categoryChilds as $c) {
                    $categoryIds[] = $c->id;
                }
            }
            $order = ['news.publish_time' => SORT_DESC];
            if ($type == "new")
                $order = ['news.publish_time' => SORT_DESC];
            elseif ($type == "share"){
                $order = ['news.view_count' => SORT_DESC];
            }
            $news = NewsCategory::search([
                'category_id' => $categoryIds,
                'not_news' => $newsIds,
                'news.status' => NEWS_STATUS_PUBLISHED,
                'news.type' => [0,1,3,4],
            ],$offset,6,$order);
        }
        if ($tag_id > 0){
            $tag = Tag::findOne($tag_id);
            if (empty($tag)){
                return "";
            }
            $tagIds[] = $tag->id;
            $news = NewsTag::search([
                'tag_id' => $tagIds,
                'not_news' => $newsIds,
                'status' => NEWS_STATUS_PUBLISHED,
                'news.type' => [0,1,3,4],
            ],$offset,6);
        }
        $is_next = 0;
        if (count($news) >= 6) {
            $is_next = 1;
            array_pop($news);
        }
        return $this->renderPartial('index',[
            'news' => $news,
            'is_next' => $is_next,
            'category_id' => $category_id,
            'tag_id' => $tag_id,
        ]);
    }
    public function actionComment(){
        $news_id = intval(Yii::$app->request->post('news_id', 0));
        $message = htmlspecialchars(Yii::$app->request->post('message', ''));
        $result = "";
        if (Yii::$app->user->getIsGuest())
            $this->redirect('/user/login',302);
        if ($news_id <= 0)
            $result = "Chọn một bài viết để gửi bình luận!";
        if (strlen($message) < 6 || strlen($message) > 500)
            $result = "Nội dung phải lớn hơn 6 ký tự và nhỏ hơn 500 ký tự!";

        if ($result == ""){
            $user = Yii::$app->user->identity;
            $comment = new Comment();
            $comment->user_id = $user->id;
            $comment->user_name = !empty($this->getProfile()->full_name)?$this->getProfile()->full_name:$user->email;
            $comment->email = $user->email;
            $comment->news_id = $news_id;
            $comment->message = $message;
            $comment->create_time = time();
            $comment->status = STATUS_INACTIVE;
            if ($comment->save()){
//            $news = News::find()->where(['id' => $news_id])->one();
//            $news->comment_count = $news->comment_count + 1;
//            $news->save();
                $result = "Gửi thành công. Bình luận của bạn đang được chờ duyệt!";
            }
            else{
                $result = "Bình luận chưa được gửi hãy thử lại!";
            }
        }
        return $result;
    }

    public function actionVideo(){
        $video_id = intval(Yii::$app->request->post('video_id', 0));
        $anchor_index = intval(Yii::$app->request->post('anchor_index', 0));
        if ($anchor_index <= 0)
            return "";
        $videos = array();
        $is_next = 0;
        if ($video_id > 0){
            $video = News::findOne($video_id);
            if (empty($video))
                return "";
            $videoCategorys = NewsCategory::find()->where(['news_id' => $video->id])->all();
            $categoryIds = [];
            foreach ($videoCategorys as $v){
                $categoryIds[] = $v->category_id;
            }
            $offset = ($anchor_index*6);
            $videos = NewsCategory::search([
                'category_id' => $categoryIds,
                'news.status' => NEWS_STATUS_PUBLISHED,
                'news.type' => 2,
            ],$offset,7,['news.publish_time' => SORT_DESC],$video->id);
            if (count($videos) >= 7) {
                $is_next = 1;
                array_pop($videos);
            }
        }else{
            $offset = ($anchor_index*15);
            $videos = News::find()
                ->where(['status' => NEWS_STATUS_PUBLISHED,'type' => 2])
                ->offset($offset)
                ->limit(16)
                ->orderBy(['publish_time' => SORT_DESC])
                ->all();
            if (count($videos) >= 16) {
                $is_next = 1;
                array_pop($videos);
            }
        }
        foreach ($videos as $v){
            if (empty($v->logo))
                $v->logo = "/frontend/img/news-item.jpg";
        }
        return $this->renderPartial('video',[
            'videos' => $videos,
            'is_next' => $is_next,
        ]);
    }

    public function actionEvent(){
        $event_id = intval(Yii::$app->request->post('event_id', 0));
        $news_id = intval(Yii::$app->request->post('news_id', 0));
        $anchor_index = intval(Yii::$app->request->post('anchor_index', 0));
        if ($event_id <= 0 || $anchor_index <= 0)
            return "";
        $event = Event::findOne($event_id);
        if (empty($event))
            return "";
        $offset = ($anchor_index*10);
        $news = News::find()
            ->where('status='.NEWS_STATUS_PUBLISHED.' AND event_id='.$event->id.' AND id <> ' . $news_id)
            ->offset($offset)
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
        return $this->renderPartial('event',[
            'event' => $event,
            'news' => $news,
            'is_next' => $is_next,
        ]);
    }

    public function actionLive(){
        $news_id = intval(Yii::$app->request->post('news_id', 0));
        $live_index = intval(Yii::$app->request->post('live_index', 0));
        if ($news_id <= 0)
            return "";
        $news = News::findOne($news_id);
        if (empty($news) || $news->type != 3)
            return "";

        $newsLive = NewsLiveContent::find()
            ->where(['status' => STATUS_ACTIVE,'news_id' => $news->id])
            ->orderBy(['create_time' => SORT_ASC])
            ->offset($live_index)
            ->all();
        return $this->renderPartial('live',[
            'news' => $news,
            'newsLive' => $newsLive,
        ]);
    }

    public function actionSearch(){
        $keyword = htmlspecialchars(trim(Yii::$app->request->get('keyword', '')));
        $anchor_index = intval(Yii::$app->request->post('anchor_index', 0));
        if ($anchor_index <= 0)
            return "";
        $where = [];
        if($keyword != ""){
            $where['keyword'] = $keyword;
        }
        $where['status'] = NEWS_STATUS_PUBLISHED;
        $offset = ($anchor_index*15);
        if(SOLR_SEARCH){
            $newsList = Solr::searchNews($where, $offset,16);
        }else{
            $newsList = News::search($where, $offset,16,['news.id' => SORT_DESC]);
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
        return $this->renderPartial('search',[
            'keyword' => $keyword,
            'newsList' => $newsList,
            'is_next' => $is_next,
        ]);
    }

    public function actionComments(){
        $news_id = intval(Yii::$app->request->post('news_id', 0));
        $index_comment = intval(Yii::$app->request->post('index_comment', 0));
        if ($index_comment <= 0)
            return "";
        $news = News::findOne($news_id);
        if (!$news)
            return "";
        $offset = ($index_comment*5);
        $comments = Comment::find()
            ->where(['status' => STATUS_ACTIVE,'news_id' => $news->id])
            ->offset($offset)
            ->limit(6)
            ->orderBy(['create_time' => SORT_DESC])
            ->all();
        $is_next = 0;
        if (count($comments) >= 6) {
            $is_next = 1;
            array_pop($comments);
        }
        return $this->renderPartial('comments',[
            'comments' => $comments,
            'news' => $news,
            'is_next' => $is_next,
        ]);
    }
    public function actionItem(){
        $category_id = intval(Yii::$app->request->post('category_id', 0));
        $tag_id = intval(Yii::$app->request->post('tag_id', 0));
        $news_id = intval(Yii::$app->request->post('news_id', 0));
        $anchor_index = Yii::$app->request->post('anchor_index', 0);
        if(($category_id <= 0 && $tag_id <= 0) || $anchor_index <= 0){
            return "";
        }
        $newsList = array();
        $offset = $anchor_index;
        if ($category_id > 0){
            $category = Category::findOne($category_id);
            if (empty($category)){
                return "";
            }
            $categoryIds = [];
            $categoryIds[] = $category->id;
            $categoryChilds = Category::find()
                ->where(['status' => [STATUS_ACTIVE],'parent_id' => $category->id])
                ->orderBy(['number_order' => SORT_ASC])
                ->all();
            foreach ($categoryChilds as $c) {
                $categoryIds[] = $c->id;
            }
            $newsList = NewsCategory::search([
                'category_id' => $categoryIds,
                'news.status' => NEWS_STATUS_PUBLISHED,
                'news.type' => [0,1,3,4],
            ],$offset,2,['news.publish_time' => SORT_DESC],$news_id);
        }
        if ($tag_id > 0){
            $tag = Tag::findOne($tag_id);
            if (empty($tag)){
                return "";
            }
            $tagIds[] = $tag->id;
            $newsList = NewsTag::search([
                'tag_id' => $tagIds,
                'status' => NEWS_STATUS_PUBLISHED,
                'news.type' => [0,1,3,4],
            ],$offset,2,['news.publish_time' => SORT_DESC],$news_id);
        }
        $is_next = 0;
        if (count($newsList) >= 2) {
            $is_next = 1;
        }
        $news = array();
        if (count($newsList)> 0)
            $news = $newsList[0];

        //ads
        $ads = Ads::find()->where('status = ' . STATUS_ACTIVE . ' AND position > 40 AND position <= 60')->all();
        $adsMobile = Ads::find()->where('status = ' . STATUS_ACTIVE . ' AND position > 80 AND position <= 100')->all();
        $adsWithKey = array();
        foreach ($ads as $a){
            $a->images = explode('(,)',$a->image);
            $a->htmls = explode('(,)',$a->html);
            $adsWithKey[$a->position] = $a;
        }
        foreach ($adsMobile as $a){
            $a->images = explode('(,)',$a->image);
            $a->htmls = explode('(,)',$a->html);
            $adsWithKey[$a->position] = $a;
        }
        return $this->renderPartial('item',[
            'news' => $news,
            'ads' => $adsWithKey,
            'is_next' => $is_next,
            'category_id' => $category_id,
            'tag_id' => $tag_id,
        ]);
    }

    public function actionCategorynews(){
        $cache = Yii::$app->cache;

        $type = trim(Yii::$app->request->get('type', ''));


        if($type == 'home') {
//            $newsCategory = $cache->get('news_category_app_home');
            $newsCategory = false;
            if($newsCategory === false)
            {
                $categories = $cache->get('categories_app_home');
                if($categories === false)
                {
                    $categories = Category::find()->where('status = '.STATUS_ACTIVE.' AND show_home > 0')->orderBy(['show_home' => SORT_ASC])->asArray()->all();
                    $categories = Functions::removeKey($categories);
                    $cache->set('categories_app_home', $categories, 30);
                }

                $newsCategory = [];
                foreach($categories as $k=>$c)
                {
                    $newsCategory_temp = NewsCategory::search([
                        'category_id' => $c['id'], 'status' => NEWS_STATUS_PUBLISHED, 'show_home' => 1, 'type' => [0, 1, 3, 4],
                    ], 0, $c['show_home_limit']);

                    $newsCategory_temp = Functions::removeKey($newsCategory_temp);

                    foreach($newsCategory_temp as $nc){
                        if (empty($nc->logo))
                            $nc->logo = '/frontend/img/news-item.jpg';

                        unset($nc->content);
                        $nc->category_name = $c['name'];
                        $categories[$k]['news'][] = $nc;
                    }
                }
                $cache->set('news_category_app_home', $categories, 30);

                Functions::requestToMobile(true,'',$categories);
            }
        }else{
            $cid = (int)Yii::$app->request->get('cid', '');
            $c = Category::find()->where(['id' => $cid])->one();

            $begin = (int)Yii::$app->request->get('begin', 0);
            $limit = (int)Yii::$app->request->get('limit', 10);
            
            $order = ['news.publish_time' => SORT_DESC];

            //Lay danh muc con
            $categoryChilds = $cache->get('category_child_app_'.$c->id);
            if ($categoryChilds === false) {
                $categoryChilds = Category::find()
                    ->where(['status' => [STATUS_ACTIVE],'parent_id' => $c->id])
                    ->orderBy(['number_order' => SORT_ASC])
                    ->all();
                $cache->set('category_child_app_'.$c->id, $categoryChilds, 30);
            }

            $categoryIds[] = $c->id;
            foreach ($categoryChilds as $c) {
                $categoryIds[] = $c->id;
            }
            // Lay tin thuoc ca dm con lan dm cha
            $newsCategory = $cache->get('news_category_app_'.$c->id.'_'.$begin);
            if ($newsCategory === false) {
                $newsCategory = NewsCategory::search([
                    'category_id' => $categoryIds,
                    'news.status' => NEWS_STATUS_PUBLISHED,
                    'news.type' => [0,1,2,3,4],
                ],$begin,$limit,$order);
                $newsCategory = Functions::removeKey($newsCategory);
                $cache->set('news_category_app_'.$c->id.'_'.$begin, $newsCategory, 30);
            }

            foreach($newsCategory as $nc){
                if (empty($nc->logo))
                    $nc->logo = '/frontend/img/news-item.jpg';

                unset($nc->content);
                $nc->category_name = $c['name'];

                $c->news[] = $nc;
            }

            if($c){
                Functions::requestToMobile(true,'',$c);
            }
        }

        Functions::requestToMobile(false,'');
    }

    public function actionEventnews(){
        $id = trim(Yii::$app->request->get('eid', ''));
        if($id == ''){
            Functions::requestToMobile(false,'Thieu thong tin');
        }
        $event = Event::find()->where(['id' => $id])->one();
        if(empty($event)){
            Functions::requestToMobile(false,'Ko co su kien nay');
        }

        $begin = (int)Yii::$app->request->get('begin', 0);
        $limit = (int)Yii::$app->request->get('limit', 11);

        $news = News::find()
            ->where(['status' => NEWS_STATUS_PUBLISHED,'event_id'=>$event->id])
            ->offset($begin)
            ->limit($limit)
            ->orderBy(['publish_time' => SORT_DESC])
            ->asArray()
            ->all();

        foreach ($news as $k=>$n){
            unset ($news[$k]['content']);
            unset ($news[$k]['source']);

            $c = Category::find()->where(['id' => $n['category_id']])->one();

            $news[$k]['category_name'] = $c['name'];

            if (empty($news[$k]['logo'])){
                $news[$k]['logo'] = '/frontend/img/news-item.jpg';
            }
        }
        if($news)
        {
            Functions::requestToMobile(true, '', $news);
        }
        Functions::requestToMobile(false,'Ko co tin nao');
    }

    public function actionCategory() {
        $cache = Yii::$app->cache;

        $type = trim(Yii::$app->request->get('type', ''));
        $categories = false;
        switch($type) {
            case 'header':
                $categories = $cache->get('categories_app_header');
                if ($categories === false) {
                    $categories = Category::find()->where(['status' => [STATUS_ACTIVE]])->orderBy(['id' => SORT_DESC])->asArray()->all();
                    $categories = Functions::removeKey($categories);
                    $cache->set('categories_app_header', $categories, 60);
                }
                break;
            case 'home' :
                $categories = $cache->get('categories_app_home');
                if ($categories === false) {
                    $categories = Category::find()->where('status = '.STATUS_ACTIVE.' AND show_home > 0')->orderBy(['show_home' => SORT_ASC])->asArray()->all();
                     $categories = Functions::removeKey($categories);
                    $cache->set('categories_app_home', $categories, 30);
                }
                break;
            default :
        }
        if($categories){
            Functions::requestToMobile(true,'',$categories);
        }else{
            Functions::requestToMobile(false,'');
        }
    }
    public function actionNews() {
        $cache = Yii::$app->cache;
        $id = (int)(Yii::$app->request->get('id', ''));


        //dunghq - 190317 - cache  news
        $news = $cache->get('news_detail_app_'.$id);
        if ($news === false) {
            $news = News::find()->where(['id' => $id])->asArray()->one();
            $cache->set('news_detail_app_'.$id, $news, 30);
        }

        $categoryIds[] = $news['category_id'];

        $categoryChilds = $cache->get('news_category_child_app_'.$news['category_id']);
        if ($categoryChilds === false) {
            $categoryChilds = Category::find()
                ->where(['status' => [STATUS_ACTIVE],'parent_id' => $news['category_id']])
                ->orderBy(['number_order' => SORT_ASC])
                ->asArray()
                ->all();
            $cache->set('news_category_child_app_'.$news['category_id'], $categoryChilds, 30);
        }

        foreach ($categoryChilds as $c) {
            $categoryIds[] = $c['id'];
        }

        //dunghq - 190317 - cache same news
        $sameNews = $cache->get('same_news_app_'.$news['id']);
        if ($sameNews === false) {
            $sameNews = NewsCategory::search([
                'category_id' => $categoryIds,
                'status' => NEWS_STATUS_PUBLISHED,
                'news.type' => [0,1,3,4],
            ],0,10,['news.id' => SORT_DESC],$news['id']);
            $cache->set('same_news_app_'.$news['id'], $sameNews, 30);
        }

        //popular news
        if(count($sameNews) > 3){
            $rand_keys = array_rand($sameNews,3);
            $newsRelates[] = $sameNews[$rand_keys[0]];
            $newsRelates[] = $sameNews[$rand_keys[1]];
            $newsRelates[] = $sameNews[$rand_keys[2]];
        }


        foreach ($sameNews as $sn){
            unset ($sn->content);
            unset ($sn->source);

            $c = Category::find()->where(['id' => $sn->category_id])->one();

            $sn->category_name = $c['name'];

            if ($sn->logo == "")
                $sn->logo = "/frontend/img/news-item.jpg";
        }

        //event News
        $events = $cache->get('events_detail_app');
        if($events === false) {
            $events = Event::find()
                ->where(['status' => STATUS_ACTIVE])
                ->offset(0)
                ->limit(3)
                ->orderBy(['create_time' => SORT_DESC])
                ->asArray()
                ->all();
            $cache->set('events_detail_app',$events,30);
        }
        foreach ($events as $k=>$e){
//            $c = Category::find()->where(['id' => $e['category_id']])->one();
//
//            $e['category_name'] = $c['name'];

            if ($events[$k]['logo'] == "")
                $events[$k]['logo'] = "/frontend/img/news-item.jpg";
        }

        //dunghq - 190317 - cache tags
        $tags = $cache->get('tags_detail_app_'.$news['id']);
//         $tags = false;
        if ($tags === false) {
            $newsTags = NewsTag::find()->where(['news_id' => $news['id']])->all();

            $tagIds = [];
            foreach($newsTags as $k => $nt){
                $tagIds[] = $nt['tag_id'];
            }
            $tags = Tag::find()->where(['id' => $tagIds])->limit(5)->asArray()->all();
            $cache->set('tags_detail_app_'.$news['id'], $tags, 30);
        }

        if($news){
            Functions::requestToMobile(true,'',array('news'=>$news,
                'tag'=>$tags,
                'sameNews'=>$sameNews,
                'newsRelates'=>$newsRelates,
                'eventNews'=>$events));
        }else{
            Functions::requestToMobile(false,'');
        }
    }

    public function actionFind(){
        $keyword = htmlspecialchars(trim(Yii::$app->request->get('keyword', '')));
        $page = intval(Yii::$app->request->get('page', 1));

        $where = [];
        if($keyword != ""){
            $where['keyword'] = $keyword;
        }
        $where['status'] = NEWS_STATUS_PUBLISHED;
        $offset = ($page*15);
        if(SOLR_SEARCH){
            $newsList = Solr::searchNews($where, $offset,16);
        }else{
            $newsList = News::search($where, $offset,16,['news.id' => SORT_DESC]);
        }
        $is_next = 0;
        if (count($newsList) >= 16) {
            $is_next = 1;
            array_pop($newsList);
        }
        foreach ($newsList as $n){
            $c = Category::find()->where(['id' => $n->category_id])->one();

            unset($n->content);
            $n->category_name = $c['name'];

            if ($n->logo == ""){
                if ($n->type == 2){
                    $n->logo = "/frontend/img/news-item.jpg";
                }else{
                    $n->logo = "/frontend/img/news-item.jpg";
                }
            }
        }
        if($newsList){
            Functions::requestToMobile(true,'',$newsList);
        }else{
            Functions::requestToMobile(false,'');
        }
    }
    public function actionLike(){
        $id = (int)(Yii::$app->request->get('id', ''));

        $news = News::find()->where(['id' => $id])->asArray()->one();

        if($news){
            Functions::requestToMobile(true,'',$news);
        }else{
            Functions::requestToMobile(false,'');
        }
    }

    public function actionTag() {
        $slug = trim(Yii::$app->request->get('slug', ''));

        if($slug == ''){
            Functions::requestToMobile(false,'');
        }

        $tag = Tag::find()->where(['slug' => $slug])->one();
        if(empty($tag)){
            Functions::requestToMobile(false,'');
        }
        $tagIds[] = $tag->id;

        $begin = (int)Yii::$app->request->get('begin', 0);
        $limit = (int)Yii::$app->request->get('limit', 21);

        $news = NewsTag::search([
            'tag_id' => $tagIds,
            'news.status' => NEWS_STATUS_PUBLISHED,
            'news.type' => [0,1,3,4],
        ],$begin,$limit);

        foreach ($news as $n){
            if (empty($n->logo)){
                $n->logo = '/frontend/img/news-item.jpg';
            }
        }

        if($news){
            Functions::requestToMobile(true,'',$news);
        }else{
            Functions::requestToMobile(false,'');
        }
    }

    public function actionTrend(){
        $cache = Yii::$app->cache;
        $tags = $cache->get('tag_header');
        if ($tags === false) {
            $tags = NewsTag::searchTag([
                'tag.show_home' => 1
            ],0,2);
            $cache->set('tag_header', $tags, 60);
        }
        if($tags){
            Functions::requestToMobile(true,'',$tags);
        }else{
            Functions::requestToMobile(false,'');
        }
    }
	
	 public function actionSetdataweather() {
        $id_weather = trim(Yii::$app->request->post('id_weather', ''));
        $data = trim(Yii::$app->request->post('data', ''));

        if($id_weather == '' || $data == ''){
            Functions::requestToMobile(false,'');
        }

        $dataweather = Dataweather::find()->where(['id_weather' => $id_weather])->one();
        if($dataweather == null){
            $model = new Dataweather();
            $model->id_weather = $id_weather;
            $model->data = $data;
            if($model->save()){
                Functions::requestToMobile(true,'Suc');
            }
            Functions::requestToMobile(false,'Err');
        }
        $dataweather->data = $data;
        if($dataweather->save()){
            Functions::requestToMobile(true,'');
        }
        Functions::requestToMobile(false,'');
    }

    public function actionGetdataweather() {
        $id_weather = trim(Yii::$app->request->get('id_weather', ''));
        $dataweather = Dataweather::find()->where(['id_weather' => $id_weather])->asArray()->one();
        if($dataweather != null){
            Functions::requestToMobile(true,'',$dataweather);
        }
        Functions::requestToMobile(false,'');
    }
	
	public function actionDeletedataweather() {
        $id = trim(Yii::$app->request->get('id', ''));
        $dataweather = Dataweather::findOne($id);
        if($dataweather != null){
			if($dataweather->delete()){
				Functions::requestToMobile(true,'');
			}
            Functions::requestToMobile(false,'');
        }
        Functions::requestToMobile(false,'');
    }
	
	
	
	public function actionSetkeyweather() {
        $key_weather = trim(Yii::$app->request->get('key_weather', ''));
        $max_limit_day = intval(Yii::$app->request->get('max_limit_day', 500));
        $max_limit_minute = intval(Yii::$app->request->get('max_limit_minute', 10));
        $type = intval(Yii::$app->request->get('type', ''));
        $status = intval(Yii::$app->request->get('status', ''));
        $keyweather = Keyweather::find()->where(['key_weather' => $key_weather])->one();
        if($keyweather == null){
            $model = new Keyweather();
            $model->key_weather = $key_weather;
            $model->limit_day = 0;
            $model->max_limit_day = $max_limit_day;
            $model->limit_minute = 0;
            $model->max_limit_minute = $max_limit_minute;
            $model->day = 0;
            $model->minute = 0;
            $model->type = $type;
            $model->status = $status;
            if($model->save()){
                Functions::requestToMobile(true,'');
            }
            Functions::requestToMobile(false,'');
        }
        Functions::requestToMobile(false,'');
    }
	
	 public function actionGetkeyall() {
		$model =  Keyweather::find()->asArray()->all();
        if( $model != null ){
            Functions::requestToMobile(true,'',$model);
        }
        Functions::requestToMobile(false,'');
    }
	
    public function actionGetkeyweather() {
        $D = (int)date("d");
        $H = (int)date("H");
        $I = (int)date("i");
        $M = $H*60+$I;
        $keyWun = $this->getkeyWeather(0,$D,$M,3);
        $keyGoogle = $this->getkeyWeather(1,$D,$M,1);
        $keyWaqi = $this->getkeyWeather(2,$D,$M,1);
        if( $keyWun != null && $keyGoogle != null && $keyWaqi != null){
            $key = array('keyWun'=>$keyWun, 'keyGoogle'=>$keyGoogle, 'keyWaqi'=>$keyWaqi);
            Functions::requestToMobile(true,'',$key);
        }
        Functions::requestToMobile(false,'');
    }

    public function actionGetkey() {
        $type = intval(Yii::$app->request->get('type', 0));
        $i = intval(Yii::$app->request->get('i', 1));
        $D = (int)date("d");
        $H = (int)date("H");
        $I = (int)date("i");
        $M = $H*60+$I;
        $keyW = $this->getkeyWeather($type,$D,$M,$i);
        if( $keyW != null ){
            $key = array('key'=>$keyW );
            Functions::requestToMobile(true,'',$key);
        }
        Functions::requestToMobile(false,'');
    }

    public function getkeyWeather($type,$D,$M,$i) {
        $key = null;
        $model =  Keyweather::find()->where("status = 0 AND type = ".$type." AND day < ".$D)->one();
        if($model != null){
            $model->limit_day = $i;
            $model->limit_minute = $i;
            $model->day = $D;
            $model->minute = $M;
            $model->save();
            $key = $model->key_weather;
        }else {
            $mode2 =  Keyweather::find()->where("status = 0 AND type = ".$type." AND day = ".$D." AND minute < ".$M)->one();
            if($mode2 != null){
                $mode2->limit_day = $mode2->limit_day+$i;
                $mode2->limit_minute = $i;
                $mode2->minute = $M;
                $mode2->save();
                $key = $mode2->key_weather;
            }else {
                $mode3 =  Keyweather::find()->where("status = 0 AND type = ".$type." AND day = ".$D." AND minute = ".$M." AND limit_day < max_limit_day AND limit_minute < max_limit_minute")->one();
                if($mode3 != null){
                    $mode3->limit_day =  $mode3->limit_day+$i;
                    $mode3->limit_minute = $mode3->limit_minute+$i;
                    $mode3->save();
                    $key = $mode3->key_weather;
                }
            }
        }
       return $key;
    }
	
	public function actionDeletekeyweather() {
		$key_weather = trim(Yii::$app->request->get('key_weather', ''));
        $keyweather = Keyweather::find()->where(['key_weather' => $key_weather])->one();
        if($keyweather != null){
			if($keyweather->delete()){
				Functions::requestToMobile(true,'');
			}
            Functions::requestToMobile(false,'');
        }
        Functions::requestToMobile(false,'');
    }
	
	
}
