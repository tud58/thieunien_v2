<?php

namespace app\models;
use Yii;

class HomeLayout extends BaseModel
{

    public $module;
    public static function tableName()
    {
        return static::getDb()->tablePrefix . "home_layout";
    }
    public function rules(){
        return [
            [['type'], 'required'],
            [['width', 'category_id', 'block_id', 'ads_id', 'number_order', 'parent_id'], 'number'],
            [['html'], 'string'],
			[['width'], 'default', 'value'=> 0],
			[['number_order'], 'default', 'value'=> 0],
        ];
    }

}