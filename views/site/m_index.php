<?php
use app\helper\Functions;
$this->title = 'Hoa học trò';
?>
<div class="container">
    <ul class="row tab-list-home list-unstyled text-center text-uppercase" role="tablist">
        <li role="presentation" class="active"><a href="<?php echo '/tim-kiem' ?>">Tin mới nhất</a></li>
        <li role="presentation" class=""><a href="<?php if (count($lefts) > 0) echo '/danh-muc/'.$lefts[0]['slug'] ?>" >tin chia sẻ nhiều</a></li>
        <li role="presentation" class="last"><a href="<?php if (count($rights) > 0) echo '/danh-muc/'.$rights[0]['slug'] ?>">Tiêu điểm tuần</a></li>
    </ul>
    <div class="clearfix"></div>
    <section id="focus-day">
        <?php foreach($categories as $kc => $c){ ?>
            <div class="category-block">
                <?php if (count($c->news) > 0){ ?>
<!--                    <h4>-->
<!--                        <strong class="text-gradiant text-uppercase"> --><?//=$c->name ?><!--</strong>-->
<!--                        <a href="/danh-muc/--><?//=$c['slug'] ?><!--">Xem thêm <i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>-->
<!--                    </h4>-->
                    <?php foreach($c->news as $kn => $n){ ?>
                        <?php if ($kn >= 6){ break; }?>
                        <?php if ($kn == 0){ ?>
                            <div class="news-item first">
                                <a href="/tin-tuc/<?=$n->slug ?>">
                                    <img src="<?= HOST.$n->logo ?>">
                                </a>
                                <h5>
                                    <a href="/danh-muc/<?=$c['slug'] ?>">
                                        <strong class="main-color text-uppercase"> <?=$c->name ?></strong>
                                    </a>
<!--                                    <a href="/danh-muc/--><?//=$c['slug'] ?><!--">Xem thêm <i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>-->
                                </h5>
                                <h4>
									<a href="/tin-tuc/<?=$n->slug ?>">
										<strong><?=$n->title ?></strong>
									</a>
								</h4>
                                <?php if ($n->description){ ?>
                                    <div class="des">
                                        <?=$n->description ?>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php }else { ?>
                            <div class="focus-day-other">
                                <div class="news-item">
                                    <a href="/tin-tuc/<?=$n->slug ?>">
                                        <img src="<?= HOST.$n->logo ?>">
                                        <h5><strong><?=$n->title ?></strong></h5>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>
            <?php $keyAds = $kc + 61; ?>
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
                                        <a <?php if ($ads[$keyAds]->url){ ?>href="<?= $ads[$keyAds]->url ?>"<?php } ?> class="ads-custom"
                                           target="_blank">
                                            <img src="<?= HOST. $ai ?>">
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
                <hr>
            <?php } ?>
        <?php } ?>
		<div class="video-block">
		<h4>
			<strong class="text-gradiant text-uppercase"> Clip - Ảnh hay</strong>
			<a href="/video">Xem thêm <i class="fa fa-chevron-circle-right" aria-hidden="true"></i></a>
		</h4>
		<div class="video-icon">
			<a href="/clip/<?=$videos[0]->slug ?>">
				<img src="<?= HOST.$videos[0]->logo ?>">
			</a>
			<a href="/clip/<?=$videos[0]->slug ?>">
				<h4><strong><?=$videos[0]->title ?></strong></h4>
			</a>
		</div>
		<div class="row video-other">
			<?php foreach($videos as $kv => $v){ ?>
				<?php if ($kv > 0 && $kv < 3){ ?>
					<div class="col-sm-3 col-xs-6 video-icon">
						<a href="/clip/<?=$v->slug ?>">
							<div class="img-cover">
								<div class="img-background" style="background-image: url(<?=$v->logo ?>)">

								</div>
							</div>
						</a>
						<a href="/clip/<?=$v->slug ?>">
							<h5><strong><?=$v->title ?></strong></h5>
						</a>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
    </section>
</div>