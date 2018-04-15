<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var app\modules\user\models\forms\LoginForm $model
 */

$this->title = Yii::t('user', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="row">
        <div class="col-sm-4">
            <section id="profile-menu-left">
                <ul class="list-unstyled text-uppercase">
                    <li class="active"><i class="fa fa-user" aria-hidden="true"></i><a href="/dang-nhap" class="text-gradiant"><strong>Đăng nhập</strong></a></li>
                    <li><i class="fa fa-pencil" aria-hidden="true"></i><a href="/dang-ky" class=""><strong>Đăng ký</strong></a></li>
                </ul>
            </section>
        </div>
        <div class="col-sm-8">
            <div class="left-block">
                <div class="register-block">
                    <h3 class="text-center">Đăng nhập</h3>
                   
                    <div class="user-default-login">

                        <?php $form = ActiveForm::begin([
                            'id' => 'login-form',
                            'options' => ['class' => ''],
                            'fieldConfig' => [
                                'template' => "{label}{input}{error}",
                                'labelOptions' => ['class' => ''],
                            ],

                        ]); ?>

                        <?= $form->field($model, 'email') ?>
                        <?= $form->field($model, 'password')->passwordInput() ?>
<!--                            <?= $form->field($model, 'rememberMe', [
                            'template' => "{label}<div class=\"col-lg-10\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
                        ])->checkbox() ?>  -->

                        <div class="form-group">
                            <?= Html::submitButton('Đăng nhập', ['class' => 'btn btn-success']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                    Đăng nhập qua tài khoản
                    <div class="reg-type">
                        <a href="/user/auth/login?authclient=facebook"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
                        <a href="/user/auth/login?authclient=google"><i class="fa fa-google" aria-hidden="true"></i></a>
                    </div>

                    <hr>
                    <a href="/dang-ky">Đăng ký trực tiếp</a>
                </div>
            </div>
            <div class="right-block">

            </div>
        </div>
    </div>
</div>


