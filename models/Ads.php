<?php

namespace app\models;

use Yii;

class Ads extends BaseModel
{
    public $htmls = [];
    public $images = [];

    public static function tableName()
    {
        return static::getDb()->tablePrefix . "ads";
    }
    public function rules(){
        return [
            [['position'], 'required'],
            [['url', 'image', 'html'], 'string'],
            [['status', 'type', 'show_type', 'time_swap', 'num_slide'], 'number'],
        ];
    } 
    public function attributeLabels()
    {
        return [
            "position" => "Vị trí",
            "url" => "Đường dẫn",
            "status" => "Trạng thái",
            "type" => "Loại quảng cáo",
            "show_type" => "Cách hiển thị",
            "time_swap" => "Thời gian chuyển slide (giây)",
            "num_slide" => "Số lượng hiển thị",
        ];
    }
    public function beforeSave($insert)
    {
        $this->update_time = time();
        return parent::beforeSave($insert);
    }
}