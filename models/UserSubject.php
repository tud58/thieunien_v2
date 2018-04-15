<?php

namespace app\models;

use Yii;

class UserSubject extends BaseModel
{
    public static function tableName()
    {
        return static::getDb()->tablePrefix . "user_subject";
    }
}