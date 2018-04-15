<?php

namespace app\models;

use Yii;

class Comment extends BaseModel
{
    public static function tableName()
    {
        return static::getDb()->tablePrefix . "comment";
    }
    public function rules(){
        return [
            [['user_id', 'user_name', 'email', 'message'], 'required'],
            [['email'], 'email'],
            [['user_name'], 'string'],
        ];
    } 
    public function attributeLabels()
    {
        return [

            "user_name" => "Họ tên",
            "email" => "Email",
            "message" => "Nội dung",

        ];
    }
    public function beforeSave($insert)
    {                                                           
        $this->news_owner_id = News::findOne($this->news_id)->user_id;
        return parent::beforeSave($insert);
    }
}