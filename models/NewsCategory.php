<?php

namespace app\models;

use Yii;
use yii\db\Query;

class NewsCategory extends BaseModel
{
    public $news;
    public static function tableName()
    {
        return static::getDb()->tablePrefix . "news_category";
    }

    public static function search($where, $offset = 0, $limit = 0, $order = ['news.publish_time' => SORT_DESC], $elseId = 0){

        $query = new Query();
        $query->select([
            'news.category_id as category_id',
            'news.title as title',
            'news.logo as logo',
            'news.description as description',
            'news.content as content',
            'news.user_full_name as user_full_name',
            'news.source as source',
            'news.slug as slug',
            'news.id as id',
            'news.view_count as view_count',
            'news.comment_count as comment_count',
            'news.publish_time as publish_time',
            'news.type as type',
        ])->from('news_category');

        if(isset($where['category_id'])){
            $query->join('INNER JOIN',
                'news',
                'news_category.news_id = news.id'
            );
            $query->andWhere(['IN', 'news_category.category_id', $where['category_id']]);
            unset($where['category_id']);
        }

        if(isset($where['not_news'])){
            $query->andWhere(['NOT IN', 'news_category.news_id', $where['not_news']]);
            unset($where['not_news']);
        }

        $query->andWhere($where);
        $query->distinct('news_category.news_id');
        $query->andWhere('news_category.news_id <> '. $elseId);
        $query->andWhere([
			'or',
			['=', 'news.active_time', 0],
			['<', 'news.active_time', time()],
		]);
		//$query->andWhere(['<', 'news.publish_time', time()]);
        if ($limit)
            $query->limit($limit);
        $query->offset($offset)->orderBy($order);

        $command = $query->createCommand();
        $news = $command->queryAll(\PDO::FETCH_OBJ);

        return $news;
    }
}