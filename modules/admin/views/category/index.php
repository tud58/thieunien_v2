<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\helper\Functions;
$this->title = 'Chuyên mục';

$position_list = Yii::$app->params['category_position'];
?>
<div class="header">
    <h3><?= $this->title ?></h3>
</div>
<div class="row">
    <div class="col-md-12">

    
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="1">Id</th>
                    <th class="col-lg-3">Tên chuyên mục</th>
                    <th class="col-lg-1">Icon</th>

                    <th class="col-lg-1">Thứ thự</th>

                    <th class="col-lg-1">Trang chủ</th>
                    <th class="col-lg-1">Menu</th>
                    <th class="col-lg-1">Chân trang</th>

                    <th class="col-lg-1">Trạng thái</th>
                    <th class="col-lg-1">Sự kiện hot</th>
                    <th class="col-lg-3"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($categories as $category){?>
                <tr>
                    <td><?=$category->id ?></td>
                    <td><?= ($category->level == 1)?'|-- ':''?> <?= ($category->level == 2)?'|-- -- ':''?>  <?=$category->name ?></td>

                    <td><?=$category->icon?></td>
                    <td><?=$category->number_order ?></td>

                    <td><?=isset($position_list[$category->show_home])&&$category->show_home>0?$position_list[$category->show_home]:''?></td>
                    <td><?=$category->show_menu==STATUS_ACTIVE?'<i class="text-success glyphicon glyphicon-ok"></i>':'' ?></td>
                    <td><?=$category->show_footer==STATUS_ACTIVE?'<i class="text-success glyphicon glyphicon-ok"></i>':'' ?></td>
                    <td><?=$category->status==STATUS_ACTIVE?'<a class="btn btn-danger btn-xs">Hiển thị</a>':'<a class="btn btn-primary disabled btn-xs">Ẩn</a>' ?></td>
                    <td><?=$category->is_hot==STATUS_ACTIVE?'<a class="btn btn-danger btn-xs">Có</a>':'' ?></td>

                    <td class="text-right">
                        <?php if(in_array(Yii::$app->user->getIdentity()->role_id, [ROLE_ADMIN, ROLE_CONTRIBUTOR])){ ?>
                        <a class="btn btn-blue btn-xs" href="/admin/category/add?id=<?= $category->id ?>&edit_parent_id=<?=$category->parent_id?>"><i class="glyphicon glyphicon-cog"></i> Sửa</a>
                        <?php }?>
                        <?php if(in_array(Yii::$app->user->getIdentity()->role_id, [ROLE_ADMIN])){ ?>
                        <a class="btn btn-blue btn-xs" onclick="return confirm('Xóa chuyên mục sẽ xóa toàn bộ chuyên mục con và dữ liệu bài viết liên quan, bạn có chắc muốn xóa?')" href="/admin/category?action=delete&id=<?= $category->id ?>">Xoá</a>
                        <?php }?>
                        <a class="btn btn-orange btn-xs" href="/admin/log?reference_type=category&reference_id=<?=$category->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Nhật ký hoạt động"><i class="glyphicon glyphicon-time"></i></a>
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table>



    </div>

</div>
