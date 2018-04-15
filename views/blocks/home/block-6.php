<?php
//cột cao 4 bài
use app\helper\Functions;

?>
<section id="business-news">
	<?=$this->render('@app/views/blocks/common/_block-header', ['category' => $category])?>	
	
	<ul class="list-unstyled right-news-list right-news-list-2">
		<?php foreach ($newsList as $k => $n) { ?>
			<?php if ($k < 4) { ?>
				<li>
					<a href="/tin-tuc/<?= $n->slug ?>">
						<img src="<?= $n->logo ?>">
						<strong class="f-title">
							<?= $n->title . Functions::getNewsIcon($n->type) ?>
						</strong>
					</a>
				</li>
			<?php } ?>
		<?php } ?>
	</ul>
</section>