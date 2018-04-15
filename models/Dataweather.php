<?php

namespace app\models;

use Yii;
use app\helper\Functions;

class Dataweather extends BaseModel
{
    public static function tableName()
    {
        return static::getDb()->tablePrefix . "dataweather";
    }
    public function rules(){
        return [
            [['id_weather', 'data'], 'required'],
            [['data'], 'string'],
            [['id_weather'], 'string', 'max' => 255],
        ];
    } 
    public function attributeLabels()
    {
        return [
            "id_weather" => "id weather",
            "data" => "data",

        ];
    }
}