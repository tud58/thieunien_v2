<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\helper\Functions;
$this->title = 'Danh sách tag, từ khóa';
?>
<div class="header">
    <h3><?= $this->title ?></h3>
</div>
<div class="row">
    <div class="col-md-12">
        <form>
            <div class="row">

                <div class="col-xs-2">
                    <div class="">
                        <?= Html::input('text', 'id', $searchData['id'], ['class' => 'form-control input-mini', 'placeholder' => 'id']) ?>
                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="">
                        <?= Html::input('text', 'keyword', $searchData['keyword'], ['class' => 'form-control input-mini', 'placeholder' => 'Tag']) ?>
                    </div>
                </div>
            
                <div class="col-xs-2">
                    <div class="">
                        <button type="submit" class="btn btn-default">Tìm</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6">
        <table class="table">
            <thead>
                <tr>
                    <th class="col-lg-1">Id</th>
                    <th class="col-lg-2">Từ khoá</th>
                    <th class="col-lg-2">Hiển thị tại trang chủ</th>

                    <th class="col-lg-2"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($tag_list as $tag){?>
                <tr>
                    <td><?=$tag->id ?></td>
                    <td><?=$tag->name ?></td>
                    <td><?=$tag->show_home==STATUS_ACTIVE?'<a class="btn btn-danger btn-xs">Hiển thị</a>':'<a class="btn btn-primary disabled btn-xs">Không</a>' ?></td>


                    <td class="text-right">
                        <a class="btn btn-blue btn-xs" href="/admin/tag?edit=<?= $tag->id ?>"><i class="glyphicon glyphicon-cog"></i> Sửa</a>
                        <?php if(in_array(Yii::$app->user->getIdentity()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])){ ?>
                        <a class="btn btn-blue btn-xs" onclick="return confirm('Xóa từ khóa sẽ xóa toàn bộ dữ liệu bài viết liên quan, bạn có chắc muốn xóa?')" href="/admin/tag?action=delete&id=<?= $tag->id ?>">Xóa</a>
                        <?php }?>
                        <a class="btn btn-orange btn-xs" href="/admin/log?reference_type=tag&reference_id=<?=$tag->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Nhật ký hoạt động"><i class="glyphicon glyphicon-time"></i></a>
                    </td>   

                </tr>
                <?php }?>
            </tbody>
        </table>
        <div class="row">
            <div class="col-lg-12">
                <div class="">
					<?=$this->render('../pagination', ['count_items' => $count_items, 'page'=>$page, 'page_count'=>$page_count, 'pageUrl'=>$pageUrl]);?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-md-offset-1">
                
        <div class="sorted ui-sortable">
        
            <div class="panel panel-success" data-collapsed="0">
        
                <!-- panel head -->
                <div class="panel-heading">
                    <div class="panel-title"><?= $model->id>0?'Sửa':'Tạo' ?> tag</div>
                    
                </div>
                
                <!-- panel body -->
                <div class="panel-body">
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
                        <?= $form->field($model, 'show_home', ['template' => '<label class="control-label">{label}</label>{input}'])->dropDownList([STATUS_INACTIVE => 'Không', STATUS_ACTIVE => 'Hiển thị'])?>
                        <button type="submit" class="btn btn-red">Xong</button>
                    <?php ActiveForm::end(); ?>
                </div>
                
            </div>
            
        </div>
        
    </div>


</div>
