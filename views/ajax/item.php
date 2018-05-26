<?php if ($news){ ?>
    <?php if (\app\helper\Functions::isMobile()){ ?>
        <section id="group-news-0-1">
            <hr>
            <h3 class="news-detail-title"><strong><?=$news->title ?></strong></h3>
            <div class="news-detail-info">
<!--                <span class="news-detail-author text-uppercase">--><?//=$news->user_full_name ?><!--</span>-->
                <?php if ($news->source){ ?>
                    | <span class="news-detail-source text-uppercase"><?=$news->source ?></span>
                <?php } ?>
                <span class="news-detail-time">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                    <?=date('d-m-Y H:i', $news->publish_time); ?>
                    </span>
					<div class="fb-like" data-href="<?=Yii::$app->request->hostInfo . Yii::$app->request->getUrl()?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>
            </div>
<!--            --><?php //if (isset($ads[41])){ ?>
<!--                <a --><?php //if ($ads[41]->url){ ?><!--href="--><?//=$ads[41]->url ?><!--"--><?php //} ?><!-- class="ads">-->
<!--                    --><?php //if ($ads[41]->type == ADS_TYPE_BANNER){ ?>
<!--                        <img src="--><?//=$ads[41]->image ?><!--">-->
<!--                    --><?php //}else { ?>
<!--                        --><?//=$ads[41]->html ?>
<!--                    --><?php //} ?>
<!--                </a>-->
<!--            --><?php //} ?>
            <div class="news-detail-description">
                <strong class=""><?=$news->description ?></strong>
            </div>
            <div class="news-detail-detail text-justify">
                <?php
                $content_arr = explode('</p>', $news->content);
                $keyAds = 81;
                foreach ($content_arr as $k => $ca){
                    echo $ca."</p>";
                    if (($k+1)%3 == 0){
                        ?>
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
                            <?php } ?>
                        </div>
                        <?php
                        $keyAds ++;
                    }
                }
                ?>
            </div>
        </section>
        <div class="clearfix"></div>
        <div class="ads-block">
            <?php if (isset($ads[42])){ ?>
                <?php
                $this->registerJs("
        $('#slide-ads" . $ads[42]->id . "').carousel({
        interval: " . $ads[42]->time_swap * 1000 . "
    });
    ");
                ?>
                <div id="slide-ads<?= $ads[42]->id ?>" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <?php if ($ads[42]->type == ADS_TYPE_BANNER) { ?>
                            <?php foreach ($ads[42]->images as $k => $ai) { ?>
                                <?php if ($ai) {
                                    ?>
                                    <div class="item <?= ($k == 0) ? "active" : ""; ?>">
                                        <a <?php if ($ads[42]->url){ ?>href="<?= $ads[42]->url ?>"<?php } ?> class="ads"
                                           target="_blank">
                                            <img src="<?= HOST. $ai ?>">
                                        </a>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        <?php } else { ?>
                            <?php foreach ($ads[42]->htmls as $l => $ah) { ?>
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
        <div class="clearfix"></div>
    <?php }else { ?>
        <section id="group-news-0-1" class="news-box">
            <h2 class="news-detail-title"><strong class="f-title"><?=$news->title ?></strong></h2>
            <div class="news-detail-info text-uppercase">
<!--                <span class="news-detail-author text-uppercase">--><?//=$news->user_full_name ?><!--</span>-->
                <?php if ($news->source){ ?>
                    | <span class="news-detail-source text-uppercase"><?=$news->source ?></span>
                <?php } ?>
                <span class="news-detail-time">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                    <?=date('d-m-Y H:i', $news->publish_time); ?>
                    </span>
					<div class="fb-like" data-href="<?=Yii::$app->request->hostInfo . Yii::$app->request->getUrl()?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>
            </div>
<!--            --><?php //if (isset($ads[41])){ ?>
<!--                <div>-->
<!--                    --><?php //if ($ads[41]->type == ADS_TYPE_BANNER){ ?>
<!--                        <a --><?php //if ($ads[41]->url){ ?><!--href="--><?//=$ads[41]->url ?><!--"--><?php //} ?><!-- class="ads" target="_blank">-->
<!--                            <img src="--><?//=$ads[41]->image ?><!--">-->
<!--                        </a>-->
<!--                    --><?php //}else { ?>
<!--                        --><?//=$ads[41]->html ?>
<!--                    --><?php //} ?>
<!--                </div>-->
<!--            --><?php //} ?>
            <div class="news-content video-content">
                <div class="fs-16">
                    <strong><?=$news->description ?></strong>
                </div>
                <div class="text-justify">
                    <?=$news->content ?>
                </div>
            </div>
        </section>
        <div class="clearfix"></div>
        <div class="ads-block">
            <?php if (isset($ads[42])){ ?>
                <?php
                $this->registerJs("
        $('#slide-ads" . $ads[42]->id . "').carousel({
        interval: " . $ads[42]->time_swap * 1000 . "
    });
    ");
                ?>
                <div id="slide-ads<?= $ads[42]->id ?>" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <?php if ($ads[42]->type == ADS_TYPE_BANNER) { ?>
                            <?php foreach ($ads[42]->images as $k => $ai) { ?>
                                <?php if ($ai) {
                                    ?>
                                    <div class="item <?= ($k == 0) ? "active" : ""; ?>">
                                        <a <?php if ($ads[42]->url){ ?>href="<?= $ads[42]->url ?>"<?php } ?> class="ads"
                                           target="_blank">
                                            <img src="<?= HOST. $ai ?>">
                                        </a>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        <?php } else { ?>
                            <?php foreach ($ads[42]->htmls as $l => $ah) { ?>
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
        <div class="clearfix"></div>
    <?php } ?>
<?php } ?>
<script>
	FB.XFBML.parse();
    var is_next = <?=$is_next ?>;
    $("#is_next").val(is_next);
//    if (is_next == 0)
//        $("#loading-layer").hide();
</script>