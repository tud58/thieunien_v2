<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\models\Category;
use app\models\NewsCategory;
use app\helper\Functions;
use app\models\Log;
use yii\web\Response;
use yii\widgets\ActiveForm;

class CategoryController extends BaseController
{

    public function actionIndex(){


         
        $action = Yii::$app->request->get('action', '');
        
        $id = Yii::$app->request->get('id', 0);
        if($action == 'delete'){
            if(!in_array($this->getUser()->role_id, [ROLE_ADMIN])){
                return $this->render('../default/permission_denied');
            }        
            if($id > 0){
                $c = Category::findOne($id);
                if($c){
                    $chidl_ids = Category::getChildIds($id);
                    //xóa new_category chuyên mục con
                    NewsCategory::deleteAll(['category_id' => $chidl_ids]);
                    
                    //xóa new_category chuyên mục cha
                    NewsCategory::deleteAll(['category_id' => $id]);
                    
                    //xóa chuyên mục con                      
                    $child_category_list = Category::find()->where(['id' => $chidl_ids])->all();
                    foreach($child_category_list as $child){
                        $logData = [
                            'action_id' => 203,
                            'reference_id' => $child->id,
                            'reference_name' => $child->name,
                            'reference_type' => 'category',

                        ];
                        Log::saveLog($logData);           
                    }

                    $logData = [
                        'action_id' => 203,
                        'reference_id' => $id,
                        'reference_name' => $c->name,
                        'reference_type' => 'category',

                    ];
                    Log::saveLog($logData);
                    
                    $c->delete();
                }
                Yii::$app->session->addFlash('success', 'Xoá thành công');
                return $this->redirect('/admin/category');
            }
        }


        $categories = Category::getCategories([STATUS_ACTIVE, STATUS_INACTIVE]);


        return $this->render('index', [
            'categories' => $categories,

        ]);

    }
    public function actionAdd(){
         
        if(!in_array($this->getUser()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])){
            return $this->render('../default/permission_denied');
        }
        
        $isCreate = false;
        if(Yii::$app->request->get('id', 0) > 0){
            $model = Category::findOne(Yii::$app->request->get('id', 0));
            if(!$model){
                throw new \yii\web\HttpException(404, "Liên kết không tồn tại");
            }
        }else{
            $model = new Category;
            $model->number_order = 0;
            $model->show_home_limit = 10;
            $isCreate = true;
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            

            $model->load($post);
            $model->slug = Functions::toSlug($model->name);
            $model->parent_id = (int)$model->parent_id;
            if($model->save()){
                
                $logData = [
                    'action_id' => $isCreate?201:202,
                    'reference_id' => $model->getPrimaryKey(),
                    'reference_name' => $model->name,
                    'reference_type' => 'category',

                ];
                Log::saveLog($logData);
                
                Yii::$app->session->addFlash('success', 'Lưu thành công');
                return $this->redirect('/admin/category');            
            }

        }

        $edit_parent_id = (int)Yii::$app->request->get('edit_parent_id', 0);  
        $categoriesTreelevel1 = Category::getCategoryTree(1);
        return $this->render('add', [
            'model' => $model,
            'edit_parent_id' => $edit_parent_id,
            'categoriesTreelevel1' => $categoriesTreelevel1,
        ]);
    }
}