<?php

namespace app\models;

use Yii;

class UserPost extends BaseModel
{
    public static function tableName()
    {
        return static::getDb()->tablePrefix . "user_post";
    }
    public function rules(){
        return [
            [['user_id', 'title', 'content'], 'required'],
            [['user_email'], 'email'],
            [['user_full_name', 'author_full_name'], 'string'],
            [['author_id'], 'number'],
        ];
    } 
    public function attributeLabels()
    {
        return [
            "title" => "Tiêu đề",
            "content" => "Nội dung",

        ];
    }
    public function beforeSave($insert)
    {                                                           
        $this->update_time = time();
        return parent::beforeSave($insert);
    }
}