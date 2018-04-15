<?php
namespace app\controllers;
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 9/25/2016
 * Time: 8:57 PM
 */
use app\helper\Solr;
use app\models\Category;
use app\models\News;
use Yii;

class NotificationController extends BaseController
{
    public function actionIndex(){
        die;
        $cache = Yii::$app->cache;
        $key = md5("H2t#APP#NOTIFICATION");
        $H = (int)date("H");
        $time = \DateTime::createFromFormat('Y-m-d H', date("Y-m-d H"))->getTimestamp();
        if($H == 7 || $H == 11 || $H == 19){
            if(!$cache->get($key)){
                $datanew = $this->getFind();
                $data = $this->getPush(true,true,"high","1",$datanew[0]["title"],$datanew[0]["description"],"com.h2tonline.fcm.ACTION_NEWS",$datanew[0]["id"]);
                $cache->set($key,$time,43200);
                echo json_encode($data);exit;
            }else if((int)$time != (int)$cache->get($key)){
                $datanew = $this->getFind();
                $data = $this->getPush(true,true,"high","1",$datanew[0]["title"],$datanew[0]["description"],"com.h2tonline.fcm.ACTION_NEWS",$datanew[0]["id"]);
                $cache->set($key,$time,43200);
                echo json_encode($data);exit;
            }else {
                echo "Da gui ".date("Y-m-d H");exit;
            }
        }
        echo "Khong dung gio ".date("Y-m-d H");exit;
    }

    public function getFind(){
        $where = [];
        $where['status'] = NEWS_STATUS_PUBLISHED;
        if(SOLR_SEARCH){
            $newsList = Solr::searchNews($where, 1,1);
        }else{
            $newsList = News::search($where, 1,1,['news.id' => SORT_DESC]);
        }
        $is_next = 0;
        if (count($newsList) >= 16) {
            $is_next = 1;
            array_pop($newsList);
        }
        foreach ($newsList as $n){
            $c = Category::find()->where(['id' => $n->category_id])->one();

            unset($n->content);
            $n->category_name = $c['name'];

            if ($n->logo == ""){
                if ($n->type == 2){
                    $n->logo = "/frontend/img/news-item.jpg";
                }else{
                    $n->logo = "/frontend/img/news-item.jpg";
                }
            }
        }
        return $newsList;
    }


    public function getPush($content_available,$show_in_foreground,$priority,$badge,$title,$body,$click_action,$news_id) {
        $notification = array();
        $notification['badge'] = $badge;
        $notification['title'] = $title;
        $notification['body'] = $body;
        $notification['click_action'] = $click_action;
        $data = array();
        $data['news_id'] = $news_id;
        return $this->sendToTopic("h2tonline",$content_available,$show_in_foreground,$priority,$notification,$data);
    }

    public function sendToTopic($to,$content_available,$show_in_foreground,$priority,$notification,$data) {
        $fields = array(
            'to' => '/topics/' . $to,
            'content_available' => $content_available,
            'show_in_foreground' => $show_in_foreground,
            'priority' => $priority,
            'notification' => $notification,
            'data' => $data,
        );
        return $this->sendPushNotification($fields);
    }

    private function sendPushNotification($fields) {

        $url = 'https://fcm.googleapis.com/fcm/send';

        $headers = array(
            'Authorization: key=' . 'AAAANThLXac:APA91bEYgWQcZCU2yuquYOEB-aFsHWl08Oag3Nl2MQ5NGnyjO0nYQ_6BTb9hlltgsqMsy3I_SRCWGb52xmAWgaxze4RtZK884REH-vmVs1kKn-NRf_9baCOXF--QdRyAvM5O48RJgFuT',
            'Content-Type: application/json'
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        curl_close($ch);

        return $result;
    }
}
