<?php

use app\helper\Functions;
use yii\helpers\Html;


$news_status = [
    NEWS_STATUS_PENDDING_REVIEW => 'Chờ biên tập',
    NEWS_STATUS_DRAFT => 'Nháp',
    NEWS_STATUS_APPROVED => 'Chờ xuất bản',
    NEWS_STATUS_PUBLISHED=> 'Đã xuất bản',
    STATUS_DELETED=> 'Đã hủy',
    NEWS_STATUS_CANCELED=> 'Trả lại bài',
];
$news_status_color = [
    NEWS_STATUS_PENDDING_REVIEW => 'orange',
    NEWS_STATUS_DRAFT => 'primary',
    NEWS_STATUS_APPROVED => 'info',
    NEWS_STATUS_PUBLISHED=> 'red',
    STATUS_DELETED=> 'default',
    NEWS_STATUS_CANCELED=> 'default',
];
?>

<div class="header">
    <h3><?= $this->title ?></h3>
</div>
<div class="row">
    <div class="col-md-12">
        <form>
            <div class="row">
                <div class="col-xs-1">
                    <div class="">
                        <?= Html::input('text', 'id', $searchData['id'], ['class' => 'form-control input-mini', 'placeholder' => 'Id']) ?>
                    </div>
                </div>
                <div class="col-xs-1">
                    <div class="">
                        <?= Html::input('text', 'user_id', $searchData['user_id'], ['class' => 'form-control input-mini', 'placeholder' => 'UserId']) ?>
                    </div>
                </div>

                <div class="col-xs-2">
                    <div class="">
                        <?= Html::input('text', 'keyword', $searchData['keyword'], ['class' => 'form-control input-mini', 'placeholder' => 'Tìm theo từ khóa']) ?>
                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="">
                        <?= Html::dropDownList('category_id', $searchData['category_id'], $categoryTree, ['class' => 'input-mini form-control', 'prompt'=>'Chuyên mục']) ?>
                    </div>
                </div>
				<?php if(Yii::$app->request->get('cancel') != 1){?>
                <div class="col-xs-2">
                    <div class="">
                        <?= Html::dropDownList('status', $searchData['status'], [NEWS_STATUS_DRAFT => 'Bài thô', NEWS_STATUS_PENDDING_REVIEW => 'Chờ biên tập', NEWS_STATUS_APPROVED => 'Chờ xuất bản', NEWS_STATUS_PUBLISHED => 'Đã xuất bản', NEWS_STATUS_CANCELED => 'Trả lại bài'], ['class' => 'input-mini form-control', 'prompt'=>'Trạng thái']) ?>
                    </div>
                </div>
				<?php }?>
                <div class="col-xs-2">
                    <div class="">
                        <?= Html::dropDownList('show_home', $searchData['show_home'], [STATUS_ACTIVE => 'Có hiển thị trang chủ', STATUS_INACTIVE => 'Không hiển thị trang chủ'], ['class' => 'input-mini form-control', 'prompt'=>'Hiển thị trang chủ']) ?>
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
        <a class="btn btn-red pull-right add-button" href="/admin/news/add">Đăng tin</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="1%">Id</th>
                    <th width="6%">Ảnh</th>
                    <th width="18%">Tiêu đề</th>
                    <th width="8%">Tác giả</th>
                    <th width="5%">Thể loại</th>
                    <th width="14%">Chuyên mục</th>
                    <th width="1%">Xem</th>    
                    <th width="6%">Cập nhật</th>
                    <th width="6%">Trang-chủ</th>
                    <th width="6%">Trạng thái</th>
                    <th width="10%"></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($newsList as $news){?>
            <tr>
                <td><a href="/admin/news/add?id=<?=$news->id?>"><?= $news->id ?></a></td>
                <td width="80"><?php if($news->logo != ''){?><img class="img-responsive" src="<?=$news->logo?>"><?php }?></td>
                <td>
                    <a href="/admin/news/add?id=<?=$news->id?>"><b><?= $news->title ?></b></a>
                </td>
                <td>
                    <?=$news->user_full_name?>    
                </td>
                <td>
                    <?=Yii::$app->params['news_types'][$news->type]?> 
                    <?php if($news->type == 3){?>
                    </br>
                    <a href="/admin/news/live_content?news_id=<?=$news->id?>" class="btn btn-info btn-xs">Thêm nội dung trực tiếp</a>
                    <?php }?>   
                </td>
                <td class=""><?php if(isset($newsCategoryName[$news->id])){
                        foreach($newsCategoryName[$news->id] as $category){?>
                            <button type="button" class="btn btn-default btn-xs"><?=$category->name?></button> 
                        <?php }
                     }?>
                </td>
                <td class="text-center"><?=$news->view_count?></td>
                <td class="text-center"><?= date('H:i d/m/Y', $news->update_time) ?></td>
                <td class="text-center">
					<?php if($news->show_home==STATUS_ACTIVE){?>
						<i class="glyphicon glyphicon-ok" style="color: green;"></i> | 
						<a href="/admin/news/edit_showhome?news_id=<?=$news->id?>&show_home=<?=STATUS_INACTIVE?>">Bỏ</a>
					<?php }else{?>
						<a href="/admin/news/edit_showhome?news_id=<?=$news->id?>&show_home=<?=STATUS_ACTIVE?>">Đặt</a>
					<?php }?>
					
				</td>
                <td><a class="btn btn-<?=$news_status_color[$news->status]?> btn-xs"><?=$news_status[$news->status]?></a></td>
                <td class="text-right">
                    <a class="btn btn-blue btn-xs" href="/admin/news/add?id=<?=$news->id?>"><i class="glyphicon glyphicon-cog"></i> Sửa</a>
                    <a class="btn btn-success btn-xs" href="/tin-tuc/<?=$news->slug?>"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Xem"><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a class="btn btn-orange btn-xs" href="/admin/log?reference_type=news&reference_id=<?=$news->id?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="Nhật ký hoạt động"><i class="glyphicon glyphicon-time"></i></a>
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