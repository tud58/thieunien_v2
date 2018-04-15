<?php

namespace app\models;

use Yii;
use app\helper\Functions;

class Keyweather extends BaseModel
{
    public static function tableName()
    {
        return static::getDb()->tablePrefix . "keyweather";
    }
    public function rules(){
        return [
            [['key_weather', 'limit_day', 'max_limit_day', 'limit_minute', 'max_limit_minute', 'type', 'status'], 'required'],
            [['limit_day', 'max_limit_day', 'limit_minute', 'max_limit_minute', 'type', 'status'], 'integer'],
            [['key_weather'], 'string', 'max' => 255],
        ];
    } 
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key_weather' => 'Key Weather',
            'limit_day' => 'Limit Day',
            'max_limit_day' => 'Max Limit Day',
            'limit_minute' => 'Limit Minute',
            'max_limit_minute' => 'Max Limit Minute',
            'type' => 'Type',
            'status' => 'Status',
        ];
    }
}