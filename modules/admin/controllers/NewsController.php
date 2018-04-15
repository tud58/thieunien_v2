<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\base\Exception;
use yii\web\Controller;
use app\models\News;

use app\models\Log;
use app\models\Category;
use app\models\NewsCategory;
use app\models\NewsLiveContent;
use app\models\Tag;
use app\models\Event;
use app\models\NewsTag;
use app\models\UserPost;
use app\helper\Functions;
use app\helper\Solr;
use yii\web\Response;
use yii\widgets\ActiveForm;

class NewsController extends BaseController
{

    public function actionIndex()
    {
        $this->view->title = "Quản lý tin tức";

        $request = Yii::$app->request;
        $page = $request->get('page', 1);
        if ($page <= 0) {
            $page = 1;
        }
        $searchData = [];
        $searchData['id'] = $request->get('id', '');
        $searchData['user_id'] = $request->get('user_id', '');
        $searchData['status'] = $request->get('status', '');
        $searchData['category_id'] = $request->get('category_id', '');
        $searchData['show_home'] = $request->get('show_home', '');

        $searchData['keyword'] = trim($request->get('keyword', ''));
        $searchData['cancel'] = trim($request->get('cancel', ''));

        $where = [];


        if ($searchData['id'] > 0) {
            $where['news.id'] = $searchData['id'];
        }
        if ($searchData['user_id'] > 0) {
            $where['news.user_id'] = $searchData['user_id'];
        }
        if ($searchData['keyword'] != "") {
            $where['keyword'] = $searchData['keyword'];
        }
        if ($searchData['category_id'] != "") {
            $where['category_id'] = $searchData['category_id']; //;
        }
        if ($searchData['status'] != '') {
            $where['news.status'] = $searchData['status'];
        }
        if ($searchData['show_home'] != '') {
            $where['news.show_home'] = $searchData['show_home'];
        }
        if ($searchData['cancel'] != '') {
            $this->view->title = "Danh sách bài bị trả lại";
            $searchData['status'] = NEWS_STATUS_CANCELED;
            $where['news.status'] = NEWS_STATUS_CANCELED;
        }

        $data = News::search2($where, ($page - 1) * ADMIN_ROW_PER_PAGE, ADMIN_ROW_PER_PAGE, ['news.id' => SORT_DESC]);

        $newsList = $data['data'];
        $count_items = $data['count_items'];
        $page_count = ceil($count_items / ADMIN_ROW_PER_PAGE);


        $categoryTree = Category::getCategoryTree(false, '');

        $newsIds = [];
        foreach ($newsList as $n) {
            $newsIds[] = $n->id;
        }
        $newsCategory = NewsCategory::find()->where(['news_id' => $newsIds])->all();
        $newsCategoryName = [];
        foreach ($newsCategory as $nc) {
            if (isset($categoryTree[$nc->category_id]))
                $newsCategoryName[$nc->news_id][] = (object)array('id' => $nc->category_id, 'name' => $categoryTree[$nc->category_id]);
        }

        $categoryTree = Category::getCategoryTree(false, '--', [STATUS_ACTIVE, STATUS_INACTIVE]);


        return $this->render("index", [
            'newsList' => $newsList,
            'newsCategoryName' => $newsCategoryName,
            'count_items' => $count_items,
            'page_count' => $page_count,
            'page' => $page,
            'pageUrl' => '/admin/news?' . Functions::searchCondToQuery($searchData),
            'searchData' => $searchData,
            'categoryTree' => $categoryTree,
        ]);
    }

