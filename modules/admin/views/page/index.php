<?php

use app\helper\Functions;
use yii\helpers\Html;

$count = count($pageList);
?>
<div class="row">
    <div class="col-lg-12">
        <div class="">
            <h4><?=$this->title?></h4>
        </div>
    </div>
</div>
<div class="row block-flat">

        <form>
            <div class="row">
                <div class="col-xs-2">
                    <div class="">
                        <?= Html::input('text', 'id', $searchData['id'], ['class' => 'form-control input-mini', 'placeholder' => 'Mã tin ']) ?>
                    </div>
                </div>

                <div class="col-xs-4">
                    <div class="">
                        <?= Html::input('text', 'keyword', $searchData['keyword'], ['class' => 'form-control input-mini', 'placeholder' => 'Tiêu đề']) ?>
                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="">
                        <?= Html::dropDownList('status', $searchData['status'], [0 => 'Chưa duyệt', 1 => 'Đã duyệt', -1 => 'Hủy'], ['class' => 'input-mini form-control', 'prompt'=>'Trạng thái']) ?>
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
<div class="row block-flat">

                <table class="table">
                    <thead>
                        <tr>
                            <th class="">Id</th>
                            <th class="">Tên trang</th>
                            <th class="">Đường dẫn</th>
                            <th class="">Ngày đăng</th>
                            <th class="col-lg-1">Trạng thái</th>
                            <th class="col-lg-1"><a class="btn btn-success btn-xs" href="/admin/page/add">Tạo trang</a></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if($count == (ADMIN_ROW_PER_PAGE + 1)){
                        unset($pageList[(ADMIN_ROW_PER_PAGE)]);
                    }
                    foreach($pageList as $p){?>
                    <tr class="<?php if($p->status == -1) echo 'danger'; if($p->status == 0) echo 'warning'; ?>">
                        <td><?= $p->id ?></td>
                        <td><?= $p->name ?></td>
                        <td>/p/<?= $p->id . '-' . Functions::toSlug($p->name) ?></td>
                        <td><?= date('H:i d/m/Y', $p->create_time) ?></td>
                        <td><?php if($p->status == -1) echo 'Hủy'; if($p->status == 0) echo 'Đóng'; if($p->status == 1) echo 'Hoạt động';?></td>
                        <td>
                        <div class="btn-group">
                            <button class="btn dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-cog"></i> <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="/admin/page/add?id=<?=$p->id?>">Sửa</a></li>
                                <?if($p->status != 1){?>
                                    <li><a href="/admin/page/editstatus?id=<?=$p->id?>&status=1">Hoạt động</a></li>
                                <?php }?>
                                <?if($p->status != 0){?>
                                    <li><a href="/admin/page/editstatus?id=<?=$p->id?>&status=0">Đóng</a></li>
                                <?php }?>
                                <?if($p->status != -1){?>
                                    <li><a href="/admin/page/editstatus?id=<?=$p->id?>&status=-1">Hủy</a></li>
                                <?php }?>

                            </ul>
                        </div>
                        </td>
                    </tr>
                    <?php }?>
                    </tbody>
                </table>

        <div class="row">
            <div class="col-lg-12">
                <div class="">
                    <ul class="pagination">
                        <li class=" <?= $page<=1?'disabled':''?>"><a <?php if($page>1){?>href="/admin/news?<?= $pageUrl?>&page=<?=($page - 1)?>"<?php }?>>← Previous</a></li>
                        <li class=""><a><?= $page ?></a></li>
                        <li class=" <?= $count<=ADMIN_ROW_PER_PAGE?'disabled':''?>"><a <?php if($count>ADMIN_ROW_PER_PAGE){?>href="/admin/news?<?= $pageUrl?>&page=<?=($page + 1)?>"<?php }?>>Next → </a></li>
                    </ul>
                </div>
            </div>
        </div>

</div>