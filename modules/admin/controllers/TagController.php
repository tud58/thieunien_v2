<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\models\Tag;
use app\models\NewsTag;
use app\helper\Functions;
use app\models\Log;
use yii\web\Response;

class TagController extends BaseController
{

    public function actionIndex()
    {

        $isCreate = false;
        if (Yii::$app->request->get('edit', 0) > 0) {
            $model = Tag::findOne(Yii::$app->request->get('edit', 0));
            if (!$model) {
                throw new \yii\web\HttpException(404, "Liên kết không tồn tại");
            }
        } else {
            $model = new Tag;
            $isCreate = true;
        }

        if (Yii::$app->request->isPost) {
            if (!in_array($this->getUser()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR, ROLE_EDITOR, ROLE_AUTHOR])) {
                return $this->render('../default/permission_denied');
            }
            $post = Yii::$app->request->post();

            $model->load($post);
            if ($isCreate) {
                $model->user_id = $this->getUser()->id;
                $model->create_time = time();
            }
            if ($model->show_home == STATUS_ACTIVE && !in_array($this->getUser()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])) {
                Yii::$app->session->addFlash('error', 'Bạn không có quyền tạo/sửa tag hiển thị trang chủ');
                return $this->redirect('/admin/tag');
            }

            $model->slug = Functions::toSlug($model->name);
            if (($t = Tag::findOne(['slug' => $model->slug])) && $t->id != $model->id) {

                Yii::$app->session->addFlash('error', 'Từ khóa này đã tồn tại');
                return $this->redirect('/admin/tag');
            }
            if ($model->save()) {

                $logData = [
                    'action_id' => $isCreate ? 301 : 302,
                    'reference_id' => $model->getPrimaryKey(),
                    'reference_name' => $model->name,
                    'reference_type' => 'tag',

                ];
                Log::saveLog($logData);

                Yii::$app->session->addFlash('success', 'Lưu thành công');
                return $this->redirect('/admin/tag');
            }

        }


        $action = Yii::$app->request->get('action', '');

        $id = Yii::$app->request->get('id', 0);
        if ($action == 'delete') {
            if (!in_array($this->getUser()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])) {
                return $this->render('../default/permission_denied');
            }
            if ($id > 0) {
                $tag = Tag::findOne($id);
                if ($tag) {
                    NewsTag::deleteAll('tag_id = ' . $id);

                    $logData = [
                        'action_id' => 303,
                        'reference_id' => $id,
                        'reference_name' => $tag->name,
                        'reference_type' => 'tag',

                    ];
                    Log::saveLog($logData);

                    $tag->delete();
                    Yii::$app->session->addFlash('success', 'Xóa thành công');
                }

                return $this->redirect('/admin/tag');
            }
        }

        $request = Yii::$app->request;
        $page = $request->get('page', 1);
        if ($page <= 0) {
            $page = 1;
        }
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


        $tag_list = Tag::find()->where($where)->andWhere($andWhere)->limit(ADMIN_ROW_PER_PAGE + 1)->offset(($page - 1) * ADMIN_ROW_PER_PAGE)->orderBy(['id' => SORT_DESC])->all();
        $count_items = Tag::find()->where($where)->andWhere($andWhere)->count();
        $page_count = ceil($count_items / ADMIN_ROW_PER_PAGE);


        return $this->render('index', [
            'model' => $model,
            'tag_list' => $tag_list,
            'page' => $page,
            'count_items' => $count_items,
            'page_count' => $page_count,
            'pageUrl' => '/admin/tag?' . Functions::searchCondToQuery($searchData),
            'searchData' => $searchData,
        ]);

    }

    public function actionSearch()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;
        $searchData['keyword'] = $request->get('keyword', '');


        $tag_list = Tag::find()->andWhere([
            'like', 'name', $searchData['keyword']
        ])->limit(20)->offset(0)->orderBy(['id' => SORT_DESC])->all();

        return $tag_list;
    }

    public function actionShortcut()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;
        $searchData['keyword'] = $request->get('keyword', '');
        $result = [];
        if ($searchData['keyword']) {
            $tag_list = Tag::find()->andWhere("BINARY name LIKE '%" . $searchData['keyword'] . "%'")
                ->limit(100)->offset(0)->orderBy(['id' => SORT_DESC])->all();

            foreach ($tag_list as $tag) {
                $result[] = [
                    'title' => $tag['name'],
                    'value' => '/tag/' . $tag['slug'],
                ];
            }
        }
        return $result;
    }
}