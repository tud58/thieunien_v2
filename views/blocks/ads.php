<div class="ads-block" style="margin-bottom: 10px;">
	<?php if (isset($ads[$keyAds])){ ?>
		<?php
		$this->registerJs("
			$('#slide-ads" . $ads[$keyAds]->id . "').carousel({
				interval: " . $ads[$keyAds]->time_swap * 1000 . "
			});
		");
		?>
		<div id="slide-ads<?= $ads[$keyAds]->id ?>" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner" role="listbox">
				<?php if ($ads[$keyAds]->type == ADS_TYPE_BANNER) { ?>
					<?php foreach ($ads[$keyAds]->images as $k => $ai) { ?>
						<?php if ($ai) {
							?>
							<div class="item <?= ($k == 0) ? "active" : ""; ?>">
								<a <?php if ($ads[$keyAds]->url){ ?>href="<?= $ads[$keyAds]->url ?>"<?php } ?> class="ads"
								   target="_blank">
									<img src="<?= $ai ?>">
								</a>
							</div>
						<?php } ?>
					<?php } ?>
				<?php } else { ?>
					<?php foreach ($ads[$keyAds]->htmls as $l => $ah) { ?>
						<?php if ($ah) {
							?>
							<div class="item <?= ($l == 0) ? "active" : ""; ?>">
								<?= $ah ?>
							</div>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			</div>
		</div>
	<?php } ?>
</div>