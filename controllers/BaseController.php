<?php
namespace app\controllers;

use app\helper\Functions;
use app\models\Category;
use app\models\NewsTag;
use app\models\SiteConfig;
use app\models\Tag;
use Yii;
use yii\web\Controller;


class BaseController extends Controller
{
    public function init(){
        if (Functions::isMobile()){
            $this->layout = 'mobile';
        }

        $cache = Yii::$app->cache;
        $categories = $cache->get('categories_header');
        //$categories = false;
        if ($categories === false) {
            $categories = Category::find()->where(['status' => [STATUS_ACTIVE]])->orderBy(['id' => SORT_DESC])->asArray()->all();

            $cache->set('categories_header', $categories, 60);
        }
        
        $tags = $cache->get('tag_header');
        if ($tags === false) {
            $tags = NewsTag::searchTag([
                'tag.show_home' => 1
            ],0,3);
            $cache->set('tag_header', $tags, 60);
        }
        $headerMenu = array();
        $extraMenu = array();
        $categoryChild = [];
        foreach ($categories as $k => $c){
            if ($c['parent_id'] >0) {
                $categoryChild[$c['parent_id']][] = $c;
            }
            if ($c['parent_id'] == 0){
                $categories[$k]['child'] = array();
                $c['child'] = array();

                foreach ($categories as $sub){
                    if ($sub['parent_id'] == $c['id']){
                        $categories[$k]['child'][] = $sub;
                        $c['child'][] = $sub;
                    }
                }
                if ($c['show_menu'] == 1){
                    if (!Functions::isIpad()){
                        $headerMenu[] = $c;
                    }else{
                        if (count($headerMenu) < 4)
                            $headerMenu[] = $c;
                        else
                            $extraMenu[] = $c;
                    }
                }else{
                    $extraMenu[] = $c;
                }
            }
        }
        $keyword = trim(Yii::$app->request->get('keyword', ''));
        usort($headerMenu, function($a, $b) {
            return $a['number_order'] - $b['number_order'];
        });
        $siteConfig = SiteConfig::getAll();
        Yii::$app->view->params['headerMenu'] = $headerMenu;
        Yii::$app->view->params['extraMenu'] = $extraMenu;
        Yii::$app->view->params['categories'] = $categories;
        Yii::$app->view->params['categoryChild'] = $categoryChild;
        Yii::$app->view->params['tags'] = $tags;
        Yii::$app->view->params['keyword'] = $keyword;
        Yii::$app->view->params['siteConfig'] = $siteConfig;
    }
	
    public function getUser(){
        return Yii::$app->user->getIdentity();
    }
	public function getProfile(){
		return Yii::$app->user->identity->profile;
	}
    public function render($view, $params = [])
    {
        if (Functions::isMobile()){
            $view = 'm_' . $view;
        }
//        var_dump($this->layout);die;
        $content = $this->getView()->render($view, $params, $this);
        return $this->renderContent($content);
    }
}