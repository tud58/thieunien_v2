<?php
//Một bài lớn 2 bài con bên phải 4 bài trượt bên dưới
use app\helper\Functions;

?>

<section>
	<?=$this->render('@app/views/blocks/common/_block-header', ['category' => $category])?>	

	<div class="row">
		<div class="col-sm-8">
			<?php if (isset($newsList[0])) { ?>
				<div class="news-first-item">

					<div class="news-first-item-info">
						<?=$this->render('@app/views/blocks/common/_news-item', ['news' => $newsList[0]])?>

						<div class="f-description">
							<?= $newsList[0]->description ?>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
		<div class="col-sm-4 news-ex-item">
			<?php if (isset($newsList[1])) { ?>
				<?=$this->render('@app/views/blocks/common/_news-item', ['news' => $newsList[1]])?>
			<?php } ?>
			<?php if (isset($newsList[2])) { ?>
				<?=$this->render('@app/views/blocks/common/_news-item', ['news' => $newsList[2]])?>
			<?php } ?>
		</div>
	</div>
	<?php if (count($newsList) > 3) { ?>
		<a class="border-gradiant-round border-radius-12 text-uppercase other-news">Đọc thêm<span
				class="text-gradiant">Đọc thêm</span></a>
		<div class="owl-carousel home">

			<?php foreach ($newsList as $k => $news) { ?>
				<?php if ($k > 2 && $k <= 16) { ?>
					<?=$this->render('@app/views/blocks/common/_news-item', ['news' => $news])?>
				<?php } ?>
			<?php } ?>
		</div>
	<?php } ?>
</section>