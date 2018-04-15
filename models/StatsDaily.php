<?php

namespace app\models;

use Yii;
use yii\db\Query;


class StatsDaily extends BaseModel
{
    public static function tableName()
    {
        return static::getDb()->tablePrefix . "stats_daily";
    }
    public static function getData($seach, $order_by = 'view_count', $from_time, $to_time, $offset = 0,  $limit = SEARCH_ROW_PER_PAGE){
                 
        $query = new Query;
        $query->select(['stats_daily.news_id, sum(stats_daily.view_count) as sum_view_count, news.title, news.view_count, news.publish_time, news.create_time'])->from('stats_daily');   
        $query->join('INNER JOIN', 'news', 'news.id = stats_daily.news_id');                   

		if(isset($seach['category_id']) && $seach['category_id'] > 0){
			$query->join('INNER JOIN', 'news_category', 'news.id = news_category.news_id');
			$query->andWhere(['=', 'news_category.category_id', $seach['category_id']]);			
		}

        $query->andWhere(['>=', 'date_timestamp', $from_time]);                        
        $query->andWhere(['<', 'date_timestamp', $to_time]);  
        $query = $query->andWhere(['!=', 'news.status', STATUS_DELETED])->groupBy('news_id');
		
        $count =  $query->count();
		//echo $count;exit;
        $query->limit($limit)->offset($offset)->orderBy(['sum_' . $order_by => SORT_DESC]);

        $command = $query->createCommand();
        $raw_data = $command->queryAll(\PDO::FETCH_OBJ);     

//        if(count($raw_data) == 0){
//            return [];
//        }
        

        $stats = [];
        foreach($raw_data as $s){
            //$s->news = isset($news_objects[$s->news_id])?$news_objects[$s->news_id]:false;
            $stats[] = $s;
        }
        //var_dump($stats);exit;
        return ['data' => $stats, 'count' => $count];
    }

    public static function getDataExport($seach, $order_by = 'view_count', $from_time, $to_time, $offset = 0,  $limit = SEARCH_ROW_PER_PAGE){

        $query = new Query;
        $query->select(['stats_daily.news_id, sum(stats_daily.view_count) as sum_view_count, news.title, news.view_count, news.publish_time, news.create_time'])->from('stats_daily');
        $query->join('INNER JOIN', 'news', 'news.id = stats_daily.news_id');

        if(isset($seach['category_id']) && $seach['category_id'] > 0){
            $query->join('INNER JOIN', 'news_category', 'news.id = news_category.news_id');
            $query->andWhere(['=', 'news_category.category_id', $seach['category_id']]);
        }

        $query->andWhere(['>=', 'date_timestamp', $from_time]);
        $query->andWhere(['<', 'date_timestamp', $to_time]);
        $query->andWhere(['>', 'stats_daily.view_count', 0]);
        $query = $query->andWhere(['=', 'news.status', NEWS_STATUS_PUBLISHED])->groupBy('news_id');

        $count =  $query->count();
        //echo $count;exit;
        $query->limit($limit)->offset($offset)->orderBy(['sum_' . $order_by => SORT_DESC]);

        $command = $query->createCommand();
        $raw_data = $command->queryAll(\PDO::FETCH_OBJ);

        $stats = [];
        foreach($raw_data as $s){
            //$s->news = isset($news_objects[$s->news_id])?$news_objects[$s->news_id]:false;
            $stats[] = $s;
        }
        //var_dump($stats);exit;
        return ['data' => $stats, 'count' => $count];
    }
}