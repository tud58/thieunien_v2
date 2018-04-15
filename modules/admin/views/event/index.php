<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\helper\Functions;

$this->registerJsFile("/backend/js/bootstrap-datepicker.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs("
    $('.datepicker').datepicker();
"); 
$this->title = 'Sự kiện';
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
                        <?= Html::input('text', 'keyword', $searchData['keyword'], ['class' => 'form-control input-mini', 'placeholder' => 'Sự kiện']) ?>
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
    <div class="col-md-12">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="1%">Id</th>
                    <th class="col-md-4">Tên sự kiện</th>
                    
                    <th class="col-md-4">Nội dung</th>
                    <th width="1%">Trạng thái</th>
                    <th class="col-md-2"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($event_list as $event){?>
                <tr>
                    <td><?=$event->id ?></td>
                    <td class="text-break">
                        <b><?=$event->name ?></b>
                    </td>
                    <td class="text-break"><?=$event->description ?></td>
                    <td><?=$event->status==STATUS_ACTIVE?'<a class="btn btn-danger btn-xs">Hoạt động</a>':'<a class="btn btn-primary disabled btn-xs">Đóng</a>' ?></td>
                    <td class="text-right">
                        <a class="btn btn-blue btn-xs" href="/admin/event/add?id=<?= $event->id ?>"><i class="glyphicon glyphicon-cog"></i> Sửa</a>
                        <?php if(in_array(Yii::$app->user->getIdentity()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])){ ?>
                        <a class="btn btn-blue btn-xs" onclick="return confirm('Thao tác không thể phục hồi, bạn có chắc muốn xóa?')" href="/admin/event?action=delete&id=<?= $event->id ?>">Xóa</a>
                        <?php }?>
                        <a class="btn btn-orange btn-xs" href="/admin/log?reference_type=event&reference_id=<?=$event->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Nhật ký hoạt động"><i class="glyphicon glyphicon-time"></i></a>            
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
    
</div>
