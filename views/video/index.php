<?php
use app\helper\Functions;
$this->title = "Clip nổi bật";
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("infinity('video');", \yii\web\View::POS_END, 'my-options');
?>
<div class="container">
<div class="left-block">
    <section id="group-news-0-1">
        <h3 class="text-uppercase">
            <strong class="text-gradiant"> Clip - Ảnh hay</strong>
        </h3>
        <div class="row">
            <div class="col-sm-8">
                <?php if (isset($videos[0])){ ?>
                    <div class="news-first-item">
                        <div class="video-first">
                            <?=$videos[0]->content ?>
                        </div>
                        <a href="/video/<?=$videos[0]->slug ?>">
                            <div class="news-first-item-info">
                                <h4>
                                    <strong class="f-title">
                                        <?=$videos[0]->title ?>
                                    </strong>
                                </h4>
                                <div>
                                    <?=$videos[0]->description ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
            <div class="col-sm-4 news-ex-item">
                <?php if (isset($videos[1])){ ?>
                    <div class="news-item">
                        <div class="embed-responsive embed-responsive-16by9 video-icon">
                            <a href="/video/<?=$videos[1]->slug ?>">
                                <img src="<?= HOST.$videos[1]->logo ?>">
                            </a>
                        </div>
                        <a href="/video/<?=$videos[1]->slug ?>">
                            <h5>
                                <strong class="f-title">
                                    <?=$videos[1]->title ?>
                                </strong>
                            </h5>
                        </a>
                    </div>
                <?php } ?>
                <?php if (isset($videos[2])){ ?>
                    <div class="news-item">
                        <div class="embed-responsive embed-responsive-16by9 video-icon">
                            <a href="/video/<?=$videos[2]->slug ?>">
                                <img src="<?= HOST.$videos[2]->logo ?>">
                            </a>
                        </div>
                        <a href="/video/<?=$videos[2]->slug ?>">
                            <h5>
                                <strong class="f-title">
                                    <?=$videos[2]->title ?>
                                </strong>
                            </h5>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <?php if (isset($ads[21])){ ?>
        <?php
        $this->registerJs("
        $('#slide-ads" . $ads[21]->id . "').carousel({
        interval: " . $ads[21]->time_swap * 1000 . "
    });
    ");
        ?>
        <div id="slide-ads<?= $ads[21]->id ?>" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                <?php if ($ads[21]->type == ADS_TYPE_BANNER) { ?>
                    <?php foreach ($ads[21]->images as $k => $ai) { ?>
                        <?php if ($ai) {
                            ?>
                            <div class="item <?= ($k == 0) ? "active" : ""; ?>">
                                <a <?php if ($ads[21]->url){ ?>href="<?= $ads[21]->url ?>"<?php } ?> class="ads-custom"
                                   target="_blank">
                                    <img src="<?= HOST. $ai ?>">
                                </a>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } else { ?>
                    <?php foreach ($ads[21]->htmls as $l => $ah) { ?>
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
    <section id="group-news-1">
        <div class="row video-list" id="list_items">
            <input type="hidden" id="anchor_index" value="0">
            <input type="hidden" id="is_next" value="<?=$is_next ?>">
            <?php foreach($videos as $k => $v){ ?>
                <?php if ($k >= 3){ ?>
                    <div class="col-sm-4">
                        <div class="news-item">
                            <div class="embed-responsive embed-responsive-16by9 video-icon">
                                <a href="/video/<?=$v->slug ?>">
                                    <img src="<?= HOST.$v->logo ?>">
                                </a>
                            </div>
                            <a href="/video/<?=$v->slug ?>">
                                <h5>
                                    <strong class="f-title">
                                        <?=$v->title ?>
                                    </strong>
                                </h5>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
<!--        --><?php //if ($is_next == 1){ ?>
<!--            <a class="text-center btn-more" id="loading-layer" onclick="show_more_video();">Xem thêm</a>-->
<!--        --><?php //} ?>
    </section>
</div>
<div class="right-block">
    <?php if (count($ads) > 1){ ?>
        <?php foreach($ads as $k => $a){?>
            <?php if ($k > 21){ ?>
                <?php
                $this->registerJs("
        $('#slide-ads" . $a->id . "').carousel({
        interval: " . $a->time_swap * 1000 . "
    });
    ");
                ?>
                <div id="slide-ads<?= $a->id ?>" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <?php if ($a->type == ADS_TYPE_BANNER) { ?>
                            <?php foreach ($a->images as $k => $ai) { ?>
                                <?php if ($ai) {
                                    ?>
                                    <div class="item <?= ($k == 0) ? "active" : ""; ?>">
                                        <a <?php if ($a->url){ ?>href="<?= $a->url ?>"<?php } ?> class="ads"
                                           target="_blank">
                                            <img src="<?= HOST. $ai ?>">
                                        </a>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        <?php } else { ?>
                            <?php foreach ($a->htmls as $l => $ah) { ?>
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
        <?php } ?>
    <?php } ?>
</div>
<hr>
<div class="clearfix"></div>
<div class="row" id="page">
    <div class="left-block">
        <section id="group-news-5">
            <div id="list_items">

            </div>
        </section>
    </div>
</div>
</div>
