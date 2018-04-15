<?php
use app\helper\Functions;
use app\helper\BlockManager;

$this->title = 'Hoa học trò';
?>
<div class="container">
	<?php 
	$rowIndex = 0;
	foreach($layoutData as $dataRow){

	?>
		<?php if($dataRow->type == 'row'){
			$rowIndex++;
			?>
			<div class="row">
				<?php foreach($layoutData as $dataCol){?>
					<?php if($dataCol->type == 'col' && $dataCol->parent_id == $dataRow->id){?>	
						<div class="col-md-<?=$dataCol->width?>">
							<?php foreach($layoutData as $dataBlock){?>
								<?php if($dataBlock->type == 'block' && $dataBlock->parent_id == $dataCol->id){?>	
									<?php 
										if($dataBlock->category_id > 0){
											echo BlockManager::renderHomeBlock($dataBlock->block_id, $dataBlock->category_id);	
										}else  if($dataBlock->html != ''){
											echo $dataBlock->html;
										}
									?>
								<?php }?>
							<?php }?>
						</div>
					<?php }?>

				<?php }?>				
			</div>
		<?php }?>

	<?php }?>


</div>