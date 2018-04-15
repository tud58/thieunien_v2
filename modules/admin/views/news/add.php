<?php
use pendalf89\filemanager\widgets\FileInput;
use pendalf89\filemanager\widgets\TinyMCE;
use yii\helpers\Html;

use yii\widgets\ActiveForm;

$this->registerCssFile("/backend/js/select2/select2.min.css", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("/backend/js/select2/select2.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("/backend/js/bootstrap-datepicker.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("/backend/js/bootstrap-timepicker.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile("/js/site.js", ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerCssFile("http://easyautocomplete.com/dist/easy-autocomplete.min.css", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("http://easyautocomplete.com/dist/jquery.easy-autocomplete.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerJs("
        $('.datepicker').datepicker();
        $('.timepicker').timepicker({
            showMeridian: false,
            defaultTime: false,
        });
        $('.select2').select2({
			tags: true,
		});
        load_note(" . $model->id . ");

		preview = function(){
			$('#preview-title').val($('#news-title').val());
			$('#preview-category_id').val($('#news-category_id').val());
			$('#preview-content').val(tinyMCE.get('news-content').getContent());
			$('#preview_form').submit();
		}

		var options = {


			url: function(phrase) {
				return '/admin/tag/search?keyword=' + phrase;
			},
			getValue: 'name',

			list: {
				match: {
					enabled: false
				},
				maxNumberOfElements: 30,
				onChooseEvent: function() {
					
                    var tag_show = '<li class=\"select2-selection__choice\" title=\"' + $('#search_tag').getSelectedItemData().name + '\">' + '<input type=\"hidden\" name=\"tag[]\" value=\"' + $('#search_tag').getSelectedItemData().id + '\">' + '<span class=\"quick-add-tag__remove\" onclick=\"$(this).parent().remove();\">×</span>' + $('#search_tag').getSelectedItemData().name + '</li>';
                    $('#select-tag ul.select2-selection__rendered').prepend(tag_show);
					$('#search_tag').val('');
				}
			},

			template: {
				type: 'custom',
				method: function(value, item) {
					return  item.name;
				}
			},

			theme: 'round'
		};

		$('#search_tag').easyAutocomplete(options);


");

$this->registerJs('
        tagShortcut = function (editor) {
            $(".mce-i-link").parent().on("click", function () {
//                console.log(editor.selection.getContent());
                editor.settings.link_list = "/admin/tag/shortcut?keyword=" + encodeURIComponent(editor.selection.getContent());
//                console.log("đc");
            });
            editor.on("ContextMenu", function (e) {
                $(".mce-i-link").parent().on("click", function () {
//                console.log(editor.selection.getContent());
                editor.settings.link_list = "/admin/tag/shortcut?keyword=" + encodeURIComponent(editor.selection.getContent());
//                    console.log("đc");
                });
            });
//            console.log("vào");
        }

');
$this->registerJs('
	var editor_id = "news-content";
	tinymce.PluginManager.add(\'instagram\', function(editor, url) {
		// Add a button that opens a window
		editor.addButton(\'instagram\', {
			text: \'Instagram\',
			icon: false,
			onclick: function() {
				// Open window
				editor.windowManager.open({
					title: \'Instagram Embed\',
					body: [
						{   type: \'textbox\',
							size: 40,
							height: \'100px\',
							name: \'instagram\',
							label: \'instagram\'
						}
					],
					onsubmit: function(e) {
						// Insert content when the window form is submitted
						var embedCode = e.data.instagram;
						var script = embedCode.match(/<script.*<\/script>/)[0];
						var scriptSrc = script.match(/".*\.js/)[0].split("\"")[1];
						var sc = document.createElement("script");
						sc.setAttribute("src", scriptSrc);
						sc.setAttribute("type", "text/javascript");

						var iframe = document.getElementById(editor_id + "_ifr");
						var iframeHead = iframe.contentWindow.document.getElementsByTagName(\'head\')[0];

						tinyMCE.activeEditor.insertContent(e.data.instagram);
						iframeHead.appendChild(sc);
						// editor.insertContent(\'Title: \' + e.data.title);
					}
				});
			}
		});
	});
');

$this->title = 'Đăng tin';
?>
<style>
    .easy-autocomplete-container {
        z-index: 999;
    }
</style>
<div class="header">
    <h2><?= $this->title ?></h2>
    </br>
</div>


<?php ActiveForm::begin([
    'action' => '/news/preview',
    'options' => ['target' => '_blank', 'id' => 'preview_form', 'style' => 'display: none;'],
    'fieldConfig' => [
        'template' => "{input}",
        //'labelOptions' => ['class' => 'col-lg-4 control-label'],
    ],

    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
]); ?>
<input name="news-title" id="preview-title">
<input name="news-content" id="preview-content">
<input name="news-category_id" id="preview-category_id">


<?php ActiveForm::end(); ?>

<?php $form = ActiveForm::begin([

    'options' => ['class' => ''],
    'fieldConfig' => [
        'template' => "{input}",
        //'labelOptions' => ['class' => 'col-lg-4 control-label'],
    ],

    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
]); ?>


<?php if (!$canEdit) { ?>
    <div class="alert alert-danger">
        <?= $canEditMessage ?>
    </div>
<?php } ?>
<?php if ($model->getErrors()) { ?>
    <div class="alert alert-danger">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <strong><?= \Yii::t('app', 'Có lỗi xảy ra') ?></strong>
        <?php foreach ($model->getFirstErrors() as $err) { ?>
            <p><?= $err ?></p>
        <?php } ?>
    </div>
<?php } ?>
<div class="row">
<div class="col-md-8">
<?= $form->field($model, 'title', ['template' => '<label class="control-label">{label}</label>{input}{error}'])->textInput(); ?>
<?= $form->field($model, 'source', ['template' => '<label class="control-label">{label}</label>{input}'])->textInput() ?>
<?= $form->field($model, 'author', ['template' => '<label class="control-label">{label}</label>{input}'])->textInput() ?>

<?=
$form->field($model, 'logo', ['template' => '<label class="control-label">Ảnh đại diện</label><div class="">{input}<span class="input-group-btn">{button}</span></div>{error}'])->widget(FileInput::className(), [
    'buttonTag' => 'button',
    'buttonName' => 'Browse',
    'buttonOptions' => ['class' => 'btn btn-red'],
    'options' => ['class' => 'form-control'],

    'imageContainer' => '.img',
    'pasteData' => FileInput::DATA_URL,
    'callbackBeforeInsert' => 'function(e, data) {
                    console.log( data );
                }',
]);
?>
<?=
$form->field($model, 'cover', ['template' => '<label class="control-label">Cover</label><div class="">{input}<span class="input-group-btn">{button}</span></div>{error}'])->widget(FileInput::className(), [
    'buttonTag' => 'button',
    'buttonName' => 'Browse',
    'buttonOptions' => ['class' => 'btn btn-red'],
    'options' => ['class' => 'form-control'],

    'imageContainer' => '.img',
    'pasteData' => FileInput::DATA_URL,
    'callbackBeforeInsert' => 'function(e, data) {
                    console.log( data );
                }',
]);
?>

<?=
$form->field($model, 'description', ['template' => '<label class="control-label">{label}</label>{input}{error}'])->textArea(); ?>
<?php /* if (in_array($role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR, ROLE_EDITOR])) { ?>
	<p>Thêm vào nội dung các chuỗi sau để hiện quảng cáo: #_QUANG_CAO_1_#, #_QUANG_CAO_2_#, ..., #_QUANG_CAO_9_#,  #_QUANG_CAO_MOBILE_1_# ... #_QUANG_CAO_MOBILE_9_#, </p>
	<?php } */
?>

<?php //dunghq - new - compare
if ($news_type == 'compare') {
    ?>
    <div class="compare-group">
        <h4>Thêm cặp ảnh so sánh</h4>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label">Ảnh so sánh 1</label>

                    <div class="input-group">
                        <input type="text" class="form-control" name="img-compare-1" id="img-compare-1">
                            <span class="input-group-btn">
                                <button id="img-compare-btn-1" class="btn btn-red" role="filemanager-launch">Browse
                                </button>
                                <button class="btn btn-default" role="clear-input" data-clear-element-id="img-compare-1"
                                        data-image-container=".img">
                                    <span class="text-danger glyphicon glyphicon-remove">
                                    </span>
                                </button>
                            </span>
                    </div>
                    <div role="filemanager-modal" class="modal" tabindex="-1" data-frame-id="img-compare-frame-1"
                         data-frame-src="/filemanager/file/filemanager" data-btn-id="img-compare-btn-1"
                         data-input-id="img-compare-1" data-image-container=".img" data-paste-data="url" data-thumb="">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label">Ảnh so sánh 2</label>

                    <div class="input-group">
                        <input type="text" class="form-control" name="img-compare-2" id="img-compare-2">
                            <span class="input-group-btn">
                                <button id="img-compare-btn-2" class="btn btn-red" role="filemanager-launch">Browse
                                </button>
                                <button class="btn btn-default" role="clear-input" data-clear-element-id="img-compare-2"
                                        data-image-container=".img">
                                    <span class="text-danger glyphicon glyphicon-remove">
                                    </span>
                                </button>
                            </span>
                    </div>
                    <div role="filemanager-modal" class="modal" tabindex="-1" data-frame-id="img-compare-frame-2"
                         data-frame-src="/filemanager/file/filemanager" data-btn-id="img-compare-btn-2"
                         data-input-id="img-compare-2" data-image-container=".img" data-paste-data="url" data-thumb="">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 text-center">
                <a href="#" class="btn btn-info" onclick="addCompare(); return false;">Thêm</a>
            </div>
        </div>
    </div>
    <style>
        .compare-group {
            border: 1px solid #ccc;
            padding: 15px;
        }

        .compare-group h4 {
            text-decoration: underline;
        }
    </style>
    <script>
        function addCompare() {
            var img_compare_1 = $('#img-compare-1').val();
            var img_compare_2 = $('#img-compare-2').val();

            if (img_compare_1 && img_compare_2) {
//                    var content = $('#news-content').val();
//                    content += '<div class="img-compare"><img style="width: 100%" src="'+img_compare_1+'"><img style="width: 100%" src="'+img_compare_2+'"></div><div></div>';
//                    tinyMCE.get('news-content').setContent(content);

                tinyMCE.activeEditor.execCommand('mceInsertContent', false, '<div class="img-compare"><img style="width: 100%" src="' + img_compare_1 + '"><img style="width: 100%" src="' + img_compare_2 + '"></div><div></div>');

                $('#img-compare-1').val('');
                $('#img-compare-2').val('');
            } else {
                if (img_compare_1 == '') {
                    alert('Chưa chọn ảnh trước!');
                }
                if (img_compare_2 == '') {
                    alert('Chưa chọn ảnh sau!');
                }
            }


        }
    </script>

<?php } else { ?>

<?php } ?>

<?=
$form->field($model, 'content', ['template' => '<label class="control-label">{label}</label>{input}{error}'])->widget(TinyMCE::className(), [
    'clientOptions' => [
        'language' => 'vi',
        //'menubar' => false,
        'height' => 700,
        'image_dimensions' => true,
        'paste_as_text' => true,
        'plugins' => [
            'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code contextmenu table paste media  hr anchor pagebreak  wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table contextmenu directionality emoticons template paste textcolor colorpicker textpattern imagetools instagram'
        ],
        'toolbar' => 'styleselect insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link  image media | code  print | forecolor backcolor fontsizeselect fullscreen instagram',
        'extended_valid_elements' => "script[language|type|async|src|charset]",
        'init_instance_callback' => 'tagShortcut',
        'target_list' => false,
        'image_class_list' => [
            ['title' => 'Không', 'value' => ''],
            ['title' => 'Căn trái', 'value' => 'align-left'],
            ['title' => 'Căn phải', 'value' => 'align-right'],
//            ['title' => 'Lệch trái 80', 'value' => 'align-left devi-80'],
//            ['title' => 'Lệch phải 80', 'value' => 'align-right devi-80'],
//            ['title' => 'Lệch trái 60', 'value' => 'align-left devi-60'],
//            ['title' => 'Lệch phải 60', 'value' => 'align-right devi-60'],
//            ['title' => 'Lệch trái 40', 'value' => 'align-left devi-40'],
//            ['title' => 'Lệch phải 40', 'value' => 'align-right devi-40'],
        ],
        //'setup' => 'function (editor) { editor.on(\'init\', function (args) { editor_id = args.target.id; }); }'
    ],
]); ?>

<div class="form-group">
    <label class="control-label"><label class="control-label" for="news-publish_time_temp">Trạng
            thái</label></label>

    <div class="row">
        <div class="col-sm-2">
            <div class="radio radio-replace">
                <input type="radio" value="save_draft" name="action"
                       <?php if ($model->status == NEWS_STATUS_DRAFT){ ?>checked<?php } ?>>
                <label>Nháp</label>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="radio radio-replace">
                <input type="radio" value="request_review" name="action"
                       <?php if ($model->status == NEWS_STATUS_PENDDING_REVIEW){ ?>checked<?php } ?>>
                <label>Gửi biên tập</label>
            </div>
        </div>
        <?php if (in_array($role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR, ROLE_EDITOR])) { ?>
            <div class="col-sm-3">
                <div class="radio radio-replace">
                    <input type="radio" value="cancel" name="action"
                           <?php if ($model->status == NEWS_STATUS_CANCELED){ ?>checked<?php } ?>>
                    <label>Trả lại bài</label>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="radio radio-replace">
                    <input type="radio" value="request_publish" name="action"
                           <?php if ($model->status == NEWS_STATUS_APPROVED){ ?>checked<?php } ?>>
                    <label>Gửi xuất bản</label>
                </div>
            </div>
        <?php } ?>
        <?php if (in_array($role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])) { ?>
            <div class="col-sm-3">
                <div class="radio radio-replace">
                    <input type="radio" value="publish" name="action"
                           <?php if ($model->status == NEWS_STATUS_PUBLISHED){ ?>checked<?php } ?>>
                    <label>Xuất bản</label>
                </div>
            </div>

        <?php } ?>
    </div>

