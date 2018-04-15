<?php
//4 bài dàn hàng ngang
use app\helper\Functions;

?>
<section  class="group-news-3">
	<?=$this->render('@app/views/blocks/common/_block-header', ['category' => $category])?>	

	<div class="row">
		<?php foreach ($newsList as $k => $news) { ?>
			<?php if ($k < 4 && $k >= 0) { ?>
				<div class="col-sm-3">
					<?=$this->render('@app/views/blocks/common/_news-item', ['news' => $news])?>
				</div>
			<?php } ?>
		<?php } ?>
	</div>
	
</section>
 