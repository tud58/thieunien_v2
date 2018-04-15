<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\models\Comment;
use app\models\News;

use app\helper\Functions;
use app\models\Log;

class CommentController extends BaseController
{
    public function actionIndex(){
        $this->view->title = "Quản lý bình luận";

        $request = Yii::$app->request;
        $page = $request->get('page', 1);
        if($page <= 0){
            $page = 1;
        }
        $searchData = [];
        $searchData['id'] = $request->get('id', '');
        $searchData['status'] = $request->get('status', '');
        $searchData['news_id'] = $request->get('news_id', '');
        $searchData['reply_to'] = $request->get('reply_to', '');
        $searchData['user_id'] = $request->get('user_id', '');
        $searchData['news_owner_id'] = $request->get('news_owner_id', '');

        $where = [];
        $params = [];

        if($searchData['status'] != ''){
            $where['status'] = $searchData['status'];
        }

        if($searchData['id'] > 0){
            $where['id'] = $searchData['id'];
        }
        if($searchData['news_id'] > 0){
            $where['news_id'] = $searchData['news_id'];
        }
        if($searchData['news_owner_id'] > 0){
            $where['news_owner_id'] = $searchData['news_owner_id'];
        }
/*        if($searchData['news_id'] > 0){
            $where['reply_to'] = $searchData['reply_to'];
        }*/ 
        
        if(!in_array($this->getUser()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])){
            $where['news_owner_id'] = $this->getUser()->id;
        }       

        $commentList = Comment::find()->where($where)->addParams($params)->limit(ADMIN_ROW_PER_PAGE)->offset(ADMIN_ROW_PER_PAGE * ($page - 1))->orderBy(['id' => SORT_DESC])->all();
        $count_items = Comment::find()->where($where)->addParams($params)->count();
		$page_count = ceil($count_items/ADMIN_ROW_PER_PAGE);
		
        return $this->render("index", [
            'commentList' => $commentList,
            'page' => $page,
            'count_items' => $count_items,
            'page_count' => $page_count,
            'pageUrl' => '/admin/comment?'.Functions::searchCondToQuery($searchData),
            'searchData' => $searchData,
        ]);
    }
    public function actionEdit_status(){
        $id = Yii::$app->request->get('id', 0);
        $status = Yii::$app->request->get('status', 0);
        $comment = Comment::findOne($id);
        
        if(!$comment || !in_array($status, [STATUS_ACTIVE, STATUS_DELETED, STATUS_INACTIVE])){
            throw new \yii\web\HttpException(404, "Liên kết không tồn tại");
        }

        //check admin

        if($status == STATUS_DELETED){
            Comment::deleteAll('reply_to = ' .$id);
            
            $logData = [
                'action_id' => 603,
                'reference_id' => $comment->id,
                'reference_name' => $comment->message,
                'reference_type' => 'comment',
            ];
            Log::saveLog($logData); 
            
            if($comment->delete()){
                News::updateCommentCount($comment->news_id);
                Yii::$app->session->addFlash('success', 'Xóa bình luận thành công');
                return $this->redirect(Yii::$app->request->getReferrer());   
            }else{
                Yii::$app->session->addFlash('error', 'Có lỗi xảy ra');
                return $this->redirect(Yii::$app->request->getReferrer());    
            }         
        }else{
            $comment->status = $status;
            if($comment->save()){
                News::updateCommentCount($comment->news_id);
                
                $logData = [
                    'action_id' => $comment->status==STATUS_ACTIVE?601:602,
                    'reference_id' => $comment->id,
                    'reference_name' => $comment->message,
                    'reference_type' => 'comment',
                ];
                Log::saveLog($logData);     
                
                Yii::$app->session->addFlash('success', 'Cập nhật trạng thái thành công');
                return $this->redirect(Yii::$app->request->getReferrer());   
            }else{                                    
                Yii::$app->session->addFlash('error', 'Có lỗi xảy ra');
                return $this->redirect(Yii::$app->request->getReferrer());    
            }      
        }
        
   
    }
}