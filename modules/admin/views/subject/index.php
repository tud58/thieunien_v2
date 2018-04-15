<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\helper\Functions;

$this->registerJsFile("/backend/js/bootstrap-datepicker.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs("
    $('.datepicker').datepicker();
"); 
$this->title = 'Chủ đề';
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
                        <?= Html::input('text', 'keyword', $searchData['keyword'], ['class' => 'form-control input-mini', 'placeholder' => 'Chủ đề']) ?>
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
                    <th width="1">Id</th>
                    <th class="col-lg-3">Chủ đề</th>
                    
                    <th class="col-lg-3">Người nhận</th>
                    <th class="col-lg-4">Ghi chú</th>
                    <th width="1"></th>
                    <th class="col-lg-2"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($subject_list as $subject){?>
                <tr>
                    <td><?=$subject->id ?></td>
                    <td class="text-break">
                        <b><?=$subject->name ?></b>
                        <?php if($subject->begin_time > 0){?>
                        <br>Bắt đầu: <?=date('d-m-Y', $subject->begin_time)?>
                        <?php }?>    
                        <?php if($subject->end_time > 0){?>
                        <br>Kết thúc: <?=date('d-m-Y', $subject->end_time)?>
                        <?php }?>    
                    </td>
                    
                    <td>
                            <?php if(isset($userSubject[$subject->id])){
                                foreach($userSubject[$subject->id] as $us){
                                    $color = 'info';
                                    if($us->status==STATUS_ACTIVE){
                                        $color = 'green';
                                    }elseif($us->status==STATUS_DELETED){
                                        $color = 'default';
                                    }
                                ?>
                                <p>
                                    <button type="button" class="btn btn-<?=$color?> btn-xs"><?=$us->user_full_name?></button>
                                    
                                    <span class="pull-right">
                                        
                                        <a href="/admin/subject/accept_request?id=<?=$us->id?>" class="btn btn-green btn-xs <?php if($us->status==STATUS_ACTIVE){?>disabled<?php }?>"><i class="entypo-check"></i></a>
                                        

                                        <a href="/admin/subject/reject_request?id=<?=$us->id?>" class="btn btn-default btn-xs <?php if($us->status==STATUS_DELETED){?>disabled<?php }?>"><i class="entypo-cancel"></i></a>  

                                    </span>
                                </p>
                            <?php   }
                            } ?>            
                    
                    </td>
                    <td class="text-break"><?=$subject->description ?></td>
                    <td><?=$subject->status==STATUS_ACTIVE?'<a class="btn btn-danger btn-xs">Hoạt động</a>':'<a class="btn btn-primary disabled btn-xs">Đóng</a>' ?></td>

                    
                    <td class="text-right">
                        <a class="btn btn-blue btn-xs" href="/admin/subject/add?id=<?= $subject->id ?>"><i class="glyphicon glyphicon-cog"></i> Sửa</a>
                        <a class="btn btn-blue btn-xs" onclick="return confirm('Thao tác không thể phục hồi, bạn có chắc muốn xóa?')" href="/admin/subject?action=delete&id=<?= $subject->id ?>">Xóa</a>
                        <a class="btn btn-orange btn-xs" href="/admin/log?reference_type=subject&reference_id=<?=$subject->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Nhật ký hoạt động"><i class="glyphicon glyphicon-time"></i></a>            
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
