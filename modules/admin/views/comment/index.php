<?php

use app\helper\Functions;
use yii\helpers\Html;

$count = count($commentList);


?>

<div class="header">
    <h3><?= $this->title ?></h3>
</div>
<div class="row">
    <div class="col-md-6">
        <form>
            <div class="row">
                <div class="col-xs-2">
                    <div class="">
                        <?= Html::input('text', 'news_id', $searchData['news_id'], ['class' => 'form-control input-mini', 'placeholder' => 'Id Bài viết ']) ?>
                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="">
                        <?= Html::input('text', 'id', $searchData['id'], ['class' => 'form-control input-mini', 'placeholder' => 'Id Comment']) ?>
                    </div>
                </div>
                <?php if(in_array(Yii::$app->user->getIdentity()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])){?>
                <div class="col-xs-2">
                    <div class="">
                        <?= Html::input('text', 'news_owner_id', $searchData['news_owner_id'], ['class' => 'form-control input-mini', 'placeholder' => 'Id tác giả']) ?>
                    </div>
                </div>
                <?php }?>
                <div class="col-xs-3">
                    <div class="">
                        <?= Html::dropDownList('status', $searchData['status'], [STATUS_ACTIVE => 'Đã duyệt', STATUS_INACTIVE => 'Chờ duyệt'], ['class' => 'input-mini form-control', 'prompt'=>'Trạng thái']) ?>
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
                    <th width="col-lg-1">Id</th>

                    <th class="col-lg-2">Họ tên</th>
                    <th class="col-lg-2">Email</th>
                    <th class="col-lg-3">Nội dụng</th>
                    <th class="col-lg-1">Reply to</th>
                    <th class="col-lg-1">Ngày đăng</th>
                    <th class="col-lg-1">Trạng thái</th>
                    <th class="col-lg-3"></th>
                </tr>
            </thead>
            <tbody>
            <?php
            if($count == (ADMIN_ROW_PER_PAGE + 1)){
                unset($commentList[(ADMIN_ROW_PER_PAGE)]);
            }
            foreach($commentList as $comment){?>
            <tr>
                <td><?= $comment->id ?></td>
                <td><?= $comment->user_name ?></td>
                <td><?= $comment->email ?></td>
                <td class="text-break"><?= $comment->message ?></td>
                <td><?= $comment->reply_to>0?('<a target="_blank" href="/admin/comment?id='.$comment->reply_to.'"><u>'.$comment->reply_to.'</u></a>'):'' ?></td>
                <td class="text-center"><?= date('H:i d/m/Y', $comment->create_time) ?></td>
                <td>
                    <?php if($comment->status == STATUS_ACTIVE){?>
                        <a class="btn btn-success btn-xs"><i class="glyphicon glyphicon-ok"></i> Hiển thị</a>
                    <?php }?>    
                    <?php if($comment->status == STATUS_INACTIVE){?>
                        <a class="btn btn-red btn-xs"><i class="glyphicon glyphicon-ban-circle"></i> Chờ duyệt</a>
                    <?php }?>    
                </td>
                <td class="text-right">

                    <a class="btn btn-success btn-xs" href="/admin/comment/edit_status?id=<?=$comment->id?>&status=<?=STATUS_ACTIVE?>"><i class="glyphicon glyphicon-ok"></i> Duyệt</a>
                    <a class="btn btn-red btn-xs" href="/admin/comment/edit_status?id=<?=$comment->id?>&status=<?=STATUS_INACTIVE?>"><i class="glyphicon glyphicon-ban-circle"></i> Bỏ duyệt</a>
                    <a  class="btn btn-blue btn-xs" href="/admin/comment/edit_status?id=<?=$comment->id?>&status=<?=STATUS_DELETED?>" onclick="return confirm('Xóa comment [<?=$comment->message?>] và toàn bộ trả lời, bạn có chắc muốn xóa?');"><i class="glyphicon glyphicon-remove"></i> Xóa</a>
                    <a class="btn btn-orange btn-xs" href="/admin/log?reference_type=comment&reference_id=<?=$comment->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Nhật ký hoạt động"><i class="glyphicon glyphicon-time"></i></a>            
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