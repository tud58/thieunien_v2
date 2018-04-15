<?php
namespace app\modules\admin\controllers;

use yii\web\Controller;
use yii;

use app\models\Subject;
use app\models\News;
use app\models\UserSubject;
use app\helper\Solr;


class DefaultController extends BaseController
{
    public $layout = "admin";
    public function actions()
    {

        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }
	public function actionTest(){
/*  		$news_list = News::find()->all();
		foreach($news_list as $news){
			Solr::updateNews($news->id);
		}
		
		echo '@@'; */
		//Solr::searchNews([]);
		
	}
    public function actionIndex(){
	    
        $subject_list = Subject::find()->where(['status' => STATUS_ACTIVE])->orderBy(['id' => SORT_DESC])->all();
           
        $subjectIds = [];
        
        foreach($subject_list as $s){
            $subjectIds[] = $s->id;
        }
        
        $userSubjectData = UserSubject::find()->where(['subject_id' => $subjectIds])->all();
        $userSubject = [];
        foreach($userSubjectData as $us){        
            $userSubject[$us->subject_id][] = $us;
        }                 

        return $this->render("index", [
            'userSubject' => $userSubject,
            'subject_list' => $subject_list,
        ]);
    }
    public function actionPermission_denied(){
        return $this->render('permission_denied');
    }
}