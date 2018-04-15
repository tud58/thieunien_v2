<?php

namespace app\models;

use Yii;

class SiteConfig extends BaseModel
{
    private static $configData = [];
    public static function tableName()
    {
        return static::getDb()->tablePrefix . "site_config";
    }
    public function rules(){
        return [
            [['config_value', 'config_key'], 'string'],
        ];
    }
    
    public static function getAll(){
        $data = SiteConfig::find()->all();
        $page_config = [];
        foreach($data as $config){
            $page_config[$config->config_key] = $config->config_value;
        }
        return $page_config;
    }
    public static function getByKey($key){
        SiteConfig::$configData = SiteConfig::find()->all();
        foreach(SiteConfig::$configData as $config){
            if($config->config_key == $key){
                return $config->config_value;
            } 
        }
        return false;
    }
}