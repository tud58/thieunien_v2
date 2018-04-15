<?php
use yii\helpers\Html;
use app\helper\Functions;
$this->title = $category->name;
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("infinity('category');", \yii\web\View::POS_END, 'my-options');
/* if($category->id == 34){
	echo '@@';
	var_dump($news);
} */

?>
<div class="container">
    <div class="left-block">
        <section id="group-news-0-1" class="categories">
            <h3 class="text-uppercase">
                <span class="category-parent"><strong> <?= $category->name ?></strong></span>
                <?php foreach($categoryChilds as $k => $c){ ?>
                    <a href="/danh-muc/<?=$category['slug'] ?>/<?=$c['slug'] ?>">
                        <span class="category-child <?=(isset($categoryChild->id) && $c->id == $categoryChild->id) ? 'active' : '' ?> <?=($k == 0) ? 'bn' : '' ?>"><?= $c->name ?></span>
                    </a>
                <?php } ?>
            </h3>
            <div class="row">
                <div class="col-sm-8">
                    <?php if (isset($news[0])){ ?>
                        <div class="news-first-item">
                            <a href="/tin-tuc/<?=$news[0]->slug ?>">
                                <img src="<?=$news[0]->logo ?>" alt="...">
                            </a>
                            <div class="news-first-item-info">
                                <h4>
                                    <a href="/tin-tuc/<?=$news[0]->slug ?>">
                                    <strong class="f-title">
                                        <?=$news[0]->title  ?>
                                    </strong>
                                    </a>
                                </h4>
                                <div class="f-description">
                                    <?=$news[0]->description ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-sm-4 news-ex-item">
                    <?php if (isset($news[1])){ ?>
                        <div class="news-item">
                            <a href="/tin-tuc/<?=$news[1]->slug ?>">
                                <img src="<?=$news[1]->logo ?>">
                                <h5>
                                    <strong class="f-title">
                                        <?=$news[1]->title ?>
                                    </strong>
                                </h5>
                            </a>
                        </div>
                    <?php } ?>
                    <?php if (isset($news[2])){ ?>
                        <div class="news-item">
                            <a href="/tin-tuc/<?=$news[2]->slug ?>">
                                <img src="<?=$news[2]->logo ?>">
                                <h5>
                                    <strong class="f-title">
                                        <?=$news[2]->title ?>
                                    </strong>
                                </h5>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php if (count($news) > 3){ ?>
<!--            <a class="border-gradiant-round border-radius-12 text-uppercase other-news" href="#">Đọc thêm<span class="text-gradiant">Đọc thêm</span></a>-->
            <div id="group-news-slide-1" class="owl-carousel category">
                <?php foreach($news as $k => $n){ ?>
                    <?php if ($k < 10 && $k >= 3){ ?>
                        <div class="item">
                            <div class="">
                                <a href="/tin-tuc/<?=$n->slug ?>">
                                    <img src="<?=$n->logo ?>">
                                </a>
                            </div>
                            <a href="/tin-tuc/<?=$n->slug ?>">
                                <h5>
                                    <strong class="f-title">
                                        <?=$n->title?>
                                    </strong>
                                </h5>
                            </a>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
            <?php } ?>
        </section>
        <hr class="w2"/>
        <section id="group-news-5">
            <?php foreach($news as $k => $n){ ?>
                <?php if ($k >= 10 && $k < 15){ ?>
                    <div class="news-item">
                        <div class="col-md-4">
                            <a href="/tin-tuc/<?=$n->slug ?>">
                                <img src="<?=$n->logo ?>" alt="...">
                            </a>
                        </div>
                        <div class="col-md-8">
                            <span class="news-detail-time"><i class="fa fa-clock-o" aria-hidden="true"></i> <?=date('d-m-Y H:i:s', $n->publish_time); ?></span>
                            <h5>
                                <a href="/tin-tuc/<?=$n->slug ?>">
                                    <strong class="f-title">
                                        <?=$n->title  ?>
                                    </strong>
                                </a>
                            </h5>
                            <div class="f-description">
                                <?=$n->description ?>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="w2"/>
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
                                        <img src="<?= $ai ?>">
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
        <?php if (isset($dailyNews) && $dailyNews) { ?>
            <div id="hot-news-daily">
                <h3 class="text-uppercase">
                    <img src="/frontend/img/line-chart-icon.png" style="width: 33px">
                    <strong> Nóng trong ngày</strong>
                </h3>
                <!--        <a class="border-gradiant-round border-radius-12 text-uppercase">Bạn đã đọc chưa?<span class="text-gradiant">Bạn đã đọc chưa?</span></a>-->
                <div id="group-news-slide-1" class="owl-carousel daily-hot">
                    <?php foreach ($dailyNews as $k => $n) { ?>
                        <?php if ($k < 10) { ?>
                            <div class="item out-id" data-news-id="<?= $n->id ?>">
                                <div class="">
                                    <a href="/tin-tuc/<?= $n->slug ?>">
                                        <img src="<?= ($n->logo) ? $n->logo : '/frontend/img/news-item.jpg'; ?>">
                                    </a>
                                </div>
                                <a href="/tin-tuc/<?= $n->slug ?>">
                                    <h5>
                                        <strong class="f-title">
                                            <?= $n->title . Functions::getNewsIcon($n->type) ?>
                                        </strong>
                                    </h5>
                                </a>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="scroll" style="z-index: -9999;">
        <div class="scroll-container">
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
                                                        <img src="<?= $ai ?>">
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
        </div>
    </div>
<div class="clearfix"></div>
<div class="" id="page">
    <div class="left-block">
        <section id="group-news-5">
            <?php foreach($news as $k => $n){ ?>
                <?php if ($k >= 15 && $k < 20){ ?>
                    <div class="news-item">
                        <div class="col-md-4">
                            <a href="/tin-tuc/<?=$n->slug ?>">
                                <img src="<?=$n->logo ?>" alt="...">
                            </a>
                        </div>
                        <div class="col-md-8">
                            <span class="news-detail-time"><i class="fa fa-clock-o" aria-hidden="true"></i> <?=date('d-m-Y H:i:s', $n->publish_time); ?></span>
                            <h5>
                                <a href="/tin-tuc/<?=$n->slug ?>">
                                    <strong class="f-title">
                                        <?=$n->title  ?>
                                    </strong>
                                </a>
                            </h5>
                            <div class="f-description">
                                <?=$n->description ?>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="w2"/>
                <?php } ?>
            <?php } ?>
        </section>
        <div class="row">
            <?php if ($lastestNews) { ?>
                <div class="col-sm-<?= ($weeklyNews) ? '6' : '12' ?> group-news-6" id="news-lastest">
                    <h3 class="text-uppercase">
                        <strong class="text-gradiant"> Tin mới nhất</strong>
                    </h3>
                    <a href="/tin-tuc/<?= $lastestNews[0]->slug ?>" class="first" title="<?= strip_tags($lastestNews[0]->title) ?>">
                        <img src="<?= ($lastestNews[0]->logo) ? $lastestNews[0]->logo : '/frontend/img/news-item.jpg'; ?>"
                             alt="<?= strip_tags($lastestNews[0]->title) ?>">
                        <strong>
                            <?= strip_tags($lastestNews[0]->title) . Functions::getNewsIcon($lastestNews[0]->type) ?>
                        </strong>
                    </a>
                    <ul class="list-unstyled events">
                        <?php foreach ($lastestNews as $k => $n) { ?>
                            <?php if ($k > 0) { ?>
                                <li class="out-id" data-news-id="<?= $n->id ?>">
                                    <a href="/tin-tuc/<?= $n->slug ?>" title="<?= strip_tags($n->title) ?>">
                                        <strong>
                                            <?= strip_tags($n->title) . Functions::getNewsIcon($n->type) ?>
                                        </strong>
                                    </a>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
            <?php if ($weeklyNews) { ?>
                <div class="col-sm-<?= ($lastestNews) ? '6' : '12' ?> group-news-6" id="hot-news-weekly">
                    <h3 class="text-uppercase">
                        <strong class="text-gradiant"> Nóng trong tuần</strong>
                    </h3>
                    <a href="/tin-tuc/<?= $weeklyNews[0]->slug ?>" class="first" title="<?= strip_tags($weeklyNews[0]->title) ?>">
                        <img src="<?= ($weeklyNews[0]->logo) ? $weeklyNews[0]->logo : '/frontend/img/news-item.jpg'; ?>"
                             alt="<?= strip_tags($weeklyNews[0]->title) ?>">
                        <strong>
                            <!--                                <i class="fa fa-circle" aria-hidden="true"></i>-->
                            <?= strip_tags($weeklyNews[0]->title) . Functions::getNewsIcon($weeklyNews[0]->type) ?>
                        </strong>
                    </a>
                    <ul class="list-unstyled news-popular">
                        <?php foreach ($weeklyNews as $k => $n) { ?>
                        <?php if ($k > 0) { ?>
                            <li class="out-id" data-news-id="<?= $n->id ?>">
                                <a href="/tin-tuc/<?= $n->slug ?>" title="<?= strip_tags($n->title) ?>">
                                    <strong class="f-title">
                                        <?= strip_tags($n->title) . Functions::getNewsIcon($n->type) ?>
                                    </strong>
                                </a>
                            </li>
                        <?php } ?>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
        <hr class="w2"/>
        <section id="group-news-5">
            <div id="list_items">
                <input type="hidden" id="anchor_index" value="0">
                <input type="hidden" id="is_next" value="<?=$is_next ?>">
                <input type="hidden" id="category_id" value="<?=$category->id ?>">
                <?php foreach($news as $k => $n){ ?>
                    <?php if ($k >= 20){ ?>
                        <div class="news-item">
                            <div class="col-md-4">
                                <a href="/tin-tuc/<?=$n->slug ?>">
                                    <img src="<?=$n->logo ?>" alt="...">
                                </a>
                            </div>
                            <div class="col-md-8">
                                <span class="news-detail-time"><i class="fa fa-clock-o" aria-hidden="true"></i> <?=date('d-m-Y H:i:s', $n->publish_time); ?></span>
                                <h5>
                                    <a href="/tin-tuc/<?=$n->slug ?>">
                                        <strong class="f-title">
                                            <?=$n->title  ?>
                                        </strong>
                                    </a>
                                </h5>
                                <div class="f-description">
                                    <?=$n->description ?>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr class="w2"/>
                    <?php } ?>
                <?php } ?>
            </div>
        </section>

    </div>
</div>
</div>