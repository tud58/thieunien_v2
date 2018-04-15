<?php

namespace app\models;

use Yii;

class Subject extends BaseModel
{
    public $begin_time_temp;
    public $end_time_temp;
    
    public static function tableName()
    {
        return static::getDb()->tablePrefix . "subject";
    }
    public function rules(){
        return [
            [['name'], 'required'],
            [['name', 'description'], 'string'],
            [['begin_time_temp', 'end_time_temp'], 'checkTime'],
            [['status'], 'number'],
            [['name'], 'string', 'max' => 255],
        ];
    } 
    public function attributeLabels()
    {
        return [

            "name" => "Tên chủ đề",
            "description" => "Ghi chú",
            "begin_time_temp" => "Ngày bắt đầu",
            "end_time_temp" => "Ngày kết thúc",
            "status" => "Trạng thái",
        ];
    }
    public function checkTime(){
        
        if(!empty($this->begin_time_temp)){
            if(strtotime($this->begin_time_temp)){
                $this->begin_time = strtotime($this->begin_time_temp);
            }else{
                $this->addError("begin_time_temp", "Sai định dạng");  
            }   
        }
        if(!empty($this->end_time_temp)){
            if(strtotime($this->end_time_temp)){
                $this->end_time = strtotime($this->end_time_temp);
            }else{
                $this->addError("end_time_temp", "Sai định dạng");  
            }   
        }
    }  
    public function beforeSave($insert)
    {
        $this->update_time = time();
        return parent::beforeSave($insert);
    }
}