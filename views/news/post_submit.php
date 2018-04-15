<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\helper\Functions;
use pendalf89\filemanager\widgets\FileInput;
use pendalf89\filemanager\widgets\TinyMCE;

    
$this->title = 'Gửi bài viết';

?>
<div class="container">

    <div class="row">
        <div class="col-sm-4">
            <section id="profile-menu-left">
                <ul class="list-unstyled text-uppercase">
                    <!--<li><i class="fa fa-commenting" aria-hidden="true"></i><a href="#" class=""><strong>hồ sơ tương tác của thành viên</strong></a></li>-->
                    <li><i class="fa fa-cog" aria-hidden="true"></i><a href="/thong-tin-ca-nhan" class=""><strong>cập nhật hồ sơ</strong></a></li>
                    <li class="active"><i class="fa fa-pencil" aria-hidden="true"></i><a href="/dang-bai-viet" class="text-gradiant"><strong>Gửi bài viết</strong></a></li>
                </ul>
            </section>
        </div>
        <div class="col-sm-8">
            <h3 class="text-center">Gửi bài viết</h3>

            <?php if($success){?>
                <div class="alert alert-success">
                    <strong>Gửi bài viết thành công!</strong>
                    <p>Cảm ơn bạn đã tham gia đóng góp.</p>
                    <p><a href="/">Trở lại trang chủ</a></p>
                </div>    
            <?php }else{?>
            
            <?php if($model->getErrors()){?>
                <div class="alert alert-danger">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <strong><?=\Yii::t('app','Có lỗi xảy ra')?></strong>
                    <?php foreach($model->getFirstErrors() as $err){?>
                        <p><?= $err ?></p>
                    <?php }?>
                </div>
            <?php }?>    
            
            
            <?php $form = ActiveForm::begin([

                'options' => ['class' => ''],
                'fieldConfig' => [
                    'template' => "{input}",
                    //'labelOptions' => ['class' => 'col-lg-4 control-label'],
                ],

                'enableAjaxValidation' => false,
                'enableClientValidation' => false,
            ]); ?>

            <?= $form->field($model, 'title', ['template' => '<label class="control-label">{label}</label>{input}'])->textInput(['rows' => 5])?>
       
            <?= $form->field($model, 'content', ['template' => '<label class="control-label">{label}</label>{input}'])->widget(TinyMCE::className(), [
                'clientOptions' => [
                    'language' => 'vi',
                    'menubar' => false,
                    'height' => 500,
                    'image_dimensions' => false,
                    'paste_as_text' => true,
                    'plugins' => [
                        'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code contextmenu table paste media',
                    ],
                    'toolbar' => 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist  | link image | code',
                ],
            ]); ?>
            <div class="text-center">
                    <?= Html::submitButton('Gửi bài viết', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
            

            <?php }?>
        </div>
    </div>
</div>
        
