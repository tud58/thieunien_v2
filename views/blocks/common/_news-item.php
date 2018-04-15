<?php
use app\helper\Functions;
?>
<div class="news-item">
	<div class="embed-responsive embed-responsive-16by9">
		<a href="/tin-tuc/<?= $news->slug ?>">
			<img src="<?= $news->logo ?>">
		</a>
	</div>
	<a href="/tin-tuc/<?= $news->slug ?>">
		<strong class="f-title">
			<?= $news->title ?>
		</strong>
	</a>
</div>