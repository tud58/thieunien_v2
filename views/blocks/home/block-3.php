<?php
//2 lớn 2 bên 4 tiêu đề dưới
use app\helper\Functions;

?>
	<section class="group-news-3">
		<?=$this->render('@app/views/blocks/common/_block-header', ['category' => $category])?>	

		<div class="row">
			<?php foreach ($newsList as $k => $news) { ?>
				<?php if ($k < 2 && $k >= 0) { ?>
					<div class="col-sm-6">
						<?=$this->render('@app/views/blocks/common/_news-item', ['news' => $news])?>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
		<ul>
			<?php foreach ($newsList as $k => $n) { ?>
				<?php if ($k >= 2 && $k < 6) { ?>
					<li>
						<a href="/tin-tuc/<?= $n->slug ?>">
							<strong class="f-title">
								<i class="fa fa-circle" aria-hidden="true"></i><?= strip_tags($n->title) . Functions::getNewsIcon($n->type) ?>
							</strong>
						</a>
					</li>
				<?php } ?>
			<?php } ?>
		</ul>
	</section>