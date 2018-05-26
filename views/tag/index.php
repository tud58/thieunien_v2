<?php
use yii\helpers\Html;
use app\helper\Functions;
$this->title = $tag->name;
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("infinity('category');", \yii\web\View::POS_END, 'my-options');
?>
<div class="container">
<div class="left-block">
    <section id="group-news-0-1">
        <p style="margin-top: 10px">
            <a class="border-gradiant-round border-radius-12">#<?=$tag->name ?><span class="text-gradiant">#<?=$tag->name ?></php></span></a>
        </p>
        <div class="row">
            <div class="col-sm-8">
                <?php if (isset($news[0])){ ?>
                    <div class="news-first-item">
                        <a href="/tin-tuc/<?=$news[0]->slug ?>">
                            <img src="<?= HOST.$news[0]->logo ?>" alt="...">
                            <div class="news-first-item-info">
                                <h4>
                                    <strong class="f-title">
                                        <?=$news[0]->title . Functions::getNewsIcon($news[0]->type) ?>
                                    </strong>
                                </h4>
                                <div class="f-description">
                                    <?=$news[0]->description ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
            <div class="col-sm-4 news-ex-item">
                <?php if (isset($news[1])){ ?>
                    <div class="news-item">
                        <a href="/tin-tuc/<?=$news[1]->slug ?>">
                            <img src="<?= HOST.$news[1]->logo ?>">
                            <h5>
                                <strong class="f-title">
                                    <?=$news[1]->title . Functions::getNewsIcon($news[1]->type) ?>
                                </strong>
                            </h5>
                        </a>
                    </div>
                <?php } ?>
                <?php if (isset($news[2])){ ?>
                    <div class="news-item">
                        <a href="/tin-tuc/<?=$news[2]->slug ?>">
                            <img src="<?= HOST.$news[2]->logo ?>">
                            <h5>
                                <strong class="f-title">
                                    <?=$news[2]->title . Functions::getNewsIcon($news[2]->type) ?>
                                </strong>
                            </h5>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php if (count($news) > 3){ ?>
        <a class="border-gradiant-round border-radius-12 text-uppercase">Đọc thêm<span class="text-gradiant">Đọc thêm</span></a>
        <div id="group-news-slide-1" class="owl-carousel home">
            <?php foreach($news as $k => $n){ ?>
                <?php if ($k < 10 && $k >= 3){ ?>
                    <div class="item">
                        <div class="embed-responsive embed-responsive-16by9">
                            <a href="/tin-tuc/<?=$n->slug ?>">
                                <img src="<?= HOST.$n->logo ?>">
                            </a>
                        </div>
                        <a href="/tin-tuc/<?=$n->slug ?>">
                            <h5>
                                <strong class="f-title">
                                    <?=$n->title . Functions::getNewsIcon($n->type)?>
                                </strong>
                            </h5>
                        </a>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <?php } ?>
    </section>
    <hr>
    <section id="group-news-5">
        <?php foreach($news as $k => $n){ ?>
            <?php if ($k >= 10 && $k < 15){ ?>
                <div class="news-item">
                    <div class="col-md-4">
                        <a href="/tin-tuc/<?=$n->slug ?>">
                            <img src="<?= HOST.$n->logo ?>" alt="...">
                        </a>
                    </div>
                    <div class="col-md-8">
                        <span class="news-detail-time"><i class="fa fa-clock-o" aria-hidden="true"></i> <?=date('d-m-Y H:i:s', $n->publish_time); ?></span>
                        <h5>
                            <a href="/tin-tuc/<?=$n->slug ?>">
                                <strong class="f-title">
                                    <?=$n->title . Functions::getNewsIcon($n->type) ?>
                                </strong>
                            </a>
                        </h5>
                        <div class="text-justify f-description">
                            <?=$n->description ?>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <hr>
            <?php } ?>
        <?php } ?>
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
<!--    <div class="row">-->
<!--        --><?php //if ($events){ ?>
<!--            <div class="col-sm-6 group-news-6">-->
<!--                <a class="border-gradiant-round border-radius-12 text-uppercase other-news">Dòng sự kiện<span class="text-gradiant">Dòng sự kiện</span></a>-->
<!--                <ul class="list-unstyled events">-->
<!--                    --><?php //foreach($events as $k => $e){ ?>
<!--                        <li>-->
<!--                            <a href="/su-kien/--><?//=$e->slug ?><!--">-->
<!--                                <strong>-->
<!--                                    <i class="fa fa-circle" aria-hidden="true"></i>--><?//=$e->name ?>
<!--                                </strong>-->
<!--                            </a>-->
<!--                        </li>-->
<!--                    --><?php //} ?>
<!--                </ul>-->
<!--            </div>-->
<!--        --><?php //} ?>
<!--        --><?php //if ($newsPopular){ ?>
<!--            <div class="col-sm-6 group-news-6">-->
<!--                <a href="#" class="border-gradiant-round border-radius-12 text-uppercase">Bạn quan tâm<span class="text-gradiant">Bạn quan tâm</span></a>-->
<!--                <ul class="list-unstyled news-popular">-->
<!--                    --><?php //foreach($newsPopular as $k => $n){ ?>
<!--                        <li>-->
<!--                            <a href="/tin-tuc/--><?//=$n->slug ?><!--">-->
<!--                                <strong class="f-title">-->
<!--                                    <i class="fa fa-circle" aria-hidden="true"></i>--><?//=$n->title . Functions::getNewsIcon($n->type) ?>
<!--                                </strong>-->
<!--                            </a>-->
<!--                        </li>-->
<!--                    --><?php //} ?>
<!--                </ul>-->
<!--            </div>-->
<!--        --><?php //} ?>
<!--    </div>-->
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
<?php if (isset($videos) && $videos){ ?>
    <section id="video-block">
        <h3 class="text-uppercase"><i class="fa fa-film" aria-hidden="true"></i><strong class="text-gradiant"> Video nổi bật</strong></h3>
        <div class="row">
            <?php foreach($videos as $k => $v){ ?>
                <?php if ($k < 3 && $k >= 0){ ?>
                    <div class="col-sm-4">
                        <div class="embed-responsive embed-responsive-16by9 video-icon">
                            <a href="/video/<?=$v->slug ?>">
                                <img src="<?= HOST.$v->logo ?>">
                            </a>
                        </div>
                        <a href="/video/<?=$v->slug ?>">
                            <strong class="f-title">
                                <?=$v->title . Functions::getNewsIcon($v->type) ?>
                            </strong>
                        </a>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="owl-carousel video">
            <?php foreach($videos as $k => $v){ ?>
                <?php if ($k >= 3){ ?>
                    <div class="video-slide-item">
                        <div class="embed-responsive embed-responsive-16by9 video-icon">
                            <a href="/video/<?=$v->slug ?>">
                                <img src="<?= HOST.$v->logo ?>">
                            </a>
                        </div>
                        <a href="/video/<?=$v->slug ?>">
                            <strong class="f-title">
                                <?=$v->title . Functions::getNewsIcon($v->type) ?>
                            </strong>
                        </a>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </section>
    <hr>
<?php } ?>
<div class="" id="page">
    <div class="left-block">
        <section id="group-news-5">
            <div id="list_items">
                <input type="hidden" id="anchor_index" value="0">
                <input type="hidden" id="is_next" value="<?=$is_next ?>">
                <input type="hidden" id="tag_id" value="<?=$tag->id ?>">
                <?php foreach($news as $k => $n){ ?>
                    <?php if ($k >= 15){ ?>
                        <div class="news-item">
                            <div class="col-md-4">
                                <a href="/tin-tuc/<?=$n->slug ?>">
                                    <img src="<?= HOST.$n->logo ?>" alt="...">
                                </a>
                            </div>
                            <div class="col-md-8">
                                <span class="news-detail-time"><i class="fa fa-clock-o" aria-hidden="true"></i> <?=date('d-m-Y H:i:s', $n->publish_time); ?></span>
                                <h5>
                                    <a href="/tin-tuc/<?=$n->slug ?>">
                                        <strong class="f-title">
                                            <?=$n->title . Functions::getNewsIcon($n->type) ?>
                                        </strong>
                                    </a>
                                </h5>
                                <div class="text-justify f-description">
                                    <?=$n->description ?>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                    <?php } ?>
                <?php } ?>
            </div>
        </section>
<!--        --><?php //if ($is_next == 1){ ?>
<!--            <a class="text-center btn-more" id="loading-layer" onclick="show_more_news();">Xem thêm</a>-->
<!--        --><?php //} ?>
    </div>
</div>
</div>
