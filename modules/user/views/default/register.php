<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var app\modules\user\Module $module
 * @var app\modules\user\models\User $user
 * @var app\modules\user\models\User $profile
 * @var string $userDisplayName
 */

$module = $this->context->module;

$this->title = Yii::t('user', 'Register');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="row">
        <div class="col-sm-4">
            <section id="profile-menu-left">
                <ul class="list-unstyled text-uppercase">
                    <li><i class="fa fa-user" aria-hidden="true"></i><a href="/dang-nhap" class=""><strong>Đăng nhập</strong></a></li>
                    <li  class="active"><i class="fa fa-pencil" aria-hidden="true"></i><a href="/dang-ky" class="text-gradiant"><strong>Đăng ký</strong></a></li>
                </ul>
            </section>
        </div>
        <div class="col-sm-8">
            <div class="left-block">
                <div class="register-block">
                    <h3 class="text-center">Đăng ký</h3>    
                    <div class="user-default-login">
                    <?php if ($flash = Yii::$app->session->getFlash("Register-success")){ ?>

                        <div class="alert alert-success">
                            <p><?= $flash ?></p>
                        </div>

                    <?php }else{?>
                        <?php $form = ActiveForm::begin([
                            'id' => 'login-form',
                            'options' => ['class' => ''],
                            'fieldConfig' => [
                                'template' => "{label}{input}{error}",
                                'labelOptions' => ['class' => ''],
                            ],

                        ]); ?>

                        <?php if ($module->requireEmail): ?>
                            <?= $form->field($user, 'email') ?>
                        <?php endif; ?>

                        <?php if ($module->requireUsername): ?>
                            <?= $form->field($user, 'username') ?>
                        <?php endif; ?>

                        <?= $form->field($user, 'newPassword')->passwordInput() ?>

                        <div class="form-group">
                            <?= Html::submitButton('Đăng ký', ['class' => 'btn btn-success']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    <?php } ?>
                    </div>
                    Đăng nhập qua tài khoản
                    <div class="reg-type">
                        <a href="/user/auth/login?authclient=facebook"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
                        <a href="/user/auth/login?authclient=google"><i class="fa fa-google" aria-hidden="true"></i></a>
                    </div>

                    <hr>
                    <a href="/dang-nhap">Đăng nhập</a>
                </div>
            </div>
            <div class="right-block">

            </div>
        </div>
    </div>
</div>