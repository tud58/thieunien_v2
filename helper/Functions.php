<?php
namespace app\helper;

use Yii;

class Functions{
    public static function getImageBySize($url, $size){
        $d = explode('.', $url);
        $ext = $d[count($d) - 1];
        $substr = substr($url, 0, -1 * strlen('.' . $ext));
        $path = $substr . $size . '.' . $ext;
        if(is_file(Yii::getAlias('@webroot').$path)){
            return $path;
        }else if(is_file(Yii::getAlias('@webroot').$url)){
            return $url;
        }else{
            return '/backend/images/no-image.png';
        }
    }
    public static function searchCondToQuery($searchCond){
        $ret = "";
        if(is_array($searchCond) && count($searchCond) >0){

            foreach ($searchCond as $key=>$val){
                if($val!="")
                    $ret .= ($ret!=""?"&":"")."$key=$val";
            }
        }
        return $ret;
    }
    public static function toSlug($str){
        $unicode = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
            'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D'=>'Đ',
            'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );

        foreach($unicode as $nonUnicode=>$uni){
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
        $clean = strtolower(trim($clean));
        $clean = preg_replace("/[\/_|+ -]+/", '-', $clean);
        return $clean;
    }
    public static function getEmailByUserId($user_id){
        $userModel = Yii::$app->getModule("user")->model("user");
        $u = $userModel::findOne($user_id);
        if(isset($u->email)){
            return $u->email;
        }else{
            return false;
        }
    }
    public static function getUserIdByEmail($email){
        $userModel = Yii::$app->getModule("user")->model("user");
        $u = $userModel::find()->where(['email' => $email])->one();
        if(isset($u->id)){
            return $u->id;
        }else{
            return false;
        }
    }
	public static function replace_second_space($string){
		$words = explode(' ', $string);
		$chunks = array_chunk($words, 2);
		$chunks = array_map(function($arr) { return implode(' ', $arr); }, $chunks);
		return implode('</br>', $chunks);
	}
    public static function getNewsIcon($type){
        if($type == 1){
            return ' <i class="fa fa-image"></i>';
        }else if($type == 2){
            return ' <i class="fa fa-video-camera"></i>';
        }
        return '';
    }

    public static function isMobile(){
        $useragent=$_SERVER['HTTP_USER_AGENT'];

        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
            return true;

        return false;
    }

    public static function isIpad(){
        return stripos($_SERVER['HTTP_USER_AGENT'],"iPad") != "";
    }

    public static function isIphone(){
        return stripos($_SERVER['HTTP_USER_AGENT'],"iPhone") !== false;
    }
    public static function isAndroid(){
        return stripos($_SERVER['HTTP_USER_AGENT'],"Android") !== false;
    }
    public static function renameTag($name){
        $name_arr = explode(" ",$name);
        $result = $name;
//        if (count($name_arr) > 2){
//            $result = $name_arr[0]." ".$name_arr[1];
//        }
        return $result;
    }

    static function requestToMobile($status, $message = '', $value = '')
    {
        $data = array(
            'status' => $status, 'message' => $message, 'value' => $value
        );

        header('Content-type: application/json');
        print (json_encode($data));
        die;
    }

    static function removeKey($value)
    {
        $data = array();
        if(count($value) > 0)
        {
            $i = 0;
            foreach($value as $k => $v)
            {
                $data[] = $v;
                $i++;
            }
        }

        return $data;
    }

    static function addKey($key, $value)
    {
        $data = array();
        if(count($value) > 0)
        {
            foreach($value as $k => $v)
            {
                $data[ $v[ $key ] ] = $v;
            }
        }

        return $data;
    }

    static function sendNotiApp($data){
        $click_action = 'com.h2tonline.fcm.ACTION_NEWS';
        
        $url = 'https://fcm.googleapis.com/fcm/send';
        $key = 'AAAANThLXac:APA91bEYgWQcZCU2yuquYOEB-aFsHWl08Oag3Nl2MQ5NGnyjO0nYQ_6BTb9hlltgsqMsy3I_SRCWGb52xmAWgaxze4RtZK884REH-vmVs1kKn-NRf_9baCOXF--QdRyAvM5O48RJgFuT';

        $data_noti = array(
            'to'=>'dLb-pESBjYI:APA91bG9GgXLaGQZRxPyEYHOoeFEsgaTHp6m41O6k_svjTeI1XzMRwt8ghjcsWBsPvoGFtoa7Ph6_C5bNZHs9NfLu9g94FHs-QGG_cByyvXa1RJF6sFibMi_N5GdRUd4gSi_LpF87jBc',
            'content_available'=>true,
            "show_in_foreground"=> true,
   			"priority"=> "high",
            'notification'=>array(  'title'=>$data['title'],
                                    'body'=>$data['body'],
                                    'show_in_foreground'=> true,
                                    'click_action'=>$click_action,
                                    // 'thumb'=>($data['logo']) ? $data['logo'] : 'http://thieunien.abc/frontend/img/news-item.jpg';

            ),
            'data'=>array('extra'=>$data['id'])
        );

        // DBO::check_db('')->insert('logs_noti',array('uid'=>$to_gcm,'type'=>$type,'data'=>json_encode($data_noti),'created'=>time()));

        $ch = curl_init();

        $header = array();
        $header[] = 'Content-type: application/json';
        $header[] = 'Authorization: key='.$key;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_noti));
        curl_setopt($ch, CURLOPT_POST,true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $rest = curl_exec($ch);
        curl_close($ch);

        return $rest;
    }
}