<?php

namespace app\models;

use Yii;

class Category extends BaseModel
{
    public $level = 0;
    public $news = [];
    public $order_read = [];
    public $order_new = [];
    public $order_comment = [];
    public static function tableName()
    {
        return static::getDb()->tablePrefix . "category";
    }
    public function rules(){
        return [
            [['name'], 'required'],
            [['name'], 'unique'],
            [['description', 'logo', 'cover', 'icon'], 'string'],
            [['status', 'is_hot', 'show_home', 'show_menu', 'show_footer', 'number_order', 'parent_id', 'show_home_limit'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'checkWordCount'],
        ];
    }
    public function attributeLabels()
    {
        return [

            "name" => "Tên chuyên mục",
            "logo" => "Ảnh đại diện",
            "cover" => "Ảnh đại diện",
            "description" => "Giới thiệu",
            "status" => "Trạng thái",
            "is_hot" => "Sự kiện hot",
            "show_home" => "Hiển thị tại trang chủ",
            "show_home_limit" => "Số bài tại trang chủ",
            "show_menu" => "Hiển thị tại menu",
            "show_footer" => "Hiển thị tại chân trang",
            "number_order" => "Thứ tự sắp xếp",
            "parent_id" => "Chuyên mục cha",
        ];
    }
    public function checkWordCount(){
        if(count(explode(' ', trim($this->name))) > 5 || count(explode(' ', trim($this->name))) < 1){
             $this->addError("name", "Tên chuyên mục độ dài tối đa 5 từ, tối thiểu 1 từ ");
        }
    }
    public static function getCategoryTree($maxLevel = false, $child_prefix = '-- ', $status = [STATUS_ACTIVE]){
        $categories = self::getCategories($status); 
        $tree = [];
        foreach($categories as $category){
            if($maxLevel === false || $category->level <= $maxLevel){
                $prefix = '';
                for($i = 0; $i < $category->level; $i++){
                     $prefix.= $child_prefix;
                }
                $tree[$category->id] = $prefix . $category->name;
            }

        }
        return $tree;
    }
    public static function getCategories($status = [STATUS_ACTIVE]){
        $categories = Category::find()->where(['status' => $status])->orderBy(['number_order' => SORT_ASC])->all();

        $r = [];
        if(count($categories) > 0){
            foreach($categories as $c1){
                if($c1->parent_id == 0){
                    $c1->level = 0;
                    $r[] = $c1;
                    foreach($categories as $c2){
                        if($c2->parent_id == $c1->id){
                            $c2->level = 1;
                            $r[] = $c2;
                            foreach($categories as $c3){
                                if($c3->parent_id == $c2->id){
                                    $c3->level = 2;
                                    $r[] = $c3;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $r;
    }
    public static function getChildIds($category_id){
        $child_list = Category::find()->where(['parent_id' => $category_id])->all();
        $child_ids = []; 
        foreach($child_list as $c){
            $child_ids[] = $c->id;
        }
        if(count($child_ids) > 0){
            $child_ids = array_merge($child_ids, Category::getChildIds($child_ids)); 
        }
        return $child_ids;
    }
}