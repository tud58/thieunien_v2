<?php

namespace app\models;

use Yii;

class Event extends BaseModel
{
    public static function tableName()
    {
        return static::getDb()->tablePrefix . "event";
    }
    public function rules(){
        return [
            [['name'], 'required'],

            [['description', 'slug', 'logo'], 'string'],
            [['status'], 'number'],
            [['name'], 'string', 'max' => 255],
        ];
    } 
    public function attributeLabels()
    {
        return [
            'name' => 'Tên',
            'description' => 'Nội dung',


        ];
    }
    public function beforeSave($insert)
    {
        $this->update_time = time();
        return parent::beforeSave($insert);
    }
}