<?php
use pendalf89\filemanager\widgets\FileInput;
use yii\widgets\ActiveForm;

$positions = [];
for ($i = 1; $i <= 100; $i++) {

    if ($i > 0) {
        $text = 'Trang chủ - ' . $i;
    }
    if ($i > 20) {
        $text = 'Chuyên mục - ' . ($i - 20);
    }
    if ($i > 40) {
        $text = 'Chi tiết tin - ' . ($i - 40);
    }
    if ($i > 60) {
        $text = 'Mobile Trang chủ - ' . ($i - 60);
    }
    if ($i > 80) {
        $text = 'Mobile Chi tiết - ' . ($i - 80);
    }
    $positions[$i] = $text;
}


?>

<div class="row">

    <div class="col-md-6">

        <div class="header">
            <h3><?= $model->id > 0 ? 'Sửa' : 'Tạo' ?> quảng cáo</h3>
        </div>
        <?php if ($model->getErrors()) { ?>
            <div class="alert alert-danger">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <strong><?= \Yii::t('app', 'Có lỗi xảy ra') ?></strong>
                <?php foreach ($model->getFirstErrors() as $err) { ?>
                    <p><?= $err ?></p>
                <?php } ?>
            </div>
        <?php } ?>

        <?php $form = ActiveForm::begin([

            'options' => ['class' => ''],
            'fieldConfig' => [
                'template' => "{input}",
                //'labelOptions' => ['class' => 'col-lg-4 control-label'],
            ],

            'enableAjaxValidation' => false,
            'enableClientValidation' => false,
        ]); ?>
        <?= $form->field($model, 'position', ['template' => '<label class="control-label">{label}</label>{input}'])->dropDownList($positions) ?>
        <?= $form->field($model, 'url', ['template' => '<label class="control-label">{label}</label>{input}'])->textInput(['rows' => 5]) ?>
        <?= $form->field($model, 'type', ['template' => '<label class="control-label">{label}</label>{input}'])->dropDownList(Yii::$app->params['ads_type'], ['id' => 'ads_type']) ?>
        <?= $form->field($model, 'show_type', ['template' => '<label class="control-label">{label}</label>{input}'])->dropDownList(Yii::$app->params['ads_show_type'], ['id' => 'ads_show_type']) ?>
        <div class="form-group">
            <div id="ads-content" class="type-<?= $model->show_type ?>">
                <label class="control-label">
                    <label class="control-label">Nội dung</label>
                </label>

                <div class="ads-code type-<?= $model->type ?>">
                    <?= $form->field($model, 'html', ['template' => '{input}'])->textArea(['rows' => 5, 'class' => 'form-control']) ?>
                </div>
                <div class="ads-banner type-<?= $model->type ?>">
                    <?php
                    echo $form->field($model, 'image')->widget(FileInput::className(), [
                        'buttonTag' => 'button',
                        'buttonName' => 'Browse',
                        'buttonOptions' => ['class' => 'btn btn-red'],
                        'options' => ['class' => 'form-control'],
                        'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                        'imageContainer' => '.img',
                        'pasteData' => FileInput::DATA_URL,
                        'callbackBeforeInsert' => 'function(e, data) {
                                console.log( data );
                            }',
                    ]);
                    ?>
                </div>
            </div>
            <div id="ads-multi-content" class="type-<?= $model->show_type ?>">
                <?= $form->field($model, 'time_swap', ['template' => '<label class="control-label">{label}</label>{input}'])->textInput(['rows' => 5]) ?>
                <?= $form->field($model, 'num_slide', ['template' => '<label class="control-label">{label}</label>{input}'])->dropDownList(["Chọn", 1, 2, 3, 4, 5, 6, 7, 8, 9, 10], []) ?>
                <?php
                if ($model->num_slide > 0) {
                    ?>
                    <label class="control-label">
                        <label class="control-label">Nội dung</label>
                    </label>

                    <div class="ads-code type-<?= $model->type ?>">
                        <?php
                        foreach ($model->htmls as $k => $h) {
                            ?>
                            <div class="form-group">
                                <textarea class="form-control" name="htmls[]" rows="5"><?= $h ?></textarea>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="ads-banner type-<?= $model->type ?>">
                        <?php
                        foreach ($model->images as $l => $i) {
                            ?>
                            <div class="form-group">
                                <?php
                                echo FileInput::widget([
                                    'name' => 'images[]',
                                    'value' => $i,
                                    'buttonTag' => 'button',
                                    'buttonName' => 'Browse',
                                    'buttonOptions' => ['class' => 'btn btn-red'],
                                    'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                    'imageContainer' => '.img',
                                    'pasteData' => FileInput::DATA_URL,
                                    'callbackBeforeInsert' => 'function(e, data) {
                                console.log( data );
                            }',
                                ]);
                                ?>
                            </div>

                        <?php
                        }
                        ?>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
        <?= $form->field($model, 'status', ['template' => '<label class="control-label">{label}</label>{input}'])->dropDownList([STATUS_ACTIVE => 'Hoạt động', STATUS_INACTIVE => 'Đóng']) ?>
        <button type="submit" class="btn btn-primary">Xong</button>
        <?php ActiveForm::end(); ?>
    </div>

</div>
