<?php

namespace app\models;

use Yii;

class Log extends BaseModel
{
    public static function tableName()
    {
        return static::getDb()->tablePrefix . "log";
    }
    public function rules(){
        return [

        ];
    } 
    public static function saveLog($logData){
        if(empty($logData['action_id']) || !isset(Yii::$app->params['actions'][$logData['action_id']])){
            throw new \yii\web\HttpException(500, 'SaveLog Error 1');
        }
        if(empty($logData['reference_type']) || !isset(Yii::$app->params['log_reference_type'][$logData['reference_type']])){
            throw new \yii\web\HttpException(500, 'SaveLog Error 2');
        }
                                                      
        $log = new Log;
        $log->action_id = $logData['action_id'];

        $log->user_id = Yii::$app->user->id;
        $log->username = Yii::$app->user->getIdentity()->username;
        $log->user_full_name = Yii::$app->user->identity->profile->full_name;        
 

        $log->reference_id = empty($logData['reference_id'])?'':$logData['reference_id'];
        $log->reference_type = empty($logData['reference_type'])?'':$logData['reference_type'];
        $log->reference_name = empty($logData['reference_name'])?'':$logData['reference_name'];
        if(isset($logData['note'])){
            $log->note = $logData['note'];
        }
        
        $log->data = empty($logData['data'])?'':$logData['data'];
        $log->data_before = empty($logData['data_before'])?'':$logData['data_before'];
        $log->data_after = empty($logData['data_after'])?'':$logData['data_after'];
        $log->ip = Yii::$app->request->userIP;
        $log->create_time = time();
        $log->save();
    }
}