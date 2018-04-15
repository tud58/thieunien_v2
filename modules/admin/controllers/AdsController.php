<?php
namespace app\modules\admin\controllers;

use app\helper\Functions;
use app\models\Ads;
use app\models\Log;

use Yii;


class AdsController extends BaseController
{

    public function actionIndex()
    {
        if (!in_array($this->getUser()->role_id, [ROLE_ADMIN])) {
            return $this->render('../default/permission_denied');
        }
        $this->view->title = "Quảng cáo";

        $request = Yii::$app->request;
        $action = Yii::$app->request->get('action', '');
        $id = Yii::$app->request->get('id', 0);
        if ($action == 'delete') {
            if ($id > 0) {
                $ads = Ads::findOne($id);
                if ($ads) {
                    $logData = [
                        'action_id' => 703,
                        'reference_id' => $id,
                        'reference_name' => 'Vị trí ' . $ads->position,
                        'reference_type' => 'ads',
                    ];
                    Log::saveLog($logData);

                    $ads->delete();
                }
                Yii::$app->session->addFlash('success', 'Xoá thành công');
                return $this->redirect('/admin/ads');
            }
        }

        $page = $request->get('page', 1);
        if ($page <= 0) {
            $page = 1;
        }
        $searchData = [];

        $searchData['id'] = $request->get('id', '');

        $where = [];


        if ($searchData['id'] > 0) {
            $where['id'] = $searchData['id'];
        }


        $adsList = Ads::find()->where($where)->limit(ADMIN_ROW_PER_PAGE + 1)->offset(($page - 1) * ADMIN_ROW_PER_PAGE)->orderBy(['position' => SORT_ASC])->all();
        $count_items = Ads::find()->where($where)->count();
        $page_count = ceil($count_items / ADMIN_ROW_PER_PAGE);


        return $this->render("index", [
            'adsList' => $adsList,
            'page' => $page,
            'count_items' => $count_items,
            'page_count' => $page_count,
            'pageUrl' => '/admin/ads?' . Functions::searchCondToQuery($searchData),
            'searchData' => $searchData,

        ]);
    }

    public function actionAdd()
    {
        if (!in_array($this->getUser()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])) {
            return $this->render('../default/permission_denied');
        }

        $isCreate = false;
        if (Yii::$app->request->get('id', 0) > 0) {
            $model = Ads::findOne(Yii::$app->request->get('id', 0));
            if (!$model) {
                throw new \yii\web\HttpException(404, "Liên kết không tồn tại");
            }
        } else {
            $model = new Ads;
            $isCreate = true;
        }


        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $model->load($post);
            if ($isCreate) {
                $model->create_time = time();
            }
            if ($model->show_type == ADS_SHOW_TYPE_SLIDE) {
                if (isset($post['htmls']))
                    $model->html = implode('(,)',$post['htmls']);
                if (isset($post['images']))
                    $model->image = implode('(,)',$post['images']);
            }
            if ($model->save()) {

                $logData = [
                    'action_id' => $isCreate ? 701 : 702,
                    'reference_id' => $model->getPrimaryKey(),
                    'reference_name' => 'Vị trí ' . $model->position,
                    'reference_type' => 'ads',
                ];
                Log::saveLog($logData);

                Yii::$app->session->addFlash('success', 'Lưu thành công');
                return $this->redirect('/admin/ads/add?id=' . $model->id);
            }

        }


        if ($model->html)
            $htmls = explode('(,)', $model->html);
        if ($model->image)
            $images = explode('(,)', $model->image);

        for ($i = 0; $i < intval($model->num_slide); $i++) {
            if (isset($htmls[$i]))
                $model->htmls[] = $htmls[$i];
            else
                $model->htmls[] = "";
        }
        for ($i = 0; $i < $model->num_slide; $i++) {
            if (isset($images[$i]))
                $model->images[] = $images[$i];
            else
                $model->images[] = "";
        }
        if ($model->show_type == ADS_SHOW_TYPE_SLIDE) {
            $model->html = "";
            $model->image = "";
        }

        return $this->render('add', [
            'model' => $model,
        ]);
    }
}