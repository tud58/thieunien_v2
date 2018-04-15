<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;

use app\models\Log;
use app\helper\Functions;


class LogController extends BaseController
{

    public function actionIndex(){
        $this->view->title = "Nhật ký hệ thống";

        $request = Yii::$app->request;
        $page = $request->get('page', 1);
        if($page <= 0){
            $page = 1;
        }
        $searchData = [];

        $searchData['user_id'] = $request->get('user_id', '');
        $searchData['reference_type'] = $request->get('reference_type', '');
        $searchData['reference_id'] = $request->get('reference_id', '');
        $searchData['action_id'] = $request->get('action_id', '');

        $where = [];
                                 //  var_dump($this->getUser());
        if(!in_array($this->getUser()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])){
            $searchData['user_id'] = $this->getUser()->id;
        }

        if($searchData['user_id'] > 0){
            $where['user_id'] = $searchData['user_id'];
        }
        if($searchData['reference_id'] > 0){
            $where['reference_id'] = $searchData['reference_id'];
        }
        if($searchData['action_id'] > 0){
            $where['action_id'] = $searchData['action_id'];
        }
        if($searchData['reference_type'] != ''){
            $where['reference_type'] = $searchData['reference_type'];
        }


        $logList = Log::find()->where($where)->limit(ADMIN_ROW_PER_PAGE)->offset(($page - 1) * ADMIN_ROW_PER_PAGE)->orderBy(['id' => SORT_DESC])->all();
        $count_items = Log::find()->where($where)->count();  
		$page_count = ceil($count_items/ADMIN_ROW_PER_PAGE);

        return $this->render("index", [
            'logList' => $logList,
            'page' => $page,
            'count_items' => $count_items,
            'page_count' => $page_count,
            'pageUrl' => '/admin/log?'.Functions::searchCondToQuery($searchData),
            'searchData' => $searchData,

        ]);
    }



    

}