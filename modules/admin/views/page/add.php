<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\helper\Functions;

$this->registerCssFile("/js/cleeditor/jquery.cleditor.css", ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerJsFile("/js/cleeditor/jquery.cleditor.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("/js/jquery.form.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile("/js/site.js", ['depends' => [\yii\web\JqueryAsset::className()]]);


$this->registerJs("
    $('#edit').cleditor();
");

$this->title = 'Tạo trang';
?>
<div class="col-sm-6 col-md-6">
    <div class="header">
        <h3><?= $this->title ?></h3>
    </div>
    <div class="block-flat">
        <div class="content">
            <?php $form = ActiveForm::begin([

                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{input}",
                    //'labelOptions' => ['class' => 'col-lg-4 control-label'],
                ],

                'enableAjaxValidation' => false,
                'enableClientValidation' => false,
            ]); ?>
                <?= $form->field($model, 'name', ['template' => '<label class="control-label">{label}</label>{input}'])->textInput()?>

                <?= $form->field($model, 'content', ['template' => '<label class="control-label">{label}</label>{input}'])->textArea(['id' => 'edit'])?>

                <button type="submit" class="btn btn-primary">Xong</button>
            <?php ActiveForm::end(); ?>
        <form id="imageUploadForm" action="/upload/image" method="post" enctype="multipart/form-data" style="display: none;">
            <input name="ImageUpload[picture]" type="file" id="pictureUploadInput">
            <input name="<?=  yii::$app->request->csrfParam ?>" value="<?=  yii::$app->request->csrfToken ?>" type="text">
        </form>
        </div>
    </div>
</div>
