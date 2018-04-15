<?php

namespace app\models;

use Yii;
use pendalf89\filemanager\behaviors\MediafileBehavior;
use yii\db\Query;

class NewsLiveContent extends BaseModel
{

    
    public static function tableName()
    {
        return static::getDb()->tablePrefix . "news_live_content";
    }

    public function rules(){
        return [
            [['title', 'content'], 'required'],

        ];
    }

    public function attributeLabels()
    {
        return [
            "title" => "Tiêu đề",
            "content" => "Nội dung",
        ];
    }

    

}