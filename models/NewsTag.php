<?php

namespace app\models;

use Yii;
use yii\db\Query;

class NewsTag extends BaseModel
{
    public static function tableName()
    {
        return static::getDb()->tablePrefix . "news_tag";
    }

    public static function search($where, $offset = 0, $limit = 0, $order = ['news.publish_time' => SORT_DESC]){

        $query = new Query();
        $query->select([
            'news_tag.*',
            'news.title as title',
            'news.logo as logo',
            'news.description as description',
            'news.slug as slug',
            'news.id as id',
            'news.view_count as view_count',
            'news.comment_count as comment_count',
            'news.publish_time as publish_time',
            'news.type as type',
        ])->from('news_tag');

        if(isset($where['tag_id'])){
            $query->join('INNER JOIN',
                'news',
                'news_tag.news_id = news.id'
            );
            $query->andWhere(['IN', 'news_tag.tag_id', $where['tag_id']]);
            unset($where['tag_id']);
        }

        if(isset($where['not_news'])){
            $query->andWhere(['NOT IN', 'news_category.news_id', $where['not_news']]);
            unset($where['not_news']);
        }

        $query->andWhere($where);
        if ($limit)
            $query->limit($limit);
        $query->offset($offset)->orderBy($order);

        $command = $query->createCommand();
        $news = $command->queryAll(\PDO::FETCH_OBJ);

        return $news;
    }
    public static function searchTag($where, $offset = 0, $limit = 0, $group = ['news_tag.tag_id']){

        $query = new Query();
        $query->select([
            'news_tag.*',
            'tag.name as name',
            'tag.slug as slug',
        ])->from('news_tag');
        $query->join('INNER JOIN',
            'tag',
            'news_tag.tag_id = tag.id'
        );

        $query->andWhere($where);
        if ($limit)
            $query->limit($limit);
        $query->offset($offset)->groupBy($group);

        $command = $query->createCommand();
        $news = $command->queryAll(\PDO::FETCH_OBJ);

        return $news;
    }
}