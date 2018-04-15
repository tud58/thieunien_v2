<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\models\Subject;
use app\models\UserSubject;
use app\helper\Functions;
use app\models\Log;
use app\modules\user\models\User;


class SubjectController extends BaseController
{

    public function actionIndex(){

        $action = Yii::$app->request->get('action', '');
        
        $id = Yii::$app->request->get('id', 0);
        if($action == 'delete'){
            if($id > 0){
                $subject = Subject::findOne($id);
                if($subject){
                    UserSubject::deleteAll('subject_id = ' .$id);
                    
                    $logData = [
                        'action_id' => 503,
                        'reference_id' => $id,
                        'reference_name' => $subject->name,
                        'reference_type' => 'subject',

                    ];
                    Log::saveLog($logData);
                    
                      
                    $subject->delete();
                }
                Yii::$app->session->addFlash('success', 'Xóa thành công');       
                return $this->redirect('/admin/subject');
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


        $subject_list = Subject::find()->where($where)->andWhere($andWhere)->limit(ADMIN_ROW_PER_PAGE)->offset(($page - 1) * ADMIN_ROW_PER_PAGE)->orderBy(['update_time' => SORT_DESC])->all();
        $count_items = Subject::find()->where($where)->andWhere($andWhere)->count();
        
		$page_count = ceil($count_items/ADMIN_ROW_PER_PAGE);

        
        $subjectIds = [];
        
        foreach($subject_list as $s){
            $subjectIds[] = $s->id;
        }
        
        $userSubjectData = UserSubject::find()->where(['subject_id' => $subjectIds])->all();
        $userSubject = [];
        foreach($userSubjectData as $us){        
            $userSubject[$us->subject_id][] = $us;
        } 
        
        

        return $this->render('index', [

            'subject_list' => $subject_list,
            'userSubject' => $userSubject,
            'page' => $page,
            'count_items' => $count_items,
            'page_count' => $page_count,
            'pageUrl' => '/admin/subject?'.Functions::searchCondToQuery($searchData),
            'searchData' => $searchData,       
        ]);
    }
    public function actionAdd(){
        if(!in_array($this->getUser()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])){
            return $this->render('../default/permission_denied');
        }
         
        $isCreate = false;
        if(Yii::$app->request->get('id', 0) > 0){
            $model = Subject::findOne(Yii::$app->request->get('id', 0));
            if(!$model){
                throw new \yii\web\HttpException(404, "Liên kết không tồn tại");
            }
       
        }else{
            $model = new Subject;
            $isCreate = true;
        }
        
        if($model->begin_time > 0){
            $model->begin_time_temp = date('d-m-Y', $model->begin_time);
        }else{
            $model->begin_time_temp = '';
        }
        if($model->end_time > 0){
            $model->end_time_temp = date('d-m-Y', $model->end_time);
        }else{
            $model->end_time_temp = '';
        }
        
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $model->load($post);
            if($isCreate){
                $model->user_id = $this->getUser()->id;
                $model->create_time = time();        
            }

            if($model->save()){
                
                $logData = [
                    'action_id' => $isCreate?501:502,
                    'reference_id' => $model->getPrimaryKey(),
                    'reference_name' => $model->name,
                    'reference_type' => 'subject',

                ];
                Log::saveLog($logData);
                        
                Yii::$app->session->addFlash('success', 'Lưu thành công');
                return $this->redirect('/admin/subject');            
            }

        }  
        return $this->render('add', [
            'model' => $model,
        ]);    
    }
    public function actionRequest(){
        $subject_id = Yii::$app->request->get('subject_id', 0);
        $subject = Subject::findOne($subject_id);
        
        if(!$subject || $subject->status != STATUS_ACTIVE){
            throw new \yii\web\HttpException(404, "Liên kết không tồn tại");    
        }

        $userSubject = UserSubject::findOne(['user_id' => $this->getUser()->id, 'subject_id' => $subject_id]);
        
        if($userSubject){
            throw new \yii\web\HttpException(403, 'You are not allowed to perform this action.');  
        }
        $userSubject = new UserSubject;
        $userSubject->subject_id = $subject_id;
        $userSubject->user_id = $this->getUser()->id;
        $userSubject->user_full_name = $this->getProfile()->full_name;
        $userSubject->create_time = time();
        if($userSubject->save()){
            
            $logData = [
                'action_id' => 504,
                'reference_id' => $subject->id,
                'reference_name' => $subject->name,
                'reference_type' => 'subject',

            ];
            Log::saveLog($logData);
            
            Yii::$app->session->addFlash('success', 'Yêu cầu nhận chủ đề thành công');
            return $this->redirect(Yii::$app->request->getReferrer());   
        }else{
            Yii::$app->session->addFlash('error', 'Có lỗi xảy ra');
            return $this->redirect(Yii::$app->request->getReferrer());    
        }    
    }
    public function actionAccept_request(){
        $id = Yii::$app->request->get('id', 0);
        $userSubject = UserSubject::findOne($id);
        
        if(!$userSubject || $userSubject->status == STATUS_ACTIVE){
            Yii::$app->session->addFlash('error', 'Người nhận đã được giao chủ đề này');
            return $this->redirect(Yii::$app->request->getReferrer());
        }

        $subject = Subject::findOne($userSubject->subject_id);
        if(!$subject){
            Yii::$app->session->addFlash('error', 'Không tìm thấy chủ đề');
            return $this->redirect(Yii::$app->request->getReferrer());    
        }
        
        $userSubject->status = STATUS_ACTIVE;
            
        if($userSubject->save()){
           
            $user = User::findOne($userSubject->user_id);
            $userProfile = $user->profile;
            
            $logData = [
                'action_id' => 505,
                'reference_id' => $subject->id,
                'reference_name' => $subject->name,
                'reference_type' => 'subject',
                'note' => 'Người yêu cầu: ' . $userProfile->full_name,

            ];
            Log::saveLog($logData);
            
            
            Yii::$app->session->addFlash('success', 'Chấp nhận yêu cầu thành công');
            return $this->redirect(Yii::$app->request->getReferrer());   
        }else{
            Yii::$app->session->addFlash('error', 'Có lỗi xảy ra');
            return $this->redirect(Yii::$app->request->getReferrer());    
        }    
    }
    public function actionReject_request(){
        $id = Yii::$app->request->get('id', 0);
        $userSubject = UserSubject::findOne($id);
        
        if(!$userSubject || $userSubject->status == STATUS_DELETED){
            Yii::$app->session->addFlash('error', 'Người nhận đã bị từ chôi giao chủ đề này');
            return $this->redirect(Yii::$app->request->getReferrer());
        }
        $subject = Subject::findOne($userSubject->subject_id);
        if(!$subject){
            Yii::$app->session->addFlash('error', 'Không tìm thấy chủ đề');
            return $this->redirect(Yii::$app->request->getReferrer());    
        }
        
        
        $userSubject->status = STATUS_DELETED;
        if($userSubject->save()){
            
            $user = User::findOne($userSubject->user_id);
            $userProfile = $user->profile;
              
            $logData = [
                'action_id' => 506,
                'reference_id' => $subject->id,
                'reference_name' => $subject->name,
                'reference_type' => 'subject',
                'note' => 'Người yêu cầu: ' . $userProfile->full_name,

            ];
            Log::saveLog($logData);
            
            Yii::$app->session->addFlash('success', 'Từ chối yêu cầu thành công');
            return $this->redirect(Yii::$app->request->getReferrer());   
        }else{
            Yii::$app->session->addFlash('error', 'Có lỗi xảy ra');
            return $this->redirect(Yii::$app->request->getReferrer());    
        }    
    }
    public function actionCancel_request(){
        $subject_id = Yii::$app->request->get('subject_id', 0);
        $userSubject = UserSubject::findOne(['subject_id' => $subject_id, 'user_id' => $this->getUser()->id]);
                                                 
        if(!$userSubject){
            throw new \yii\web\HttpException(403, 'You are not allowed to perform this action.'); 
        }
        $subject = Subject::findOne($userSubject->subject_id);
        if(!$subject){
            Yii::$app->session->addFlash('error', 'Không tìm thấy chủ đề');
            return $this->redirect(Yii::$app->request->getReferrer());    
        }
        
        $logData = [
            'action_id' => 507,
            'reference_id' => $subject->id,
            'reference_name' => $subject->name,
            'reference_type' => 'subject',
        ];
        Log::saveLog($logData);
        
        if($userSubject->delete()){
            Yii::$app->session->addFlash('success', 'Bỏ chủ đề thành công');
            return $this->redirect(Yii::$app->request->getReferrer());   
        }else{
            Yii::$app->session->addFlash('error', 'Có lỗi xảy ra');
            return $this->redirect(Yii::$app->request->getReferrer());    
        }    
    }
}