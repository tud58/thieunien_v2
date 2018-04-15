<?php
namespace app\modules\admin\controllers;

use app\models\SiteConfig;
use Yii;
use app\models\HomeLayout;
use app\models\Category;

class SiteController extends BaseController
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    public function actionIndex(){
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            SiteConfig::deleteAll();
            foreach($post as $key => $val){
                if(array_key_exists($key , Yii::$app->params['header_config']) || array_key_exists($key , Yii::$app->params['footer_config'])){
                    if($val != ''){
                        $pageConfigModel = new SiteConfig;
                        $pageConfigModel->config_key = $key;
                        $pageConfigModel->config_value = $val;
                        $pageConfigModel->save();
                    }
                }
            }
            Yii::$app->session->addFlash('success', 'Lưu thành công');
        }
        return $this->render('index', [

        ]);
    }
    public function actionLayoutHome(){
		$request = Yii::$app->request;
		if($request->get('action', '') == 'delete'){
			$model = HomeLayout::findOne($request->get('delete_id', 0));
			$model->delete();
			Yii::$app->session->addFlash('success', 'Xóa thành công');
			return $this->redirect('/admin/site/layout-home');				
		}
		

		$layoutData = HomeLayout::find()->orderBy(['number_order' => SORT_DESC, 'id' => SORT_ASC])->all();
		
        return $this->render('layout-home', [
			'layoutData' => $layoutData,
        ]);
    }
    public function actionAddLayout(){
        $request = Yii::$app->request;
        $isCreate = false;
        $id = $request->get('id', 0);

        if($id > 0){
            $model = HomeLayout::findOne($id);
            if(!$model){
                throw new \yii\web\HttpException(404, "Liên kết không tồn tại");
            }

        }else{
            $isCreate = true;
            $model = new HomeLayout;
			$type = $request->get('type', 'row');
			$model->type = $type;
			$model->parent_id = (int)$request->get('parent_id', 0);
		}
		
        $categoryTree = Category::getCategoryTree(false, '--');
		if($request->isPost){


			$post = $request->post();
			$model->load($post);
            if($model->validate()){
				
                if($model->save()){
                    Yii::$app->session->addFlash('success', 'Lưu thành công');
                    return $this->redirect('/admin/site/layout-home');				
				}
			}				
		}
        return $this->render('add-layout', [
			'model' => $model,
			'categoryTree' => $categoryTree,
        ]);
    }
}