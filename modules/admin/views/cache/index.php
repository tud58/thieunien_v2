<?php
use yii\widgets\ActiveForm;
?>
<div class="row">
	<div class="col-md-12">
        <h3>Quản lý cache</h3>
        <div class="row">
        	<div class="col-md-12">
	        	<div class="form-group">
	        		<?php if ($message){?>
	        		<div class="alert alert-success" role="alert">
					  <a href="#" class="alert-link"><?=$message?></a>
					</div>
	        		<?php }?>
	        	</div>
        		<div class="form-group">
        			<form action="" method="get" class="row">
        			<div class="col-sm-12">
        				<button type="submit" class="btn btn-primary" name="submit" value="submit">Xóa cache trang chủ</button>
        			</div>
        			</form>
        		</div>
        		<div class="form-group" >
					<?php $form = ActiveForm::begin([

						'options' => ['class' => 'row'],
						'fieldConfig' => [
							'template' => "{input}",
							//'labelOptions' => ['class' => 'col-lg-4 control-label'],
						],

						'enableAjaxValidation' => false,
						'enableClientValidation' => false,
					]); ?>			
					
	        			<input type="hidden" name="cmd" value="danh-muc">
	        			<div class="col-sm-4">
	        				<input type="text" name="slug" value="" placeholder="Nhập SLUG của danh mục" class="form-control">
	        			</div>
	        			<div class="col-sm-2">
	        				<button type="submit" class="btn btn-primary" name="submit" value="submit">Xóa cache trang tin</button>
	        			</div>
	        		<?php ActiveForm::end(); ?>
        		</div>
        	</div>
    	</div>
    </div>
</div>