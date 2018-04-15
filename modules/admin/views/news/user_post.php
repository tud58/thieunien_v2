<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\helper\Functions;

$this->registerJsFile("/backend/js/bootstrap-datepicker.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs("
    $('.datepicker').datepicker();
"); 
$this->title = 'Bài đóng góp';
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
                    <th width="1%">Id</th>
                    <th class="col-lg-3">Tiêu đề</th>
                    
                    <th class="col-lg-1">UserId</th>
                    <th class="col-lg-1">Họ tên</th>
                    <th class="col-lg-1">Email</th>
                    <th class="col-lg-1">Gửi lúc</th>
                    <th class="col-lg-1">Nhận bài viết</th>
                    <th class="col-lg-2"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($list as $post){?>
                <tr>
                    <td><?=$post->id ?></td>
                    <td><?=$post->title ?></td>
                    <td><?=$post->user_id ?></td>
                    <td><?=$post->user_full_name ?></td>
                    <td><?=$post->user_email ?></td>
                    <td><?=date('H:i d-m-Y', $post->create_time) ?></td>

                    <td>
                        <?php if($post->author_id == 0){?>
                            <a class="btn btn-red btn-xs" href="/admin/news/user_post_detail?id=<?= $post->id ?>&action=to_news" onclick="return confirm('Xác nhận nhận bài viết?');">Nhận bài viết</a>         
                        <?php }else{ echo $post->author_full_name; }?>  
                    </td>
                    <td class="text-right">

                        <a class="btn btn-success btn-xs" href="/admin/news/user_post_detail?id=<?= $post->id ?>">Chi tiết</a>
                        <a class="btn btn-blue btn-xs" onclick="return confirm('Thao tác không thể phục hồi, bạn có chắc muốn xóa?')" href="/admin/news/user_post?action=delete&id=<?= $post->id ?>">Xóa</a>
                        <a class="btn btn-orange btn-xs" href="/admin/log?reference_type=user_post&reference_id=<?=$post->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Nhật ký hoạt động"><i class="glyphicon glyphicon-time"></i></a>            
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
