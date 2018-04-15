<?php
namespace app\helper;

use Yii;
use app\models\News;
use app\models\Tag;
use app\models\NewsTag;

class Solr{
    static $options = [
        'hostname' => SOLR_SERVER_HOSTNAME,   
        'port' => SOLR_SERVER_PORT,   
        'login'    => '',
        'password' => '',
        'path'     => 'solr/news', // <-- Add your collection here
    ];
    public static function searchNews($where, $offset = 0,  $limit = SEARCH_ROW_PER_PAGE){
        $client = new \SolrClient(self::$options);

        $query = new \SolrQuery();
        
        $queryString = '*:*';
        if(isset($where['keyword'])){
            $queryString = 'title:(' . str_replace(' ', ' AND ',\SolrUtils::escapeQueryChars($where['keyword'])) . ')';
        }
        //echo $queryString;
        
        $query->setQuery($queryString);
        $query->addFilterQuery('status:' . NEWS_STATUS_PUBLISHED);
        $query->addFilterQuery('publish_time:[0 TO ' . time().']');
        $query->addField('*');

        $query->setStart($offset);
        $query->setRows($limit);
        
        $query->addSortField ('create_time');
        $query_response = $client->query($query);
        $response = $query_response->getResponse();
        if($response->response->docs)
            return $response->response->docs;
        return [];
    }
    public static function updateNews($newsId){
        $client = new \SolrClient(self::$options);
        
         $doc = new \SolrInputDocument();

        $news = News::findOne($newsId);
        if(!$news){
            return false;
        }

        $newsTags = NewsTag::find()->where(['news_id' => $news->id])->all();
        $tagIds = [];
        foreach($newsTags as $k => $nt){
            $tagIds[] = $nt['tag_id'];
        }
        $tag = '';
        if($tagIds){
            $tags = Tag::find()->where(['id' => $tagIds])->limit(5)->all();
            $tagArray = [];
            foreach($tags as $t){
                $tagArray[] = $t->name;
            }
            $tag = implode(', ', $tagArray);
        }

        $doc->addField('id', $news->id);
        $doc->addField('title', $news->title);
        $doc->addField('category_id', $news->category_id);
        $doc->addField('event_id', $news->event_id);
        $doc->addField('subtitle', $news->subtitle);
        $doc->addField('slug', $news->slug);
        $doc->addField('logo', $news->logo);
        $doc->addField('cover', $news->cover);
        $doc->addField('description', $news->description);
        $doc->addField('content', html_entity_decode($news->content));
        $doc->addField('source', $news->source);
        $doc->addField('type', $news->type);
        $doc->addField('create_time', $news->create_time);
        $doc->addField('update_time', $news->update_time);
        $doc->addField('publish_time', $news->publish_time);
        $doc->addField('show_home', $news->show_home);
        $doc->addField('status', $news->status);

        $doc->addField('tag', $tag);

        $updateResponse = $client->addDocument($doc);

        // you will have to commit changes to be written if you didn't use $commitWithin
        $client->commit();

        return $updateResponse->getResponse();
    }
}