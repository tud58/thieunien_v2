<?php

use app\models\SiteConfig;
use pendalf89\filemanager\widgets\TinyMCE;
use pendalf89\filemanager\widgets\FileInput;

?>

<div class="header">
    <h3><?= $this->title ?></h3>
</div>
<div id="page-content">
    <div class="tab-base">
        <form class="form-horizontal bv-form" method="post">
            <div class="tab-content">
                <div class="tab-pane fade active in" id="demo-bsc-tab-2">
                    <p class="text-main text-bold">Header</p>
                    <hr>
                    <?php foreach (Yii::$app->params['header_config'] as $config_key => $config) { ?>
                        <div class="form-group">
                            <label class="col-lg-3 control-label"><?= $config['name'] ?></label>

                            <div class="col-lg-7">
                                <?php if ($config['type'] == 'text') { ?>
                                    <?php
                                    echo TinyMCE::widget([
                                        'clientOptions' => [
                                            'language' => 'vi',
                                            'class' => '',
                                            'height' => 300,
                                            'image_dimensions' => false,
                                            'paste_as_text' => true,
                                            'plugins' => [
                                                'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code contextmenu table paste media  hr anchor pagebreak  wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table contextmenu directionality emoticons template paste textcolor colorpicker textpattern imagetools'
                                            ],
                                            'toolbar' => 'styleselect insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link  image media | code  print | forecolor backcolor fullscreen',
                                        ],
                                        'name' => $config_key,
                                    ]);
                                    ?>
                                <?php } else if ($config['type'] == 'text_image') { ?>
                                    <?php
                                    echo FileInput::widget([
                                        'name' => $config_key,
                                        'value' => SiteConfig::getByKey($config_key),
                                        'buttonTag' => 'button',
                                        'buttonName' => 'Browse',
                                        'buttonOptions' => ['class' => 'btn btn-red'],
                                        'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                        'imageContainer' => '.img',
                                        'pasteData' => FileInput::DATA_URL,
                                    ]);
                                    ?>
                                <?php } else if ($config['type'] == 'select') { ?>
                                    <select class="form-control" name="<?= $config_key ?>">
                                        <?php foreach ($config['options'] as $option_key => $option_val) { ?>
                                            <option
                                                value="<?= $option_key ?>" <?= SiteConfig::getByKey($config_key) == $option_key ? 'selected' : '' ?>><?= $option_val ?></option>
                                        <?php } ?>
                                    </select>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="demo-bsc-tab-2">
                    <p class="text-main text-bold">Footer</p>
                    <hr>
                    <?php foreach (Yii::$app->params['footer_config'] as $config_key => $config) { ?>
                        <div class="form-group">
                            <label class="col-lg-3 control-label"><?= $config['name'] ?></label>

                            <div class="col-lg-7">
                                <?php if ($config['type'] == 'text') { ?>
                                    <?php
                                    echo TinyMCE::widget([
                                        'clientOptions' => [
                                            'language' => 'vi',
                                            'class' => '',
                                            'height' => 300,
                                            'image_dimensions' => false,
                                            'paste_as_text' => true,
                                            'plugins' => [
                                                'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code contextmenu table paste media  hr anchor pagebreak  wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table contextmenu directionality emoticons template paste textcolor colorpicker textpattern imagetools'
                                            ],
                                            'toolbar' => 'styleselect insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link  image media | code  print | forecolor backcolor fullscreen',
                                        ],
                                        'name' => $config_key,
                                    ]);
                                    ?>
                                <?php } else if ($config['type'] == 'text_image') { ?>
                                    <?php
                                    echo FileInput::widget([
                                        'name' => $config_key,
                                        'value' => SiteConfig::getByKey($config_key),
                                        'buttonTag' => 'button',
                                        'buttonName' => 'Browse',
                                        'buttonOptions' => ['class' => 'btn btn-red'],
                                        'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                        'imageContainer' => '.img',
                                        'pasteData' => FileInput::DATA_URL,
                                    ]);
                                    ?>
                                <?php } else if ($config['type'] == 'select') { ?>
                                    <select class="form-control" name="<?= $config_key ?>">
                                        <?php foreach ($config['options'] as $option_key => $option_val) { ?>
                                            <option
                                                value="<?= $option_key ?>" <?= SiteConfig::getByKey($config_key) == $option_key ? 'selected' : '' ?>><?= $option_val ?></option>
                                        <?php } ?>
                                    </select>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="tab-footer clearfix">
                        <div class="col-lg-7 col-lg-offset-3">
                            <button type="submit" class="btn btn-primary">Xong</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>