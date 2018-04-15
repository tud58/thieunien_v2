<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\helper\Functions;

$this->registerJsFile("/backend/js/bootstrap-datepicker.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs("
    $('.datepicker').datepicker();
"); 

?>

<div class="row">

    <div class="col-md-6">

            <div class="header">
                <h3><?= $model->id>0?'Sửa':'Tạo' ?> chủ đề</h3>
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

                    'enableAjaxValidation' => false,
                    'enableClientValidation' => false,
                ]); ?>
                    <?= $form->field($model, 'name', ['template' => '<label class="control-label">{label}</label>{input}'])->textInput()?>
                    <?= $form->field($model, 'description', ['template' => '<label class="control-label">{label}</label>{input}'])->textArea(['rows' => 5])?>
                    
                    <?= $form->field($model, 'begin_time_temp', ['template' => '<label class="control-label">{label}</label>{input}'])->textInput(['class' => 'form-control datepicker', 'data-date-format' => 'dd-mm-yyyy'])?>
                    <?= $form->field($model, 'end_time_temp', ['template' => '<label class="control-label">{label}</label>{input}'])->textInput(['class' => 'form-control datepicker', 'data-date-format' => 'dd-mm-yyyy'])?>
                    <?= $form->field($model, 'status', ['template' => '<label class="control-label">{label}</label>{input}'])->dropDownList([STATUS_ACTIVE => 'Hoạt động', STATUS_INACTIVE => 'Đóng'])?>            
                    <button type="submit" class="btn btn-primary">Xong</button>
                <?php ActiveForm::end(); ?>



    </div>

</div>
