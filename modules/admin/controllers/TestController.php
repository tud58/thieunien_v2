<?php
namespace app\modules\admin\controllers;

use app\models\SiteConfig;
use Yii;

use app\models\News;

class TestController extends BaseController
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    public function actionIndex(){
        echo '@@@';exit;
		
		$newsList = News::find()->limit(20)->orderBy(['id' => SORT_DESC])->all();
		
		echo count($newsList);
		echo 'zz';
    }
}