</div>

<div class="text-center">
    <button type="submit" class="btn btn-success"> &nbsp; &nbsp; &nbsp; Hoàn thành &nbsp; &nbsp; &nbsp; </button>
    <button type="button" class="btn btn-info" onclick="preview(); return false;"> &nbsp; &nbsp; &nbsp; Xem trước &nbsp;
        &nbsp; &nbsp; </button>
    <?php if (in_array($role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])) { ?>
        <button type="submit" class="btn btn-primary" name="action" value="delete"
                onclick="return confirm('Bạn có chắc muốn hủy bài này')"> &nbsp; &nbsp; &nbsp; Huỷ bài &nbsp; &nbsp;
            &nbsp; </button>
    <?php } ?>
</div>

</div>
<div class="col-md-4">

    <div class="form-group">
        <label class="control-label"><label class="control-label">Chuyên mục</label></label></br>
        <?php foreach ($categoryTree as $category_id => $category_name) { ?>

            <div class="checkbox checkbox-replace color-red">
                <input type="checkbox" name="category[]"
                       value="<?= $category_id ?>" <?= (in_array($category_id, $model->category) ? 'checked="checked"' : '') ?>>
                <label> <?= $category_name ?></label>
            </div>

        <?php } ?>
    </div>
    <?= $form->field($model, 'category_id', ['template' => '<label class="control-label">{label}</label>{input}'])->dropDownList($categoryTree) ?>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6">
                <div class="checkbox checkbox-replace color-red">
                    <input type="checkbox" name="daily"
                           value="<?= $category_id ?>" <?= ($model->daily) ? 'checked="checked"' : ''; ?>>
                    <label> Nóng trong ngày</label>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="checkbox checkbox-replace color-red">
                    <input type="checkbox" name="contest" value="1" <?= ($model->contest) ? 'checked="checked"' : ''; ?>>
                    <label> Cuộc thi viết</label>
                </div>
            </div>
        </div>
    </div>
    <?= $form->field($model, 'publish_time_temp', ['template' => '<label class="control-label">{label}</label>{input}'])->textInput(['class' => 'form-control datepicker', 'data-date-format' => 'dd-mm-yyyy']) ?>
    <?= $form->field($model, 'publish_time_temp_hour', ['template' => '<label class="control-label">{label}</label>{input}'])->textInput(['class' => 'form-control timepicker']) ?>
    <div class="clearfix row">
        <div class="col-sm-6">
            <?= $form->field($model, 'active_time_temp', ['template' => '<label class="control-label">{label}</label>{input}'])->textInput(['class' => 'form-control datepicker', 'data-date-format' => 'dd-mm-yyyy']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'active_time_temp_hour', ['template' => '<label class="control-label">{label}</label>{input}'])->textInput(['class' => 'form-control timepicker']) ?>
        </div>
    </div>
    <?php //dunghq - new - compare
    if ($news_type == 'compare') {
        ?>
        <?= $form->field($model, 'type')->hiddenInput(['value' => 5]) ?>
    <?php } else { ?>
        <?= $form->field($model, 'type', ['template' => '<label class="control-label">{label}</label>{input}'])->dropDownList(Yii::$app->params['news_types']) ?>
    <?php } ?>


    <?= $form->field($model, 'show_home', ['template' => '<label class="control-label">{label}</label>{input}'])->dropDownList([STATUS_ACTIVE => 'Có', STATUS_INACTIVE => 'Không']) ?>

    <div class="form-group <?= $model->hasErrors('tag') ? "has-error" : "" ?>" id="select-tag">
        <input type="hidden" id="news_id" value="<?= $model->id ?>">
        <label class="control-label"><?= $model->getAttributeLabel('tag') ?></label>
        <br>
        <i>Chọn từ kho:</i>
        <input id="search_tag" class="form-control" placeholder="Nhập từ khóa tìm kiếm"
               style="margin-bottom: 5px; width: 80%;">

        <div>
            <?= Html::dropDownList("tag", $model->tag, $tag_list, ['class' => 'form-control select2', 'multiple' => 'multiple']) ?>
        </div>
        <div style="margin-top: 5px">
            <i>hoặc thêm mới:</i>

            <div><span id="add-tag-msg" style="color: #d44950"></span></div>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Tag mới..." id="new-tag">
                <span class="input-group-btn"><button class="btn btn-warning" type="button" onclick="quickAddTag()">
                        Thêm
                    </button></span>
            </div>
        </div>
    </div>

    <?= $form->field($model, 'event_id', ['template' => '<label class="control-label">{label}</label>{input}'])->dropDownList($event_list, ['prompt' => 'Chọn sự kiện']) ?>


    <hr>
    <b>Ghi chú</b>
    <?php if (in_array($role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR, ROLE_EDITOR])) { ?>
        <div class="row">
            <div class="col-md-12">
                <div class="user-comment-content">
                    <textarea class="form-control autogrow" placeholder="Ghi note" id="note_input"></textarea>
                    </br>
                    <button type="button" class="btn btn-success pull-right" onclick="save_note(<?= $model->id ?>)">
                        Xong
                    </button>

                </div>
            </div>
        </div>
        <hr>
    <?php } ?>
    <div class="row" id="note_view">

    </div>
</div>


<?php ActiveForm::end(); ?>

</div>
