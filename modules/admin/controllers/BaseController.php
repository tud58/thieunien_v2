<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;


class BaseController extends Controller
{
    //public $layout = "admin";

    public function init(){
        
        if (!Yii::$app->user->id > 0) {
            //return $this->redirect('/user/login?ref=/admin');
            header('location: /user/login?ref=/admin');
            exit;
        }
        if (!in_array($this->getUser()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR, ROLE_EDITOR, ROLE_AUTHOR])) {
            throw new \yii\web\HttpException(403, 'Bạn không có quyền truy cập.');
        }
        $this->view->title = "CMS";           
    }
	
    public function getUser(){
        return Yii::$app->user->getIdentity();
    }
	public function getProfile(){
		return Yii::$app->user->identity->profile;
	}
}