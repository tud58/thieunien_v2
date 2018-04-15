<?php

namespace app\models;
use Yii;

class Page extends BaseModel
{

    public $module;
    public static function tableName()
    {
        return static::getDb()->tablePrefix . "page";
    }
    public function rules(){
        return [
            [['name', 'content'], 'required'],
            [['name', 'content'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            "name" => "Tên trang",
            "content" => "Nội dung",
            "slug" => "Đường dẫn",
        ];
    }
    public function beforeSave($insert)
    {
        $this->update_time = time();
        return parent::beforeSave($insert);
    }
}