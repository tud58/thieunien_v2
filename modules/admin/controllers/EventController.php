<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\models\Event;
use app\helper\Functions;
use app\models\Log;
use app\modules\user\models\User;


class EventController extends BaseController
{

    public function actionIndex(){

        $action = Yii::$app->request->get('action', '');
        
        $id = Yii::$app->request->get('id', 0);
        if($action == 'delete'){
            if(!in_array($this->getUser()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])){
                return $this->render('../default/permission_denied');
            }             
            if($id > 0){
                $event = Event::findOne($id);
                if($event){
                    $logData = [
                        'action_id' => 803,
                        'reference_id' => $id,
                        'reference_name' => $event->name,
                        'reference_type' => 'event',

                    ];
                    Log::saveLog($logData);
                    
                    $event->delete();
                }
                Yii::$app->session->addFlash('success', 'Xóa thành công');       
                return $this->redirect('/admin/event');
            }
        }
        
        
        $request = Yii::$app->request;
        $page = $request->get('page', 1);
        if($page <= 0){
            $page = 1;
        }
        
        $searchData = [];

        $searchData['id'] = $request->get('id', '');
        $searchData['keyword'] = $request->get('keyword', '');

        $where = [];
        $andWhere = [];

        if($searchData['id'] > 0){
            $where['id'] = $searchData['id'];
        }
        if($searchData['keyword'] != ''){
            $andWhere = ['LIKE', 'name', $searchData['keyword']];
        }


        $event_list = Event::find()->where($where)->andWhere($andWhere)->limit(ADMIN_ROW_PER_PAGE)->offset(($page - 1) * ADMIN_ROW_PER_PAGE)->orderBy(['update_time' => SORT_DESC])->all();
        $count_items = Event::find()->where($where)->andWhere($andWhere)->count();
        
		$page_count = ceil($count_items/ADMIN_ROW_PER_PAGE);


        return $this->render('index', [

            'event_list' => $event_list,
            'page' => $page,
            'count_items' => $count_items,
            'page_count' => $page_count,
            'pageUrl' => '/admin/event?'.Functions::searchCondToQuery($searchData),
            'searchData' => $searchData,       
        ]);
    }
    public function actionAdd(){
        if(!in_array($this->getUser()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])){
            return $this->render('../default/permission_denied');
        }
              
        $isCreate = false;
        if(Yii::$app->request->get('id', 0) > 0){
            $model = Event::findOne(Yii::$app->request->get('id', 0));
            if(!$model){
                throw new \yii\web\HttpException(404, "Liên kết không tồn tại");
            }
       
        }else{
            $model = new Event;
            $isCreate = true;
        }
        
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $model->load($post);
            if($isCreate){

                $model->create_time = time();        
            }
            $model->slug = Functions::toslug($model->name);
            if($model->save()){
                
                $logData = [
                    'action_id' => $isCreate?801:802,
                    'reference_id' => $model->getPrimaryKey(),
                    'reference_name' => $model->name,
                    'reference_type' => 'event',

                ];
                Log::saveLog($logData);
                        
                Yii::$app->session->addFlash('success', 'Lưu thành công');
                return $this->redirect('/admin/event');            
            }

        }  
        return $this->render('add', [
            'model' => $model,
        ]);    
    }
}