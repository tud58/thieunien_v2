<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var app\modules\user\Module $module
 * @var app\modules\user\models\User $user
 * @var app\modules\user\models\UserToken $userToken
 */

$module = $this->context->module;

$this->title = Yii::t('user', 'Account');
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
                    <li class=" col-sm-6"><a href="/thong-tin-ca-nhan">Chi tiết cá nhân</a></li>      
                    <li class="active col-sm-6"><a href="/thong-tin-dang-nhap">Thông tin đăng nhập</a></li>

                </ul>
                <div class="clearfix"></div>
                <!-- Tab panes -->
                <div class="tab-content user-setting">
 
                    <div role="tabpanel" class="tab-pane active" id="save">
                        <?php if ($flash = Yii::$app->session->getFlash("Account-success")): ?>

                            <div class="alert alert-success">
                                <p><?= $flash ?></p>
                            </div>

                        <?php elseif ($flash = Yii::$app->session->getFlash("Resend-success")): ?>

                            <div class="alert alert-success">
                                <p><?= $flash ?></p>
                            </div>

                        <?php elseif ($flash = Yii::$app->session->getFlash("Cancel-success")): ?>

                            <div class="alert alert-success">
                                <p><?= $flash ?></p>
                            </div>

                        <?php endif; ?>

                        <?php $form = ActiveForm::begin([
                            'id' => 'account-form',
                            'options' => ['class' => 'form-horizontal'],
                            'fieldConfig' => [
                                'template' => "{label}\n<div class=\"col-lg-5\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
                                'labelOptions' => ['class' => 'col-lg-3 control-label'],
                            ],
                            'enableAjaxValidation' => true,
                        ]); ?>





                        <div class="form-group field-user-email required">
                            <label class="col-lg-3 control-label" for="user-email">Email</label>
                            <div class="col-lg-5 control-label" style="text-align: left;"><?=$user->email?></div>
                            <div class="col-lg-4"><div class="help-block"></div></div>
                        </div>
                        <div class="form-group field-user-email required">
                            <label class="col-lg-3 control-label" for="user-email">Tên đăng nhập</label>
                            <div class="col-lg-5 control-label" style="text-align: left;"><?=$user->username?></div>
                            <div class="col-lg-4"><div class="help-block"></div></div>
                        </div>
                        <hr/>
                        <?php if ($user->password): ?>
                            <?= $form->field($user, 'currentPassword')->passwordInput() ?>
                        <?php endif ?>
                        <?= $form->field($user, 'newPassword')->passwordInput() ?>

                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-10">
                                <?= Html::submitButton('Cập nhật', ['class' => 'btn btn-success']) ?>
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>
                    

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
