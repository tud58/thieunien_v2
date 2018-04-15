<?php
namespace app\controllers;
/**
 * Created by PhpStorm.
 * User: dunghoang
 * Date: 03/06/2017
 * Time: 21:42
 */

use Yii;
use app\models\News;
use app\models\Category;
use app\models\NewsCategory;
use yii\web\Controller;

class ApiController extends Controller
{
    public function actionIndex()
    {
        $categories = Category::find()->where('status = '.STATUS_ACTIVE.' AND show_home > 0')->orderBy(['show_home' => SORT_ASC])->all()->toArray();
        foreach ($categories as $c){
            echo $c['id'];
        }
        die;
    }
}