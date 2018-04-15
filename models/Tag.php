<?php

namespace app\models;

use Yii;
use app\helper\Functions;

class Tag extends BaseModel
{
    public static function tableName()
    {
        return static::getDb()->tablePrefix . "tag";
    }
    public function rules(){
        return [
            [['name'], 'required'],
            [['name'], 'string'],
            [['show_home'], 'number'],
        ];
    } 
    public function attributeLabels()
    {
        return [

            "name" => "Từ khóa",
            "show_home" => "Hiển thị tại trang chủ",

        ];
    }
	public static function insertTag($str){
		$tag = new Tag;
		$slug = Functions::toSlug($str);
		if(Tag::findOne(['slug' => $slug])){
			return false;
		}
		$tag->user_id = Yii::$app->user->id;
		$tag->create_time = time();
		$tag->name = $str;
		$tag->slug = $slug;
		if($tag->save()){
			$logData = [
				'action_id' => 301,
				'reference_id' => $tag->getPrimaryKey(),
				'reference_name' => $tag->name,
				'reference_type' => 'tag',

			];
			Log::saveLog($logData);		
			return $tag->getPrimaryKey();
		}
		return false;
	}
}