<?php
header('Content-Type: image/jpeg');
$ava_dir = dirname(__FILE__) . '/uploads/user_avatar/';
if(isset($_GET['id'])){
	if(file_exists($ava_dir.$_GET['id'].'.png')){
		readfile($ava_dir.$_GET['id'].'.png');
		exit;
	}
}
readfile($ava_dir.'0.png');
exit;