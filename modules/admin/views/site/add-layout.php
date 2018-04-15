<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use pendalf89\filemanager\widgets\FileInput;

use app\helper\Functions;
$this->title = 'Cấu hình layout';

$widthList = [

];
for($i = 1; $i<=12; $i++){
	$widthList[$i] = $i;
}
?>

<div class="row">

    <div class="col-md-6">

            <div class="header">
                <h3>Cấu hình layout</h3>
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

					<?php if($model->type == 'col'){?>
						<?= $form->field($model, 'width', ['template' => '<label class="control-label">{label}</label>{input}'])->dropDownList($widthList)?>
					 <?php }?>
					<?php if($model->type == 'block'){?>
						<?= $form->field($model, 'category_id', ['template' => '<label class="control-label">{label}</label>{input}'])->dropDownList($categoryTree, ['prompt'=>'Chọn'])?>
						<?= $form->field($model, 'block_id', ['template' => '<label class="control-label">{label}</label>{input}'])->dropDownList(\Yii::$app->params['block_list'])?>
						<?= $form->field($model, 'html', ['template' => '<label class="control-label">{label}</label>{input}'])->textArea()?>
                    <?php }?>
                    <?= $form->field($model, 'number_order', ['template' => '<label class="control-label">{label}</label>{input}'])->textInput()?>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </div>
                <?php ActiveForm::end(); ?>

    </div>


</div>
