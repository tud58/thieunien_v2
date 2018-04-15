<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\models\Page;
use app\helper\Functions;

class PageController extends BaseController
{

    public function actionIndex(){
        $this->view->title = "Quản lý trang";

        $request = Yii::$app->request;
        $page = $request->get('page', 1);
        if($page <= 0){
            $page = 1;
        }
        $searchData = [];
        $searchData['id'] = $request->get('id', '');
        $searchData['status'] = $request->get('status', '');

        $searchData['keyword'] = trim($request->get('keyword', ''));

        $where = [];
        $params = [];
        $keyword = [];
        if($searchData['status'] != ''){
            $where['status'] = $searchData['status'];
        }

        if($searchData['id'] > 0){
            $where['id'] = $searchData['id'];
        }
        if($searchData['keyword'] != ""){
            $keyword = ['LIKE', 'name', $searchData['keyword']];
            //$params[':keyword'] = $searchData['keyword'];
        }

        $pageList = Page::find()->where($where)->andWhere($keyword)->addParams($params)->limit(ADMIN_ROW_PER_PAGE + 1)->offset(ADMIN_ROW_PER_PAGE * ($page - 1))->orderBy(['update_time' => SORT_DESC])->all();



        return $this->render("index", [
            'pageList' => $pageList,

            'page' => $page,
            'pageUrl' => Functions::searchCondToQuery($searchData),
            'searchData' => $searchData,
        ]);
    }
    public function actionAdd(){
        $request = Yii::$app->request;
        $isCreate = false;
        if($request->get('id', 0) > 0){

            $model = Page::findOne($request->get('id', 0));
            if(!$model){
                throw new \yii\web\HttpException(404, "Liên kết không tồn tại");
            }
        }else{
            $isCreate = true;
            $model = new Page;
        }


        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                if($isCreate){
                    $model->status = STATUS_ACTIVE;
                    $model->create_time = time();
                }
                if($model->save()){
                    return $this->redirect('/admin/page');
                }
            }
        }
        return $this->render('add', [
            'model' => $model,
        ]);
    }
    public function actionEditstatus(){
        $ref = false;
        if(isset($_SERVER['HTTP_REFERER'])){
            $ref = $_SERVER['HTTP_REFERER'];
        }else{
            throw new \yii\web\HttpException(406 , 'Not Acceptable');
        }


        $id = Yii::$app->request->get('id', 0);
        $status = Yii::$app->request->get('status', '');
        if($id > 0 && $status != ''){
            $model = Page::findOne($id);
            if(!$model){
                throw new \yii\web\HttpException(406 , 'Not Acceptable');
            }
            $model->status = (int)$status;
            $model->module = 'admin';
            if($model->save()){
                $this->redirect($ref);
            }else{
                throw new \yii\web\HttpException(500 , 'Internal Server Error');
            }
        }
    }
}