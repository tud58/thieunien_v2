<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="container" style="padding: 150px;">

    <h1>Có lỗi xảy ra:</h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Bạn vui lòng liên hệ ban quản trị để được hỗ trợ. Xin cảm ơn!
    </p>
    <p>
        <a href="/">Quay lại trang chủ</a>
    </p>

</div>
