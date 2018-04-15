<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use pendalf89\filemanager\widgets\FileInput;

use app\helper\Functions;
$this->title = 'Chuyên mục';

$position_list = Yii::$app->params['category_position'];

$this->registerCssFile("/frontend/css/font-awesome.min.css", ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="row">

    <div class="col-md-6">

            <div class="header">
                <h3><?= $model->id>0?'Sửa':'Tạo' ?> chuyên mục</h3>
            </div>


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

                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                ]); ?>

                    <?= $form->field($model, 'name', ['template' => '<label class="control-label">{label}</label>{input}{error}'])->textInput()?>                    
                    <?= $form->field($model, 'icon', ['template' => '<label class="control-label">{label}</label>{input}'])->textInput(['placeholder' => 'fa fa-TÊN_ICON'])?>                    
                    <p><a href="http://fontawesome.io/icons/" target="_blank"><u>Danh sách icon</u></a>  (Ví dụ: fa fa-camera <i class="fa fa-camera"></i>)</p>
                    <?= $form->field($model, 'description', ['template' => '<label class="control-label">{label}</label>{input}'])->textArea()?>                    
                    <?= $form->field($model, 'parent_id', ['template' => '<label class="control-label">{label}</label>{input}'])->dropDownList($categoriesTreelevel1, ['prompt'=>'Gốc'])?>
                    <?php
                        echo $form->field($model, 'logo')->widget(FileInput::className(), [
                            'buttonTag' => 'button',
                            'buttonName' => 'Browse',
                            'buttonOptions' => ['class' => 'btn btn-red'],
                            'options' => ['class' => 'form-control'],
                            'template' => '<label class="control-label">Ảnh đại diện</label><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                            'imageContainer' => '.img',
                            'pasteData' => FileInput::DATA_URL,
                            'callbackBeforeInsert' => 'function(e, data) {
                                console.log( data );
                            }',
                        ]);
                    ?>
                    <?php
                        echo $form->field($model, 'cover')->widget(FileInput::className(), [
                            'buttonTag' => 'button',
                            'buttonName' => 'Browse',
                            'buttonOptions' => ['class' => 'btn btn-red'],
                            'options' => ['class' => 'form-control'],
                            'template' => '<label class="control-label">Ảnh cover</label><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                            'imageContainer' => '.img',
                            'pasteData' => FileInput::DATA_URL,
                            'callbackBeforeInsert' => 'function(e, data) {
                                console.log( data );
                            }',
                        ]);
                    ?>    
                    <?= $form->field($model, 'status', ['template' => '<label class="control-label">{label}</label>{input}'])->dropDownList([STATUS_ACTIVE => 'Hiển thị', STATUS_INACTIVE => 'Ẩn'])?>
                    <?= $form->field($model, 'is_hot', ['template' => '<label class="control-label">{label}</label>{input}'])->dropDownList([STATUS_INACTIVE => 'Không', STATUS_ACTIVE => 'Có'])?>
                    
                    <?= $form->field($model, 'show_home', ['template' => '<label class="control-label">{label}</label>{input}'])->dropDownList($position_list)?>
                    <?= $form->field($model, 'show_home_limit', ['template' => '<label class="control-label">{label}</label>{input}'])->textInput()?>
                    <?= $form->field($model, 'show_menu', ['template' => '<label class="control-label">{label}</label>{input}'])->dropDownList([STATUS_INACTIVE => 'Không', STATUS_ACTIVE => 'Hiển thị'])?>
                    <?= $form->field($model, 'show_footer', ['template' => '<label class="control-label">{label}</label>{input}'])->dropDownList([STATUS_ACTIVE => 'Hiển thị', STATUS_INACTIVE => 'Không'])?>
                    <?= $form->field($model, 'number_order', ['template' => '<label class="control-label">{label}</label>{input}'])->textInput()?>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Xong</button>
                    </div>
                <?php ActiveForm::end(); ?>

    </div>
	<div class="col-md-6">
	<img class="img-responsive" src="/backend/images/category.png">
    </div>

</div>
