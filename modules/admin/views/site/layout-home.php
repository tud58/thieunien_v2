<?php
use app\helper\BlockManager;
use app\models\Category;
$this->title = "Cấu hình trang chủ";
$this->registerCss("
#page-content div.col, #page-content div.row, #page-content div.block {
	border: solid 1px #ccc;
	min-height: 50px;
	padding: 3px;
	margin: 3px;
	margin-top: 20px;
}
#page-content div.col{
	background-color: #f1f1f1;
	margin: 0px;
}
#page-content div.block{
	background-color: #fff;
}
");
?>

<div class="header">
    <h3><?= $this->title ?></h3>
</div>
<div id="page-content">
	<p class="text-right">
		<a href="/admin/site/add-layout?type=row&parent_id=0"><i class="glyphicon glyphicon-plus"></i></a> 
	</p>
	
	<?php 
	$rowIndex = 0;
	foreach($layoutData as $dataRow){

	?>
		<?php if($dataRow->type == 'row'){
			$rowIndex++;
			?>
			<div class="row">
				<p class="text-right">
					Hàng <?=$rowIndex?> &nbsp;
					<a href="/admin/site/add-layout?id=<?=$dataRow->id?>"><i class="glyphicon glyphicon-pencil"></i></a> 
					<a href="/admin/site/add-layout?type=col&parent_id=<?=$dataRow->id?>"><i class="glyphicon glyphicon-plus"></i></a> 
					<a href="/admin/site/layout-home?action=delete&delete_id=<?=$dataRow->id?>"><i class="glyphicon glyphicon-minus" ></i></a>
				</p>
				<?php foreach($layoutData as $dataCol){?>
					<?php if($dataCol->type == 'col' && $dataCol->parent_id == $dataRow->id){?>	
						<div class="col-md-<?=$dataCol->width?> col">
							<p class="text-right">
								Cột chiều rộng <?=$dataCol->width?>/12 &nbsp; 
								<a href="/admin/site/add-layout?id=<?=$dataCol->id?>"><i class="glyphicon glyphicon-pencil"></i></a> 
								<a href="/admin/site/add-layout?type=block&parent_id=<?=$dataCol->id?>"><i class="glyphicon glyphicon-plus"></i></a> 
								<a href="/admin/site/layout-home?action=delete&delete_id=<?=$dataCol->id?>"><i class="glyphicon glyphicon-minus" ></i></a>
								
							</p>
							<?php foreach($layoutData as $dataBlock){?>
								<?php if($dataBlock->type == 'block' && $dataBlock->parent_id == $dataCol->id){?>	
									<div class="block">
										<p class="text-right">
											
											<a href="/admin/site/add-layout?id=<?=$dataBlock->id?>"><i class="glyphicon glyphicon-pencil"></i></a> 				
											<a href="/admin/site/layout-home?action=delete&delete_id=<?=$dataBlock->id?>"><i class="glyphicon glyphicon-minus" ></i></a>
											
										</p>		
										
										<?php if($dataBlock->category_id > 0){
											$category = Category::findOne($dataBlock->category_id);
											?>
											<h3><?=$category->name?></h3>
											<?=Yii::$app->params['block_list'][$dataBlock->block_id]?>
										<?php }else  if($dataBlock->html != ''){
											echo htmlspecialchars($dataBlock->html);
										}?>
									</div>
								<?php }?>
								
								
							<?php }?>
						</div>
					<?php }?>

				<?php }?>				
			</div>
			</hr>
		<?php }?>

	<?php }?>
</div>