<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    use app\helper\Functions;
    use pendalf89\filemanager\widgets\FileInput;
    use pendalf89\filemanager\widgets\TinyMCE;
    
    $this->registerCssFile("/backend/js/select2/select2.min.css", ['depends' => [\yii\web\JqueryAsset::className()]]);
    $this->registerJsFile("/backend/js/select2/select2.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);  
    $this->registerJsFile("/backend/js/bootstrap-datepicker.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
    //$this->registerJsFile("/js/site.js", ['depends' => [\yii\web\JqueryAsset::className()]]);


    $this->registerJs("
        $('.datepicker').datepicker();
        $('.select2').select2();
        load_note(".$model->id.");
    ");

    $this->title = 'Đăng tin';
?>

<div class="header">
    <h2><?= $this->title ?></h2>
    </br>
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
<div class="row">
    <div class="col-md-6">
        <?php $form = ActiveForm::begin([

                'options' => ['class' => ''],
                'fieldConfig' => [
                    'template' => "{input}",
                    //'labelOptions' => ['class' => 'col-lg-4 control-label'],
                ],

                'enableAjaxValidation' => false,
                'enableClientValidation' => false,
            ]); ?>
        <?= $form->field($model, 'title', ['template' => '<label class="control-label">{label}</label>{input}'])->textInput()?>
 
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
                'toolbar' => 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist  | link image | code media',
            ],
        ]); ?>

                                 
        <div class="text-center">
            <button type="submit" class="btn btn-success"> &nbsp; &nbsp; &nbsp; Hoàn thành  &nbsp; &nbsp; &nbsp; </button>

        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-md-6">
        <h3>Nội dung trực tiếp</h3>
        <?php foreach($live_content_list as $c){?>
            <div>
                <p><b><?=$c->title?></b><span class="pull-right"><?= $c->user_full_name . ' ' .date('H:i:s d/m/Y', $c->create_time)?></span></p>
                <?=$c->content?>
            </div>
            <hr>
        <?php }?>
    </div>

</div>
