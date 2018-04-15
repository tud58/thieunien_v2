<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\modules\user\helpers\Timezone;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var app\modules\user\models\Profile $profile
 */

$this->registerJsFile("http://malsup.github.io/jquery.form.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs("
    $('#avatar_form').ajaxForm(
        {
            beforeSend: function() {
                $('#avatar_upload_button').html('đang tải lên ...');
            },
            uploadProgress: function(event, position, total, percentComplete) {

            },
            success: function() {
                $('.avatar_img').attr('src', $('#avatar_img').attr('src') + 1);
            },
            complete: function(xhr) {
                $('#avatar_upload_button').html('Tải lên avatar');
            }
        } 
    )
");
 
$this->title = Yii::t('user', 'Profile');
$this->params['breadcrumbs'][] = $this->title;

?>


    <div class="container">

        <div class="row">
            <div class="col-sm-4">
                <section id="profile-menu-left">
                    <ul class="list-unstyled text-uppercase">
                        <!--<li><i class="fa fa-commenting" aria-hidden="true"></i><a href="#" class=""><strong>hồ sơ tương tác của thành viên</strong></a></li>-->
                        <li class="active"><i class="fa fa-cog" aria-hidden="true"></i><a href="/thong-tin-ca-nhan" class="text-gradiant"><strong>cập nhật hồ sơ</strong></a></li>
                        <li><i class="fa fa-pencil" aria-hidden="true"></i><a href="/gui-bai-viet" class=""><strong>Gửi bài cộng tác</strong></a></li>
                    </ul>
                </section>
            </div>
            <div class="col-sm-8">
                <!-- Nav tabs -->
                <ul class="list-unstyled profile-tab text-center" role="tablist">
                    <li class="active col-sm-6"><a href="/thong-tin-ca-nhan">Chi tiết cá nhân</a></li>      
                    <li class=" col-sm-6"><a href="/thong-tin-dang-nhap">Thông tin đăng nhập</a></li>

                </ul>
                <div class="clearfix"></div>
                <!-- Tab panes -->
                <div class="tab-content user-setting">
 
                    <div role="tabpanel" class="tab-pane active" id="save">
                        <?php if ($flash = Yii::$app->session->getFlash("Register-success")){ ?>

                            <div class="alert alert-success">
                                <p><?= $flash ?></p>
                            </div>

                        <?php }?>          
                        <?php if ($flash = Yii::$app->session->getFlash("Profile-success")): ?>

                            <div class="alert alert-success">
                                <p><?= $flash ?></p>
                            </div>

                        <?php endif; ?>              
                        <div class="">


                            <?php $form = ActiveForm::begin([
                                'id' => 'profile-form',
                                'options' => ['class' => 'form-horizontal'],
                                'fieldConfig' => [
                                    //'template' => "{label}\n<div class=\"col-sm-3\">{input}</div>\n<div class=\"col-sm-7\">{error}</div>",
                                    'labelOptions' => ['class' => 'col-sm-2 control-label'],
                                ],
                                'enableAjaxValidation' => true,
                            ]); ?>

                            <?= $form->field($profile, 'full_name', ['template' => '{label}<div class="col-sm-8">{input}</div>'])->textInput() ?>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="profile-full_name">Đổi avatar</label>
                                <div class="col-sm-8">
                                    <img id="avatar_img" class="avatar_img" src="/uploads/user_avatar/<?=Yii::$app->user->id?>.png?t=<?=time()?>" style="width: 100px;">
                                    <a href="javascript:void(0);" onclick="$('#avatar_input').click();" id="avatar_upload_button">Tải lên avatar</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <?= Html::submitButton('Cập nhật', ['class' => 'btn btn-success']) ?>
                                </div>
                            </div>

                            <?php ActiveForm::end(); ?>                      

                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="comment">...</div>
                </div>
            </div>
        </div>
    </div>
    
<form action="/user/upload_avatar" id="avatar_form" method="post" enctype="multipart/form-data" style="display: none;">
    <input type="file" name="AvatarUpload[picture]" id="avatar_input" onchange="$('#avatar_form').submit();">
    <button type="submit">zz</button>
</form>