<?php
namespace app\controllers;
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 9/25/2016
 * Time: 8:57 PM
 */
use app\models\Ads;
use app\models\Comment;
use app\models\Event;
use app\models\News;
use app\models\Category;
use Yii;

use app\models\Tag;
use app\models\NewsTag;
use app\helper\Rss;

class RssController extends BaseController
{

    public function actionList(){
		
		header("Content-type: text/xml");
		
		$category_id = (int)Yii::$app->request->get('category_id', 0);
		
		$where = ['status' => NEWS_STATUS_PUBLISHED];
		if(!empty($category_id)){
			$where['category_id'] = $category_id; 
		}
		$newsList = News::find()->where($where)->limit(20)->orderBy(['id' => SORT_DESC])->all();
		
		$items = [];
		
		foreach($newsList as $news){
			
			//$news->content = str_replace('<img', 'Ảnh <img', $news->content);
			$news->content = preg_replace('/(\<img[^>]+)(style\=\"[^\"]+\")([^>]+)(>)/', '${1}${3}${4}', $news->content);
			//$news->content = preg_replace('/<p style=\"(.*?)\"><img(.*?)<\/p>/', '${2}', $news->content);
			//$news->content = preg_replace('/<p><img(.*?)<\/p>/', '${1}', $news->content);
			
			$news->content = str_replace('<p style="text-align: center;"><img', '<p><img', $news->content);	
			$news->content = preg_replace('%<p>(<img .*?/>)</p>%i', '$1', $news->content);

			$news->content = str_replace(']]>', '', $news->content);
			$news->content = str_replace('<![CDATA[', '', $news->content);
			$news->content = '<header>
			  <figure>
				<img src="' . $news->logo . '" />
				<figcaption>Header image description becomes visible when image has been tapped and expanded.</figcaption>
			  </figure>
			  

			  <h1> ' . strip_tags(html_entity_decode($news->title))  . '</h1>

			  </header>' . $news->content;
			 
			$news->content = $news->content . '<br /><a href="http://hoahoctro.vn"><b>Hoahoctro.vn</b></a><figure class="op-ad">
			  <iframe width="300" height="250" style="border:0; margin:0;" src="https://www.facebook.com/adnw_request?placement=682643075241320_733946226777671&adtype=banner300x250"></iframe>
			</figure>
			
			<figure class="op-tracker">
			  <iframe src="http://hoahoctro.vn/news/update-view-count?news_id='.$news->id.'">

			  </iframe>
			</figure>
			
			';
			
			$news->content = $news->content . "
			
				<figure class=\"op-tracker\">
					<iframe>
						<script>
						  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
						  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
						  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
						  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

						  ga('create', 'UA-52373313-2', 'auto');
						  ga('send', 'pageview');

						</script>
					</iframe>
				</figure>
			
			";

				
			$items[] = [
				'title' =>  htmlspecialchars(strip_tags(html_entity_decode($news->title))),
				'description' => htmlspecialchars(strip_tags(html_entity_decode($news->description))),
				'content' => $news->content,
				'author' => 'hoahoctro.vn',
				'url' => 'http://hoahoctro.vn/tin-tuc/' . $news->slug,
				'date' => date('r', $news->publish_time)
			];
		}
		
		$rss = new RSS;
		$rss->title = 'RSS Hoa Học Trò';
		$rss->url = 'http://hoahoctro.vn/rss';
		$rss->description = $rss->title;
		$rss->date = $items[0]['date'];
		$rss->items = $items;
		echo $rss->generate();
		exit;
    }
    public function actionIndex(){
		$categoryList = Category::getCategories(1);
		return $this->render('list', [
			'categoryList' => $categoryList,
		]);
	}
}
