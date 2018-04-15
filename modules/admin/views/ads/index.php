<?php
use app\helper\Functions;
use yii\helpers\Html;


$positions = [];
for($i = 1; $i <= 100; $i++){
    
    if($i > 0){
        $text = 'Trang chủ - ' . $i;
    }
    if($i > 20){
        $text = 'Chuyên mục - ' . ($i - 20);
    }
    if($i > 40){
        $text = 'Chi tiết tin - ' . ($i - 40);
    }
    if($i > 60){
        $text = 'Mobile Trang chủ - ' . ($i - 60);
    }
    if($i > 80){
        $text = 'Mobile Chi tiết - ' . ($i - 80);
    }
    $positions[$i] = $text;
}


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
        <a class="btn btn-red pull-right add-button" href="/admin/ads/add">Thêm quảng cáo</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>

                    <th class="col-lg-1">Vị trí</th>                 
                    <th class="col-lg-1">Loại</th>
                    <th class="col-lg-5">Nội dung</th>
                    <th class="col-lg-1">Cập nhật</th>
                    <th class="col-lg-1">Trạng thái</th>
                    <th class="col-lg-1"></th>

                </tr>
            </thead>
            <tbody>
            <?php

            foreach($adsList as $ads){?>
            <tr>
                <td><?= $positions[$ads->position] ?></td>
                <td><?= Yii::$app->params['ads_type'][$ads->type] ?></td>
                <td>
                    <?php if($ads->type == ADS_TYPE_BANNER){?>
                    <a href="<?=$ads->url?>" target="=_blank"><img style="max-width: 400px; max-height: 200px;" src="<?=$ads->image?>"></a>
                    </br>
                    <a href="<?=$ads->url?>" target="_blank"><u></i><?=$ads->url?></u></a>
                    <?php }else if($ads->type == ADS_TYPE_HTML){?>
                        <?=htmlspecialchars($ads->html)?>
                    <?php }?>
                </td>

                <td><?= date('H:i:s d-m-Y', $ads->update_time) ?></td>
                <td><?=$ads->status==STATUS_ACTIVE?'<a class="btn btn-danger btn-xs">Hiển thị</a>':'<a class="btn btn-primary disabled btn-xs">Ẩn</a>' ?></td>
                <td>
                    <a class="btn btn-blue btn-xs" href="/admin/ads/add?id=<?= $ads->id ?>"><i class="glyphicon glyphicon-cog"></i> Sửa</a>
                    <a class="btn btn-blue btn-xs" onclick="return confirm('Thao tác không thể phục hồi, bạn có chắc muốn xóa?')" href="/admin/ads?action=delete&id=<?= $ads->id ?>">Xoá</a>
                    <a class="btn btn-orange btn-xs" href="/admin/log?reference_type=ads&reference_id=<?=$ads->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Nhật ký hoạt động"><i class="glyphicon glyphicon-time"></i></a>                     
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