    public function actionAdd()
    {
        $request = Yii::$app->request;
        $isCreate = false;
        $news_id = $request->get('id', 0);
        $role_id = $this->getUser()->role_id;
        $news_type = $request->get('type', '');


        if ($news_id > 0) {
            $model = News::findOne($news_id);
            if (!$model) {
                throw new \yii\web\HttpException(404, "Liên kết không tồn tại");
            }

            $newsCategory = NewsCategory::find()->where(['news_id' => $news_id])->all();
            $model->category = [];
            for ($i = 0; $i < count($newsCategory); $i++) {
                $model->category[] = $newsCategory[$i]->category_id;
            }
            $newsTag = NewsTag::find()->where(['news_id' => $news_id])->all();
            $model->tag = [];
            for ($i = 0; $i < count($newsTag); $i++) {
                $model->tag[] = $newsTag[$i]->tag_id;
            }
            if ($model->type == 5) {
                $news_type = 'compare';
            }

        } else {
            $isCreate = true;
            $model = new News;
            $model->category = [];
            $model->tag = [];

            $user_post_id = $request->get('user_post', 0);
            if ($user_post_id > 0) {
                $userPost = UserPost::findOne($user_post_id);
                if ($userPost) {
                    $model->title = $userPost->title;
                    $model->content = $userPost->content;
                }
            }
        }
        $model->setScenario("admin");

        //check quyền sửa bài
        $canEdit = true;
        $canEditMessage = '';
        if (!$isCreate) {
            if ($model->status == NEWS_STATUS_PUBLISHED) {
                if (!in_array($this->getUser()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])) {
                    $canEdit = false;
                    $canEditMessage = 'Bài viết đã xuất bản bạn không thể sửa bài viết này!';
                }
            } else if ($model->status == NEWS_STATUS_APPROVED) {
                if (!in_array($this->getUser()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR, ROLE_EDITOR])) {
                    $canEdit = false;
                    $canEditMessage = 'Bài viết đã được gửi xuất bản bạn không thể sửa bài viết này!';
                }
            } else if ($model->status == STATUS_DELETED) {
                if (!in_array($this->getUser()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])) {
                    $canEdit = false;
                    $canEditMessage = 'Bài viết đã bị hủy bạn không thể sửa bài viết này!';
                }
            }

            if ($canEdit && !in_array($this->getUser()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR, ROLE_EDITOR]) && $model->user_id != $this->getUser()->id) {
                $canEdit = false;
                $canEditMessage = 'Bài viết của tác giả khác, bạn không thể sửa bài viết này!';
            }
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->publish_time > 0) {
            $model->publish_time_temp = date('d-m-Y', $model->publish_time);
            $model->publish_time_temp_hour = date('H:i', $model->publish_time);
        } else {
            $model->publish_time_temp = '';
            $model->publish_time_temp_hour = '';
        }
        if ($model->active_time > 0) {
            $model->active_time_temp = date('d-m-Y', $model->active_time);
            $model->active_time_temp_hour = date('H:i', $model->active_time);
        } else {
            $model->active_time_temp = '';
            $model->active_time_temp_hour = '';
        }
        $categoryTree = Category::getCategoryTree(false, ' -- ');
        $statusBeforeSave = $model->status;
        if ($request->isPost) {
            if (!$canEdit) {
                Yii::$app->session->addFlash('error', 'Bạn không thể sửa bài này.');
                return $this->redirect(Yii::$app->request->getReferrer());
            }


            $post = $request->post();
            $model->load($post);

            //dunghq - news compare
//            if(isset($post['img_compare_1']) && count($post['img_compare_1']) > 0){
//                $model->img_compare_1 = json_encode($post['img_compare_1']);
//            }else{
//                $model->img_compare_1 = [];
//            }
//            if(isset($post['img_compare_2']) && count($post['img_compare_2']) > 0){
//                $model->img_compare_2 = json_encode($post['img_compare_2']);
//            }else{
//                $model->img_compare_2 = [];
//            }
//            if(isset($post['img_compare_1']) && count($post['img_compare_description']) > 0){
//                $model->img_compare_description = json_encode($post['img_compare_description']);
//            }else{
//                $model->img_compare_description = [];
//            }

            if (isset($post['category']) && count($post['category']) > 0) {
                $model->category = $post['category'];
            } else {
                $model->category = [];
            }

            if (!in_array($model->category_id, $model->category)) {
                $model->category[] = $model->category_id;
            }

            if (isset($post['tag']) && count($post['tag']) > 0) {
                $model->tag = $post['tag'];
            } else {
                $model->tag = [];
            }

            foreach ($model->tag as $tag_key => $tag_val) {
                if (!(int)$tag_val > 0) {
                    if ($new_tag_id = Tag::insertTag($tag_val)) {
                        $model->tag[$tag_key] = $new_tag_id;
                    } else {
                        unset($model->tag[$tag_key]);
                    }
                }
            }

            if (isset($post['daily']) && $post['daily']) {
                $model->daily = 1;
            } else {
                $model->daily = 0;
            }

            if (isset($post['contest']) && $post['contest']) {
                $model->contest = 1;
            } else {
                $model->contest = 0;
            }

            $action = isset($post['action']) ? $post['action'] : '';

            if ($action == 'save_draft') {
                $status = NEWS_STATUS_DRAFT;
            } else if ($action == 'request_review') {
                $status = NEWS_STATUS_PENDDING_REVIEW;
            } else if ($action == 'request_publish' && in_array($role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR, ROLE_EDITOR])) {
                $status = NEWS_STATUS_APPROVED;
            } else if ($action == 'publish' && in_array($role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])) {
                $status = NEWS_STATUS_PUBLISHED;
            } else if ($action == 'delete' && in_array($role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])) {
                $status = STATUS_DELETED;
            } else if ($action == 'cancel' && in_array($role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR, ROLE_EDITOR])) {
                $status = NEWS_STATUS_CANCELED;
            } else {
                echo 'Không xác định trạng thái bài viết';
                exit;
            }

            if ($model->validate()) {
                $model->status = $status;
                if ($isCreate) {
                    $model->user_id = Yii::$app->user->id;
                    $model->user_full_name = $this->getProfile()->full_name;
                    $model->create_time = time();
                }

                //$model->slug = Functions::toslug($model->title);

                if ($model->status == NEWS_STATUS_PUBLISHED && $model->publish_time_temp == '') {
                    $model->publish_time = time();
                }

                if ($model->save()) {
                    $primaryKey = $model->getPrimaryKey();

                    NewsCategory::deleteAll('news_id = ' . $news_id);
                    foreach ($model->category as $category_id) {
                        $newsCategory = new NewsCategory;
                        $newsCategory->category_id = $category_id;
                        $newsCategory->news_id = $primaryKey;
                        $newsCategory->save();
                    }
                    NewsTag::deleteAll('news_id = ' . $news_id);
                    foreach ($model->tag as $tag_id) {
                        $newsTag = new NewsTag;
                        $newsTag->tag_id = $tag_id;
                        $newsTag->news_id = $primaryKey;
                        $newsTag->save();
                    }
                    Solr::updateNews($primaryKey);
                    //log
                    //$newsAfterSave = array_merge($model->getAttributes(), get_object_vars ($model));
                    if ($isCreate) {
                        $logData = [
                            'action_id' => 101,
                            'reference_id' => $primaryKey,
                            'reference_name' => $model->title,
                            'reference_type' => 'news',
                            //'data' => json_encode($model),
                            /*                            'data_after' => json_encode($newsAfterSave),   */
                        ];
                        Log::saveLog($logData);
                    } else {
                        $logData = [
                            'action_id' => 102,
                            'reference_id' => $primaryKey,
                            'reference_name' => $model->title,
                            'reference_type' => 'news',
                        ];
                        Log::saveLog($logData);

                        //log nếu đổi trạng thái             
                        $statusAfterSave = $model->status;

                        if ($statusBeforeSave != $statusAfterSave) {

                            $action_id = 0;
                            if ($statusAfterSave == NEWS_STATUS_DRAFT) {
                                $action_id = 105;
                            } else if ($statusAfterSave == NEWS_STATUS_PENDDING_REVIEW) {
                                $action_id = 106;
                            } else if ($statusAfterSave == NEWS_STATUS_APPROVED) {
                                $action_id = 107;
                            } else if ($statusAfterSave == NEWS_STATUS_PUBLISHED) {
                                // noti khi duyet tin moi
                                $data_arr = array('title' => $model->title,
                                    'body' => 'Có tin mới',
                                    'id' => $primaryKey
                                );
                                Functions::sendNotiApp($data_arr);

                                $action_id = 108;
                            } else if ($statusAfterSave == STATUS_DELETED) {
                                $action_id = 103;
                            } else if ($statusAfterSave == NEWS_STATUS_CANCELED) {
                                $action_id = 110;
                            }
                            $logData = [
                                'action_id' => $action_id,
                                'reference_id' => $primaryKey,
                                'reference_name' => $model->title,
                                'reference_type' => 'news',
                            ];
                            Log::saveLog($logData);
                        }

                    }

                    //Dunghq 2103 - Clear cache sau khi luu lai
                    $cache = Yii::$app->cache;
                    $cache->set('news_detail_' . md5($model->slug), false);
                    $cache->set('news_live_' . $model->id, false);
                    $cache->set('tags_detail_' . $model->id, false);
                    $cache->set('comments_' . $model->id, false);
                    $cache->set('videos_' . $model->id, false);
                    $cache->set('same_news_' . $model->id, false);
                    $cache->set('events_detail', false);
                    $cache->set('ads_detail', false);
                    $cache->set('ads_mobile_detail', false);

                    //dunghq 2203 - remove cache home
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

                    //dunghq 2203 - remove cache category
                    $categories = $cache->get('categories_header');
                    if ($categories !== false) {
                        foreach ($categories as $c) {
                            $cache->set('news_category_' . md5($c['slug']), false);
                            $cache->set('videos_category_' . md5($c['slug']), false);
                        }
                    }
                    $cache->set('categories_header', false);

                    $cache->set('ads_category', false);
                    $cache->set('events_category', false);
                    $cache->set('news_popular_category', false);


                    Yii::$app->session->addFlash('success', 'Lưu thành công');
                    return $this->redirect('/admin/news');
                }
            }
        }

        $tag_all = Tag::find()->where(['id' => $model->tag])->all();
        $tag_list = [];
        foreach ($tag_all as $tag) {
            $tag_list[$tag->id] = $tag->name;
        }
        $event_all = Event::find()->orderBy(['id' => SORT_DESC])->all();
        $event_list = [];
        foreach ($event_all as $event) {
            $event_list[$event->id] = $event->name;
        }

        return $this->render('add', [
            'news_type' => $news_type,
            'model' => $model,
            'role_id' => $role_id,
            'categoryTree' => $categoryTree,
            'tag_list' => $tag_list,
            'event_list' => $event_list,
            'canEdit' => $canEdit,
            'canEditMessage' => $canEditMessage,
        ]);
    }


    public function actionLive_content()
    {
        $request = Yii::$app->request;

        $news_id = $request->get('news_id', 0);

        $news = News::findOne($news_id);
        if (!$news) {
            throw new \yii\web\HttpException(404, "Liên kết không tồn tại");
        }

        $model = new NewsLiveContent;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            $model->load($post);

            $model->news_id = $news->id;
            $model->user_id = $this->getUser()->id;
            $model->user_full_name = $this->getProfile()->full_name;
            $model->create_time = time();

            if ($model->save()) {

                $logData = [
                    'action_id' => 109,
                    'reference_id' => $news->getPrimaryKey(),
                    'reference_name' => $news->title,
                    'reference_type' => 'news',

                ];
                Log::saveLog($logData);

                Yii::$app->session->addFlash('success', 'Lưu thành công');
                return $this->redirect(Yii::$app->request->getReferrer());
                //return $this->redirect('/admin/category');            
            }

        }


        $live_content_list = NewsLiveContent::find()->andWhere(['news_id' => $news->id])->orderBy(['id' => SORT_DESC])->all();

        return $this->render('live_content', [
            'news' => $news,
            'model' => $model,
            'live_content_list' => $live_content_list,
        ]);
    }

    public function actionSave_note()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {

            $news_id = $request->post('news_id');
            $note = $request->post('note');

            $news = News::findOne($news_id);

            if (!$news) {
                throw new \yii\web\HttpException(404, "Liên kết không tồn tại");
            }

            $noteList = [];
            if (!empty($news->note)) {
                $noteList = json_decode($news->note);
            }

            $addData = [
                'user_id' => Yii::$app->user->id,
                'role_id' => $this->getUser()->role_id,
                'full_name' => $this->getProfile()->full_name,
                'note' => htmlspecialchars($note),
                'create_time' => time()
            ];

            $noteList[] = $addData;
            $news->note = json_encode($noteList);
            if ($news->save()) {
                $logData = [
                    'action_id' => 104,
                    'reference_id' => $news->id,
                    'reference_name' => $news->title,
                    'reference_type' => 'news',

                ];
                Log::saveLog($logData);
                echo 1;
            } else {
                echo 0;
            }
        }
    }

    public function actionLoad_note()
    {
        $news_id = Yii::$app->request->get('news_id');
        $news = News::findOne($news_id);
        $noteList = [];
        if (!empty($news->note)) {
            $noteList = json_decode($news->note);
        }

        return $this->renderPartial('note_view', [
            'noteList' => $noteList,
        ]);
    }

    public function actionQuick_add_tag()
    {
        $msg = "fail";
        $newTagId = "";
        if (!in_array($this->getUser()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR, ROLE_EDITOR, ROLE_AUTHOR])) {
            $msg = "denied";
        } else {
            $tag = Yii::$app->request->get('tag');
            $news_id = Yii::$app->request->get('news_id');
            $slug = Functions::toSlug($tag);
            if (Tag::findOne(['slug' => $slug])) {
                $msg = "exits";
            } else {
                $tagNew = new Tag;
                $tagNew->name = $tag;
                $tagNew->user_id = $this->getUser()->id;
                $tagNew->create_time = time();
                $tagNew->slug = $slug;
                if ($tagNew->save())
                    $msg = "success";

                $newTagId = $tagNew->id;

            }
        }
        return json_encode(array('msg' => $msg, "newTagId" => $newTagId));
    }

    public function actionUser_post()
    {
        $action = Yii::$app->request->get('action', '');

        $id = Yii::$app->request->get('id', 0);
        if ($action == 'delete') {
            if (!in_array($this->getUser()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])) {
                return $this->render('../default/permission_denied');
            }
            if ($id > 0) {
                $userPost = UserPost::findOne($id);
                if ($userPost) {

                    $logData = [
                        'action_id' => 903,
                        'reference_id' => $id,
                        'reference_name' => $userPost->title,
                        'reference_type' => 'user_post',

                    ];
                    Log::saveLog($logData);


                    $userPost->delete();
                }
                Yii::$app->session->addFlash('success', 'Xóa thành công');
                return $this->redirect('/admin/news/user_post');
            }
        }


        $request = Yii::$app->request;
        $page = $request->get('page', 1);
        if ($page <= 0) {
            $page = 1;
        }

        $searchData = [];

        $searchData['id'] = $request->get('id', '');
        $searchData['keyword'] = $request->get('keyword', '');

        $where = [];
        $andWhere = [];

        if ($searchData['id'] > 0) {
            $where['id'] = $searchData['id'];
        }
        if ($searchData['keyword'] != '') {
            $andWhere = ['LIKE', 'name', $searchData['keyword']];
        }


        $list = UserPost::find()->where($where)->andWhere($andWhere)->limit(ADMIN_ROW_PER_PAGE + 1)->offset(($page - 1) * ADMIN_ROW_PER_PAGE)->orderBy(['update_time' => SORT_DESC])->all();
        $count_items = UserPost::find()->where($where)->andWhere($andWhere)->count();

        $page_count = ceil($count_items / ADMIN_ROW_PER_PAGE);

        return $this->render('user_post', [

            'list' => $list,
            'page' => $page,
            'count_items' => $count_items,
            'page_count' => $page_count,
            'pageUrl' => '/admin/news/user_post?' . Functions::searchCondToQuery($searchData),
            'searchData' => $searchData,
        ]);
    }

    public function actionUser_post_detail()
    {
        $id = Yii::$app->request->get('id', 0);
        $userPost = UserPost::findOne($id);
        if (!$userPost) {
            throw new \yii\web\HttpException(404, "Liên kết không tồn tại");
        }

        $action = Yii::$app->request->get('action', '');
        if ($action == 'to_news') {
            if ($userPost->author_id > 0) {
                throw new \yii\web\HttpException(500, "Bài viết này đã có người nhận");
            }
            $userPost->author_id = $this->getUser()->id;
            $userPost->author_full_name = $this->getProfile()->full_name;
            if ($userPost->save()) {
                return $this->redirect('/admin/news/add?user_post=' . $id);
            }
            throw new \yii\web\HttpException(500, "Có lỗi xảy ra");
        }

        return $this->render('user_post_detail', [
            'userPost' => $userPost,
        ]);
    }

    public function actionEdit_showhome()
    {
        $news_id = Yii::$app->request->get('news_id', 0);
        $show_home = Yii::$app->request->get('show_home', 0);
        $news = News::findOne($news_id);
        if ($news) {
            $news->show_home = $show_home;
            $news->save();
            Yii::$app->session->addFlash('success', 'Cập nhật thành công');
            return $this->redirect(Yii::$app->request->getReferrer());
        }
        return $this->redirect(Yii::$app->request->getReferrer());
    }
}