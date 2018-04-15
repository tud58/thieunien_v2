<?php
namespace app\controllers;

/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 9/25/2016
 * Time: 8:57 PM
 */
use Yii;

class MemController extends BaseController
{
    public function actionIndex()
    {
        $cache = Yii::$app->cache;
        echo "Test memcached:<br/>";
        $key = md5("H2t#APP#NOTIFICATION");
        $time = \DateTime::createFromFormat('Y-m-d H', date("Y-m-d H"))->getTimestamp();
        if (!$cache->get($key)) {
            $cache->set($key, $time, 43200);
            echo "not exits";
            exit;
        } else if ((int)$time != (int)$cache->get($key)) {
            $cache->set($key, $time, 43200);
            echo "not same";
            exit;
        } else {
            echo "Sent" . date("Y-m-d H") . '-' . $cache->get($key);
            exit;
        }
    }
}
