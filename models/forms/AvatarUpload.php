<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;

class AvatarUpload extends Model
{
    public $picture;
    public function rules()
    {
        return [
            [['picture'], 'file', 'extensions' => 'gif, jpg, png', 'maxSize' => 1024 * 1024 * IMAGE_POST_MAX_SIZE],
        ];
    }
}