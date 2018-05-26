<?php
use app\helper\Functions;

$this->title = 'Thiếu niên';
//var_dump($this->params['categoryChild']);die;
?>
<div class="container">
<?php if ($categoryHot && $newsHot) { ?>
    <div id="news-hot-event">
        <?php if ($categoryHot->cover) { ?>
            <div class="text-center">
                <img src="<?= HOST. $categoryHot->cover ?>">
            </div>
        <?php } ?>
        <div class="left-block">
            <h3 class="text-uppercase"><strong class="text-gradiant"> Sự kiện nóng</strong></h3>
            <a href="/danh-muc/<?= $categoryHot->slug ?>"
               class="border-gradiant-round border-radius-12 event-tag"><?= $categoryHot->name ?><span
                    class="text-gradiant"><?= $categoryHot->name ?></span></a>

            <div class="row">
                <div class="col-sm-8">
                    <div class="news-first-item">
                        <?php if (isset($newsHot[0])) { ?>
                            <a href="/tin-tuc/<?= $newsHot[0]->slug ?>">
                                <img src="<?= HOST. $newsHot[0]->logo ?>" alt="...">
                            </a>
                            <div class="news-first-item-info">
                                <h4>
                                    <a href="/tin-tuc/<?= $newsHot[0]->slug ?>">
                                        <strong class="f-title">
                                            <?= $newsHot[0]->title . Functions::getNewsIcon($newsHot[0]->type) ?>
                                        </strong>
                                    </a>
                                </h4>

                                <div class="f-description">
                                    <?= $newsHot[0]->description ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-sm-4 news-ex-item">
                    <?php foreach ($newsHot as $k => $n) { ?>
                        <?php if ($k <= 2 && $k > 0) { ?>
                            <div class="news-item">
                                <a href="/tin-tuc/<?= $n->slug ?>">
                                    <img src="<?= HOST. $n->logo ?>">
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
            <hr>
            <div class="group-news-5">
                <?php foreach ($newsHot as $k => $n) { ?>
                    <?php if ($k <= 5 && $k > 2) { ?>
                        <div class="news-item">
                            <a href="/tin-tuc/<?= $n->slug ?>">
                                <div class="col-md-4">
                                    <img src="<?= HOST. $n->logo ?>" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <span><i class="fa fa-clock-o"
                                             aria-hidden="true"></i> <?= date('d-m-Y H:i:s', $n->publish_time); ?></span>
                                    <h5>
                                        <strong class="f-title">
                                            <?= $n->title . Functions::getNewsIcon($n->type) ?>
                                        </strong>
                                    </h5>

                                    <div class="f-description">
                                        <?= $n->description ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php if ($k < 5) { ?>
                            <hr>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <div class="right-block">
            <?php if ($videosHot) { ?>
                <div class="news-hot-video-event">
                    <h3 class="text-uppercase"><strong class="text-gradiant">Video</strong></h3>
                    <a href="/danh-muc/<?= $categoryHot->slug ?>"
                       class="border-gradiant-round border-radius-12 event-tag"><?= $categoryHot->name ?><span
                            class="text-gradiant"><?= $categoryHot->name ?></span></a>
                    <!-- Nav tabs -->
                    <ul class="list-unstyled text-uppercase tabs-header" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#hot-read" aria-controls="hot-read" role="tab" data-toggle="tab"
                               class="border-gradiant-round border-radius-12">
                                Xem nhiều<span class="text-gradiant">Xem nhiều</span>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#hot-new" aria-controls="hot-new" role="tab" data-toggle="tab">
                                Mới nhất<span class="text-gradiant" style="display: none">Mới nhất</span>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#hot-comment" aria-controls="hot-comment" role="tab" data-toggle="tab">
                                Top Bình luận<span class="text-gradiant" style="display: none">Top Bình luận</span>
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="hot-read">
                            <ul class="list-unstyled right-news-list">
                                <?php foreach ($videosHotView as $k => $n) { ?>
                                    <li>
                                        <a href="/tin-tuc/<?= $n->slug ?>">
                                            <img src="<?= HOST. $n->logo ?>">
                                            <strong class="f-title">
                                                <?= $n->title . Functions::getNewsIcon($n->type) ?>
                                            </strong>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="hot-new">
                            <ul class="list-unstyled right-news-list">
                                <?php foreach ($videosHot as $k => $n) { ?>
                                    <li>
                                        <a href="/tin-tuc/<?= $n->slug ?>">
                                            <img src="<?= HOST. $n->logo ?>">
                                            <strong class="f-title">
                                                <?= $n->title . Functions::getNewsIcon($n->type) ?>
                                            </strong>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="hot-comment">
                            <ul class="list-unstyled right-news-list">
                                <?php foreach ($videosHotComment as $k => $n) { ?>
                                    <li>
                                        <a href="/tin-tuc/<?= $n->slug ?>">
                                            <img src="<?= HOST. $n->logo ?>">
                                            <strong class="f-title">
                                                <?= $n->title . Functions::getNewsIcon($n->type) ?>
                                            </strong>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <?php if (isset($ads[2])) { ?>
                    <?php
                    $this->registerJs("
        $('#slide-ads" . $ads[2]->id . "').carousel({
        interval: " . $ads[2]->time_swap * 1000 . "
    });
    ");
                    ?>
                    <div id="slide-ads<?= $ads[2]->id ?>" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <?php if ($ads[2]->type == ADS_TYPE_BANNER) { ?>
                                <?php foreach ($ads[2]->images as $k => $ai) { ?>
                                    <?php if ($ai) {
                                        ?>
                                        <div class="item <?= ($k == 0) ? "active" : ""; ?>">
                                            <a <?php if ($ads[2]->url){ ?>href="<?= $ads[2]->url ?>"<?php } ?>
                                               target="_blank">
                                                <img src="<?= HOST. $ai ?>">
                                            </a>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            <?php } else { ?>
                                <?php foreach ($ads[2]->htmls as $l => $ah) { ?>
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
        </div>
        <div class="clearfix"></div>
    </div>
    <hr>
<?php } ?>
<?php if (isset($ads[1])) { ?>
    <?php
    $this->registerJs("
        $('#slide-ads" . $ads[1]->id . "').carousel({
        interval: " . $ads[1]->time_swap * 1000 . "
    });
    ");
    ?>
    <div id="slide-ads<?= $ads[1]->id ?>" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <?php if ($ads[1]->type == ADS_TYPE_BANNER) { ?>
                <?php foreach ($ads[1]->images as $k => $ai) { ?>
                    <?php if ($ai) {
                        ?>
                        <div class="item <?= ($k == 0) ? "active" : ""; ?>">
                            <a <?php if ($ads[1]->url){ ?>href="<?= $ads[1]->url ?>"<?php } ?> class="ads-custom"
                               target="_blank">
                                <img src="<?= HOST. $ai ?>">
                            </a>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                <?php foreach ($ads[1]->htmls as $l => $ah) { ?>
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

<div class="left-block">
<?php if (isset($lefts[0]) && $lefts[0]->news) { ?>
    <section id="focus-day">
        <h3 class="text-uppercase df">
            <a href="/danh-muc/<?= $lefts[0]['slug'] ?>">
                <span class="category-parent"><strong> <?= $lefts[0]->name ?></strong></span>
            </a>
            <?php if (isset($this->params['categoryChild'][$lefts[0]->id])) { ?>
                <?php foreach ($this->params['categoryChild'][$lefts[0]->id] as $k => $c) { ?>
                    <a href="/danh-muc/<?=$lefts[0]->slug ?>/<?=$c['slug'] ?>">
                        <span class="category-child <?=($k == 0) ? 'bn' : '' ?>"><?= $c['name'] ?></span>
                    </a>
                <?php } ?>
            <?php } ?>
        </h3>

        <div class="row">
            <div class="col-sm-8">
                <div id="carousel-home" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators carousel-indicators-numbers">
                        <?php if (count($lefts[0]->news) >= 7) { ?>
                            <?php foreach ($lefts[0]->news as $k => $n) { ?>
                                <?php if ($k < 5) { ?>
                                    <li data-target="#carousel-home" data-slide-to="<?= $k ?>"
                                        class="<?php if ($k == 0) echo 'active'; ?>"></li>
                                <?php } ?>
                            <?php } ?>
                        <?php } elseif (count($lefts[0]->news) < 7 && count($lefts[0]->news) >= 4) { ?>
                            <?php foreach ($lefts[0]->news as $k => $n) { ?>
                                <?php if ($k < (count($lefts[0]->news) - 2)) { ?>
                                    <li data-target="#carousel-home" data-slide-to="<?= $k ?>"
                                        class="<?php if ($k == 0) echo 'active'; ?>"><a><?= $k + 1 ?></a></li>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <?php if (count($lefts[0]->news) >= 7) { ?>
                            <?php foreach ($lefts[0]->news as $k => $n) { ?>
                                <?php if ($k < 5) { ?>
                                    <div class="item <?php if ($k == 0) echo 'active'; ?>">
                                        <div class="slider-img">
                                            <a href="/tin-tuc/<?= $n->slug ?>">
                                                <div style="background-image: url('<?= HOST.$n->logo ?>')">
                                                </div>
                                            </a>
                                        </div>
                                        <div class="carousel-caption">
                                            <h4>
                                                <a href="/tin-tuc/<?= $n->slug ?>">
                                                    <strong class="f-title">
                                                        <?= $n->title . Functions::getNewsIcon($n->type) ?>
                                                    </strong>
                                                </a>
                                            </h4>

                                            <div class="f-description">
                                                <?= $n->description ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        <?php } elseif (count($lefts[0]->news) < 7 && count($lefts[0]->news) >= 4) { ?>
                            <?php foreach ($lefts[0]->news as $k => $n) { ?>
                                <?php if ($k < (count($lefts[0]->news) - 2)) { ?>
                                    <div class="item <?php if ($k == 0) echo 'active'; ?>">
                                        <div class="slider-img">
                                            <a href="/tin-tuc/<?= $n->slug ?>">
                                                <div style="background-image: url('<?= $n->logo ?>')">
                                                </div>
                                            </a>
                                        </div>
                                        <div class="carousel-caption">
                                            <h4>
                                                <a href="/tin-tuc/<?= $n->slug ?>">
                                                    <strong class="f-title">
                                                        <?= $n->title . Functions::getNewsIcon($n->type) ?>
                                                    </strong>
                                                </a>
                                            </h4>

                                            <div class="f-description">
                                                <?= $n->description ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        <?php } else { ?>
                            <?php if (isset($lefts[0]->news[0])) { ?>
                                <div class="item active">
                                    <div class="slider-img">
                                        <a href="/tin-tuc/<?= $lefts[0]->news[0]->slug ?>">
                                            <img src="<?= HOST. $lefts[0]->news[0]->logo ?>" alt="...">
                                        </a>
                                    </div>
                                    <div class="carousel-caption">
                                        <h4>
                                            <a href="/tin-tuc/<?= $lefts[0]->news[0]->slug ?>">
                                                <strong class="f-title">
                                                    <?= $lefts[0]->news[0]->title . Functions::getNewsIcon($lefts[0]->news[0]->type) ?>
                                                </strong>
                                            </a>
                                        </h4>

                                        <div class="f-description">
                                            <?= $lefts[0]->news[0]->description ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 news-ex-item">
                <?php if (count($lefts[0]->news) >= 7) { ?>
                    <div class="news-item">
                        <a href="/tin-tuc/<?= $lefts[0]->news[5]->slug ?>">
                            <img src="<?= HOST. $lefts[0]->news[5]->logo ?>">
                            <h5>
                                <strong class="f-title">
                                    <?= $lefts[0]->news[5]->title . Functions::getNewsIcon($lefts[0]->news[5]->type) ?>
                                </strong>
                            </h5>
                        </a>
                    </div>
                    <div class="news-item">
                        <a href="/tin-tuc/<?= $lefts[0]->news[6]->slug ?>">
                            <img src="<?= HOST. $lefts[0]->news[6]->logo ?>">
                            <h5>
                                <strong class="f-title">
                                    <?= $lefts[0]->news[6]->title . Functions::getNewsIcon($lefts[0]->news[6]->type) ?>
                                </strong>
                            </h5>
                        </a>
                    </div>
                <?php } elseif (count($lefts[0]->news) < 7 && count($lefts[0]->news) >= 4) { ?>
                    <?php foreach ($lefts[0]->news as $k => $n) { ?>
                        <?php if ($k >= (count($lefts[0]->news) - 2)) { ?>
                            <div class="news-item">
                                <a href="/tin-tuc/<?= $n->slug ?>">
                                    <img src="<?= HOST. $n->logo ?>">
                                    <h5>
                                        <strong class="f-title">
                                            <?= $n->title . Functions::getNewsIcon($n->type) ?>
                                        </strong>
                                    </h5>
                                </a>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } else { ?>
                    <?php if (isset($lefts[0]->news[1])) { ?>
                        <div class="news-item">
                            <a href="/tin-tuc/<?= $lefts[0]->news[1]->slug ?>">
                                <img src="<?= HOST. $lefts[0]->news[1]->logo ?>">
                                <h5>
                                    <strong class="f-title">
                                        <?= $lefts[0]->news[1]->title . Functions::getNewsIcon($lefts[0]->news[1]->type) ?>
                                    </strong>
                                </h5>
                            </a>
                        </div>
                    <?php } ?>
                    <?php if (isset($lefts[0]->news[2])) { ?>
                        <div class="news-item">
                            <a href="/tin-tuc/<?= $lefts[0]->news[2]->slug ?>">
                                <img src="<?= HOST. $lefts[0]->news[2]->logo ?>">
                                <h5>
                                    <strong class="f-title">
                                        <?= $lefts[0]->news[2]->title . Functions::getNewsIcon($lefts[0]->news[2]->type) ?>
                                    </strong>
                                </h5>
                            </a>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </section>
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
                        <div class="item">
                            <div class="">
                                <a href="/tin-tuc/<?= $n->slug ?>">
                                    <img src="<?= HOST. ($n->logo) ? $n->logo : '/frontend/img/news-item.jpg'; ?>">
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
<!--    <hr class="w2"/>-->
<?php } ?>
<?php if (isset($ads[3])) { ?>
    <?php
    $this->registerJs("
        $('#slide-ads" . $ads[3]->id . "').carousel({
        interval: " . $ads[3]->time_swap * 1000 . "
    });
    ");
    ?>
    <div id="slide-ads<?= $ads[3]->id ?>" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <?php if ($ads[3]->type == ADS_TYPE_BANNER) { ?>
                <?php foreach ($ads[3]->images as $k => $ai) { ?>
                    <?php if ($ai) {
                        ?>
                        <div class="item <?= ($k == 0) ? "active" : ""; ?>">
                            <a <?php if ($ads[3]->url){ ?>href="<?= $ads[2]->url ?>"<?php } ?> class="ads-right-1"
                               target="_blank">
                                <img src="<?= HOST. $ai ?>">
                            </a>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                <?php foreach ($ads[3]->htmls as $l => $ah) { ?>
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
<?php if (isset($lefts[1]) && $lefts[1]->news) { ?>
    <section id="group-news-0-1">
        <h3 class="text-uppercase df">
            <a href="/danh-muc/<?= $lefts[1]['slug'] ?>">
                <span class="category-parent"><strong> <?= $lefts[1]->name ?></strong></span>
            </a>
            <?php if (isset($this->params['categoryChild'][$lefts[1]->id])) { ?>
                <?php foreach ($this->params['categoryChild'][$lefts[1]->id] as $k => $c) { ?>
                    <a href="/danh-muc/<?=$lefts[1]->slug ?>/<?=$c['slug'] ?>">
                        <span class="category-child <?=($k == 0) ? 'bn' : '' ?>"><?= $c['name'] ?></span>
                    </a>
                <?php } ?>
            <?php } ?>
        </h3>

        <div class="row">
            <div class="col-sm-8">
                <?php if (isset($lefts[1]->news[0])) { ?>
                    <div class="news-first-item">
                        <a href="/tin-tuc/<?= $lefts[1]->news[0]->slug ?>">
                            <img src="<?= HOST. $lefts[1]->news[0]->logo ?>" alt="...">
                        </a>

                        <div class="news-first-item-info">
                            <h4>
                                <a href="/tin-tuc/<?= $lefts[1]->news[0]->slug ?>">
                                    <strong class="f-title">
                                        <?= $lefts[1]->news[0]->title . Functions::getNewsIcon($lefts[1]->news[0]->type) ?>
                                    </strong>
                                </a>
                            </h4>

                            <div class="f-description">
                                <?= $lefts[1]->news[0]->description ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-sm-4 news-ex-item">
                <?php if (isset($lefts[1]['news'][1])) { ?>
                    <div class="news-item">
                        <a href="/tin-tuc/<?= $lefts[1]->news[1]->slug ?>">
                            <img src="<?= HOST. $lefts[1]->news[1]->logo ?>" alt="...">
                            <h5>
                                <strong class="f-title">
                                    <?= $lefts[1]->news[1]->title . Functions::getNewsIcon($lefts[1]->news[1]->type) ?>
                                </strong>
                            </h5>
                        </a>
                    </div>
                <?php } ?>
                <?php if (isset($lefts[1]['news'][2])) { ?>
                    <div class="news-item">
                        <a href="/tin-tuc/<?= $lefts[1]->news[2]->slug ?>">
                            <img src="<?= HOST. $lefts[1]->news[2]->logo ?>" alt="...">
                            <h5>
                                <strong class="f-title">
                                    <?= $lefts[1]->news[2]->title . Functions::getNewsIcon($lefts[1]->news[2]->type) ?>
                                </strong>
                            </h5>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php if (count($lefts[1]->news) > 3) { ?>
            <div id="group-news-slide-1" class="owl-carousel home">

                <?php foreach ($lefts[1]->news as $k => $n) { ?>
                    <?php if ($k > 2 && $k <= 16) { ?>
                        <div class="item">
                            <div class="">
                                <a href="/tin-tuc/<?= $n->slug ?>">
                                    <img src="<?= HOST. $n->logo ?>">
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
        <?php } ?>
    </section>
    <hr class="w2 m10"/>
<?php } ?>

<?php if (isset($lefts[2]) && $lefts[2]->news) { ?>
    <section id="group-news-0-2">
        <h3 class="text-uppercase df">
            <a href="/danh-muc/<?= $lefts[2]['slug'] ?>">
              <span class="category-parent"><strong> <?= $lefts[2]->name ?></strong></span>
            </a>
            <?php if (isset($this->params['categoryChild'][$lefts[2]->id])) { ?>
                <?php foreach ($this->params['categoryChild'][$lefts[2]->id] as $k => $c) { ?>
                    <a href="/danh-muc/<?=$lefts[2]->slug ?>/<?=$c['slug'] ?>">
                        <span class="category-child <?=($k == 0) ? 'bn' : '' ?>"><?= $c['name'] ?></span>
                    </a>
                <?php } ?>
            <?php } ?>
        </h3>

        <div class="row">
            <div class="col-sm-8">
                <?php if (isset($lefts[2]->news[0])) { ?>
                    <div class="news-first-item">
                        <a href="/tin-tuc/<?= $lefts[2]->news[0]->slug ?>">
                            <img src="<?= HOST. $lefts[2]->news[0]->logo ?>" alt="...">
                        </a>

                        <div class="news-first-item-info">
                            <h4>
                                <a href="/tin-tuc/<?= $lefts[2]->news[0]->slug ?>">
                                    <strong class="f-title">
                                        <?= $lefts[2]->news[0]->title . Functions::getNewsIcon($lefts[2]->news[0]->type) ?>
                                    </strong>
                                </a>
                            </h4>

                            <div class="f-description">
                                <?= $lefts[2]->news[0]->description ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-sm-4 news-ex-item">
                <?php if (isset($lefts[2]['news'][1])) { ?>
                    <div class="news-item">
                        <a href="/tin-tuc/<?= $lefts[2]->news[1]->slug ?>">
                            <img src="<?= HOST. $lefts[2]->news[1]->logo ?>" alt="...">
                            <h5>
                                <strong class="f-title">
                                    <?= $lefts[2]->news[1]->title . Functions::getNewsIcon($lefts[2]->news[1]->type) ?>
                                </strong>
                            </h5>
                        </a>
                    </div>
                <?php } ?>
                <?php if (isset($lefts[2]['news'][2])) { ?>
                    <div class="news-item">
                        <a href="/tin-tuc/<?= $lefts[2]->news[2]->slug ?>">
                            <img src="<?= HOST. $lefts[2]->news[2]->logo ?>" alt="...">
                            <h5>
                                <strong class="f-title">
                                    <?= $lefts[2]->news[2]->title . Functions::getNewsIcon($lefts[2]->news[2]->type) ?>
                                </strong>
                            </h5>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php if (count($lefts[2]->news) > 3) { ?>
            <div id="group-news-slide-2" class="owl-carousel home">
                <?php foreach ($lefts[2]->news as $k => $n) { ?>
                    <?php if ($k > 2) { ?>
                        <div class="item">
                            <div class="">
                                <a href="/tin-tuc/<?= $n->slug ?>">
                                    <img src="<?= HOST. $n->logo ?>">
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
        <?php } ?>
    </section>
    <hr class="w2 m10"/>
<?php } ?>

<?php if (isset($lefts[3]) && $lefts[3]->news) { ?>
    <section id="group-news-0-2">
        <h3 class="text-uppercase df">
            <a href="/danh-muc/<?= $lefts[3]['slug'] ?>">
                <span class="category-parent"><strong> <?= $lefts[3]->name ?></strong></span>
            </a>
            <?php if (isset($this->params['categoryChild'][$lefts[3]->id])) { ?>
                <?php foreach ($this->params['categoryChild'][$lefts[3]->id] as $k => $c) { ?>
                    <a href="/danh-muc/<?=$lefts[3]->slug ?>/<?=$c['slug'] ?>">
                        <span class="category-child <?=($k == 0) ? 'bn' : '' ?>"><?= $c['name'] ?></span>
                    </a>
                <?php } ?>
            <?php } ?>
        </h3>

        <div class="row">
            <div class="col-sm-8">
                <?php if (isset($lefts[3]->news[0])) { ?>
                    <div class="news-first-item">
                        <a href="/tin-tuc/<?= $lefts[3]->news[0]->slug ?>">
                            <img src="<?= HOST. $lefts[3]->news[0]->logo ?>" alt="...">
                        </a>

                        <div class="news-first-item-info">
                            <h4>
                                <a href="/tin-tuc/<?= $lefts[3]->news[0]->slug ?>">
                                    <strong class="f-title">
                                        <?= $lefts[3]->news[0]->title . Functions::getNewsIcon($lefts[3]->news[0]->type) ?>
                                    </strong>
                                </a>
                            </h4>

                            <div class="f-description">
                                <?= $lefts[3]->news[0]->description ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-sm-4 news-ex-item">
                <?php if (isset($lefts[3]['news'][1])) { ?>
                    <div class="news-item">
                        <a href="/tin-tuc/<?= $lefts[3]->news[1]->slug ?>">
                            <img src="<?= HOST. $lefts[3]->news[1]->logo ?>" alt="...">
                            <h5>
                                <strong class="f-title">
                                    <?= $lefts[3]->news[1]->title . Functions::getNewsIcon($lefts[3]->news[1]->type) ?>
                                </strong>
                            </h5>
                        </a>
                    </div>
                <?php } ?>
                <?php if (isset($lefts[3]['news'][2])) { ?>
                    <div class="news-item">
                        <a href="/tin-tuc/<?= $lefts[3]->news[2]->slug ?>">
                            <img src="<?= HOST. $lefts[3]->news[2]->logo ?>" alt="...">
                            <h5>
                                <strong class="f-title">
                                    <?= $lefts[3]->news[2]->title . Functions::getNewsIcon($lefts[2]->news[2]->type) ?>
                                </strong>
                            </h5>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php if (count($lefts[3]->news) > 3) { ?>
            <div id="group-news-slide-2" class="owl-carousel home">
                <?php foreach ($lefts[3]->news as $k => $n) { ?>
                    <?php if ($k > 2) { ?>
                        <div class="item">
                            <div class="">
                                <a href="/tin-tuc/<?= $n->slug ?>">
                                    <img src="<?= HOST. $n->logo ?>">
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
        <?php } ?>
    </section>
    <hr class="w2 m10"/>
<?php } ?>

<?php if (isset($lefts[4]) && $lefts[4]->news) { ?>
    <section id="group-news-1">
<h3 class="text-uppercase df">
            <a href="/danh-muc/<?= $lefts[4]['slug'] ?>">
                <span class="category-parent"><strong> <?= $lefts[4]->name ?></strong></span>
            </a>
            <?php if (isset($this->params['categoryChild'][$lefts[4]->id])) { ?>
                <?php foreach ($this->params['categoryChild'][$lefts[4]->id] as $k => $c) { ?>
                    <a href="/danh-muc/<?=$lefts[4]->slug ?>/<?=$c['slug'] ?>">
                        <span class="category-child <?=($k == 0) ? 'bn' : '' ?>"><?= $c['name'] ?></span>
                    </a>
                <?php } ?>
            <?php } ?>
        </h3>

        <div class="row">
            <?php foreach ($lefts[4]->news as $k => $n) { ?>
                <?php if ($k < 6) { ?>
                    <div class="col-sm-4">
                        <div class="news-item">
                            <div class="embed-responsive embed-responsive-4by3">
                                <a href="/tin-tuc/<?= $n->slug ?>">
                                    <img src="<?= HOST. $n->logo ?>">
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
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </section>
<?php } ?>
<hr class="w2 m10"/>
<?php if (isset($lefts[5]) && $lefts[5]->news) { ?>
    <section id="group-news-0-2">
        <h3 class="text-uppercase df">
            <a href="/danh-muc/<?= $lefts[5]['slug'] ?>">
                <span class="category-parent"><strong> <?= $lefts[5]->name ?></strong></span>
            </a>
            <?php if (isset($this->params['categoryChild'][$lefts[5]->id])) { ?>
                <?php foreach ($this->params['categoryChild'][$lefts[5]->id] as $k => $c) { ?>
                    <a href="/danh-muc/<?=$lefts[5]->slug ?>/<?=$c['slug'] ?>">
                        <span class="category-child <?=($k == 0) ? 'bn' : '' ?>"><?= $c['name'] ?></span>
                    </a>
                <?php } ?>
            <?php } ?>
        </h3>

        <div class="row">
            <div class="col-sm-8">
                <?php if (isset($lefts[5]->news[0])) { ?>
                    <div class="news-first-item">
                        <a href="/tin-tuc/<?= $lefts[5]->news[0]->slug ?>">
                            <img src="<?= HOST. $lefts[5]->news[0]->logo ?>" alt="...">
                        </a>

                        <div class="news-first-item-info">
                            <h4>
                                <a href="/tin-tuc/<?= $lefts[5]->news[0]->slug ?>">
                                    <strong class="f-title">
                                        <?= $lefts[5]->news[0]->title . Functions::getNewsIcon($lefts[5]->news[0]->type) ?>
                                    </strong>
                                </a>
                            </h4>

                            <div class="f-description">
                                <?= $lefts[5]->news[0]->description ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-sm-4 news-ex-item">
                <?php if (isset($lefts[5]['news'][1])) { ?>
                    <div class="news-item">
                        <a href="/tin-tuc/<?= $lefts[5]->news[1]->slug ?>">
                            <img src="<?= HOST. $lefts[5]->news[1]->logo ?>" alt="...">
                            <h5>
                                <strong class="f-title">
                                    <?= $lefts[5]->news[1]->title . Functions::getNewsIcon($lefts[5]->news[1]->type) ?>
                                </strong>
                            </h5>
                        </a>
                    </div>
                <?php } ?>
                <?php if (isset($lefts[5]['news'][2])) { ?>
                    <div class="news-item">
                        <a href="/tin-tuc/<?= $lefts[5]->news[2]->slug ?>">
                            <img src="<?= HOST. $lefts[5]->news[2]->logo ?>" alt="...">
                            <h5>
                                <strong class="f-title">
                                    <?= $lefts[5]->news[2]->title . Functions::getNewsIcon($lefts[5]->news[2]->type) ?>
                                </strong>
                            </h5>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php if (count($lefts[5]->news) > 3) { ?>
            <div id="group-news-slide-2" class="owl-carousel home">
                <?php foreach ($lefts[5]->news as $k => $n) { ?>
                    <?php if ($k > 2) { ?>
                        <div class="item">
                            <div class="">
                                <a href="/tin-tuc/<?= $n->slug ?>">
                                    <img src="<?= HOST. $n->logo ?>">
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
        <?php } ?>
    </section>
    <hr class="w2 m10"/>
<?php } ?>

</div>
<div class="right-block">
<?php if (isset($ads[2])) { ?>
    <?php
    $this->registerJs("
        $('#slide-ads" . $ads[2]->id . "').carousel({
        interval: " . $ads[2]->time_swap * 1000 . "
    });
    ");
    ?>
    <div id="slide-ads<?= $ads[2]->id ?>" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <?php if ($ads[2]->type == ADS_TYPE_BANNER) { ?>
                <?php foreach ($ads[2]->images as $k => $ai) { ?>
                    <?php if ($ai) {
                        ?>
                        <div class="item <?= ($k == 0) ? "active" : ""; ?>">
                            <a <?php if ($ads[2]->url){ ?>href="<?= $ads[2]->url ?>"<?php } ?>
                               target="_blank">
                                <img src="<?= HOST. $ai ?>">
                            </a>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                <?php foreach ($ads[2]->htmls as $l => $ah) { ?>
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
<?php if (isset($lastestNews) && $lastestNews) { ?>
    <section id="business-news">
        <h3 class="text-uppercase text-center">
            <a>
                <strong class="text-gradiant"> Tin mới nhất</strong>
            </a>
        </h3>
        <ul class="list-unstyled right-news-list right-news-list-2">
            <?php foreach ($lastestNews as $k => $n) { ?>
                <li>
                    <a href="/tin-tuc/<?= $n->slug ?>">
                        <img src="<?= HOST. $n->logo ?>">
                        <strong class="f-title">
                            <?= $n->title . Functions::getNewsIcon($n->type) ?>
                        </strong>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </section>
<?php } ?>
<?php if (isset($ads[4])) { ?>
    <?php
    $this->registerJs("
        $('#slide-ads" . $ads[4]->id . "').carousel({
        interval: " . $ads[4]->time_swap * 1000 . "
    });
    ");
    ?>
    <div id="slide-ads<?= $ads[4]->id ?>" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <?php if ($ads[4]->type == ADS_TYPE_BANNER) { ?>
                <?php foreach ($ads[4]->images as $k => $ai) { ?>
                    <?php if ($ai) {
                        ?>
                        <div class="item <?= ($k == 0) ? "active" : ""; ?>">
                            <a <?php if ($ads[4]->url){ ?>href="<?= $ads[4]->url ?>"<?php } ?>
                               target="_blank">
                                <img src="<?= HOST. $ai ?>">
                            </a>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                <?php foreach ($ads[4]->htmls as $l => $ah) { ?>
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
<?php if (isset($rights[0]) && $rights[0]->news) { ?>
    <section id="business-news">
        <h3 class="text-uppercase text-center">
            <a href="/danh-muc/<?= $rights[0]['slug'] ?>">
                <strong class="text-gradiant"><?= $rights[0]->name ?></strong>
            </a>
        </h3>
        <ul class="list-unstyled right-news-list right-news-list-2">
            <?php foreach ($rights[0]->news as $k => $n) { ?>
                <?php if ($k < 4) { ?>
                    <li>
                        <a href="/tin-tuc/<?= $n->slug ?>">
                            <img src="<?= HOST. $n->logo ?>">
                            <strong class="f-title">
                                <?= $n->title . Functions::getNewsIcon($n->type) ?>
                            </strong>
                        </a>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
    </section>
<?php } ?>
<?php if (isset($ads[5])) { ?>
    <?php
    $this->registerJs("
        $('#slide-ads" . $ads[5]->id . "').carousel({
        interval: " . $ads[5]->time_swap * 1000 . "
    });
    ");
    ?>
    <div id="slide-ads<?= $ads[5]->id ?>" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <?php if ($ads[5]->type == ADS_TYPE_BANNER) { ?>
                <?php foreach ($ads[5]->images as $k => $ai) { ?>
                    <?php if ($ai) {
                        ?>
                        <div class="item <?= ($k == 0) ? "active" : ""; ?>">
                            <a <?php if ($ads[5]->url){ ?>href="<?= $ads[5]->url ?>"<?php } ?>
                               target="_blank">
                                <img src="<?= HOST. $ai ?>">
                            </a>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                <?php foreach ($ads[5]->htmls as $l => $ah) { ?>
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
<?php if (isset($rights[1]) && $rights[1]->news) { ?>
    <section id="business-news">
        <h3 class="text-uppercase text-center">
            <a href="/danh-muc/<?= $rights[1]['slug'] ?>">
                <strong class="text-gradiant"><?= $rights[1]->name ?></strong>
            </a>
        </h3>
        <ul class="list-unstyled right-news-list right-news-list-2">
            <?php foreach ($rights[1]->news as $k => $n) { ?>
                <?php if ($k <= 4) { ?>
                    <li>
                        <a href="/tin-tuc/<?= $n->slug ?>">
                            <img src="<?= HOST. $n->logo ?>">
                            <strong class="f-title">
                                <?= $n->title . Functions::getNewsIcon($n->type) ?>
                            </strong>
                        </a>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
    </section>
<?php } ?>
<?php if (isset($ads[6])) { ?>
    <?php
    $this->registerJs("
        $('#slide-ads" . $ads[6]->id . "').carousel({
        interval: " . $ads[6]->time_swap * 1000 . "
    });
    ");
    ?>
    <div id="slide-ads<?= $ads[6]->id ?>" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <?php if ($ads[6]->type == ADS_TYPE_BANNER) { ?>
                <?php foreach ($ads[6]->images as $k => $ai) { ?>
                    <?php if ($ai) {
                        ?>
                        <div class="item <?= ($k == 0) ? "active" : ""; ?>">
                            <a <?php if ($ads[6]->url){ ?>href="<?= $ads[6]->url ?>"<?php } ?>
                               target="_blank">
                                <img src="<?= HOST. $ai ?>">
                            </a>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                <?php foreach ($ads[6]->htmls as $l => $ah) { ?>
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
<?php if (isset($contestNews) && $contestNews) { ?>
    <section id="business-news">
        <h3 class="text-uppercase text-center">
            <a>
                <strong class="text-gradiant"> Cuộc thi viết</strong>
            </a>
        </h3>
        <ul class="list-unstyled right-news-list right-news-list-2">
            <?php foreach ($contestNews as $k => $n) { ?>
                <?php if ($k < 4) { ?>
                    <li>
                        <a href="/tin-tuc/<?= $n->slug ?>">
                            <img src="<?= HOST. $n->logo ?>">
                            <strong class="f-title">
                                <?= $n->title . Functions::getNewsIcon($n->type) ?>
                            </strong>
                        </a>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
    </section>
<?php } ?>
<?php if (isset($ads[7])) { ?>
    <?php
    $this->registerJs("
        $('#slide-ads" . $ads[7]->id . "').carousel({
        interval: " . $ads[7]->time_swap * 1000 . "
    });
    ");
    ?>
    <div id="slide-ads<?= $ads[7]->id ?>" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <?php if ($ads[7]->type == ADS_TYPE_BANNER) { ?>
                <?php foreach ($ads[7]->images as $k => $ai) { ?>
                    <?php if ($ai) {
                        ?>
                        <div class="item <?= ($k == 0) ? "active" : ""; ?>">
                            <a <?php if ($ads[7]->url){ ?>href="<?= $ads[7]->url ?>"<?php } ?>
                               target="_blank">
                                <img src="<?= HOST. $ai ?>">
                            </a>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                <?php foreach ($ads[7]->htmls as $l => $ah) { ?>
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
<?php if (isset($ads[8])) { ?>
    <?php
    $this->registerJs("
        $('#slide-ads" . $ads[8]->id . "').carousel({
        interval: " . $ads[8]->time_swap * 1000 . "
    });
    ");
    ?>
    <div id="slide-ads<?= $ads[8]->id ?>" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <?php if ($ads[8]->type == ADS_TYPE_BANNER) { ?>
                <?php foreach ($ads[8]->images as $k => $ai) { ?>
                    <?php if ($ai) {
                        ?>
                        <div class="item <?= ($k == 0) ? "active" : ""; ?>">
                            <a <?php if ($ads[8]->url){ ?>href="<?= $ads[8]->url ?>"<?php } ?> class="ads-custom"
                               target="_blank">
                                <img src="<?= HOST. $ai ?>">
                            </a>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                <?php foreach ($ads[8]->htmls as $l => $ah) { ?>
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
<div class="clearfix"></div>
<div class="row div-2-block">
    <?php if (isset($lefts[6]) && $lefts[6]->news) { ?>
        <div class="col-sm-4 br2">
            <section id="group-news-2-1" class="group-news-2">
                <h3 class="text-uppercase">
                    <a href="/danh-muc/<?= $lefts[6]['slug'] ?>">
                        <i class="<?= $lefts[6]->icon ?>" aria-hidden="true"></i>
                        <strong class="text-gradiant"> <?= $lefts[6]->name ?></strong>
                    </a>
                </h3>
                <a href="/tin-tuc/<?= $lefts[6]->news[0]->slug ?>" class="firt-news-item">
                    <img src="<?= HOST. $lefts[6]->news[0]->logo ?>">
                    <strong class="f-title">
                        <?= $lefts[6]->news[0]->title . Functions::getNewsIcon($lefts[6]->news[0]->type) ?>
                    </strong>
                </a>
                <ul>
                    <?php foreach ($lefts[6]->news as $k => $n) { ?>
                        <?php if ($k <= 2 && $k > 0) { ?>
                            <li>
                                <a href="/tin-tuc/<?= $n->slug ?>">
                                    <strong class="f-title">
                                        <?= strip_tags($n->title) . Functions::getNewsIcon($n->type) ?>
                                    </strong>
                                </a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </section>
        </div>
    <?php } ?>
    <?php if (isset($lefts[7]) && $lefts[7]->news) { ?>
        <div class="col-sm-4 br2">
            <section id="group-news-2-1" class="group-news-2">
                <h3 class="text-uppercase">
                    <a href="/danh-muc/<?= $lefts[7]['slug'] ?>">
                        <i class="<?= $lefts[7]->icon ?>" aria-hidden="true"></i>
                        <strong class="text-gradiant"> <?= $lefts[7]->name ?></strong>
                    </a>
                </h3>
                <a href="/tin-tuc/<?= $lefts[7]->news[0]->slug ?>" class="firt-news-item">
                    <img src="<?= HOST. $lefts[7]->news[0]->logo ?>">
                    <strong class="f-title">
                        <?= $lefts[7]->news[0]->title . Functions::getNewsIcon($lefts[7]->news[0]->type) ?>
                    </strong>
                </a>
                <ul>
                    <?php foreach ($lefts[7]->news as $k => $n) { ?>
                        <?php if ($k <= 2 && $k > 0) { ?>
                            <li>
                                <a href="/tin-tuc/<?= $n->slug ?>">
                                    <strong class="f-title">
                                        <?= strip_tags($n->title) . Functions::getNewsIcon($n->type) ?>
                                    </strong>
                                </a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </section>
        </div>
    <?php } ?>
    <?php if (isset($lefts[8]) && $lefts[8]->news) { ?>
        <div class="col-sm-4">
            <section id="group-news-2-1" class="group-news-2">
                <h3 class="text-uppercase">
                    <a href="/danh-muc/<?= $lefts[8]['slug'] ?>">
                        <i class="<?= $lefts[8]->icon ?>" aria-hidden="true"></i>
                        <strong class="text-gradiant"> <?= $lefts[8]->name ?></strong>
                    </a>
                </h3>
                <a href="/tin-tuc/<?= $lefts[8]->news[0]->slug ?>" class="firt-news-item">
                    <img src="<?= HOST. $lefts[8]->news[0]->logo ?>">
                    <strong class="f-title">
                        <?= $lefts[8]->news[0]->title . Functions::getNewsIcon($lefts[8]->news[0]->type) ?>
                    </strong>
                </a>
                <ul>
                    <?php foreach ($lefts[8]->news as $k => $n) { ?>
                        <?php if ($k <= 2 && $k > 0) { ?>
                            <li>
                                <a href="/tin-tuc/<?= $n->slug ?>">
                                    <strong class="f-title">
                                        <?= strip_tags($n->title) . Functions::getNewsIcon($n->type) ?>
                                    </strong>
                                </a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </section>
        </div>
    <?php } ?>
</div>
<hr class="w2"/>
<div class="left-block">
    <?php if (isset($lefts[9]) && $lefts[9]->news) { ?>
        <section id="group-news-3-1" class="group-news-3">
            <h3 class="text-uppercase df">
                <a href="/danh-muc/<?= $lefts[9]['slug'] ?>">
                    <span class="category-parent"><strong> <?= $lefts[9]->name ?></strong></span>
                </a>
                <?php if (isset($this->params['categoryChild'][$lefts[9]->id])) { ?>
                    <?php foreach ($this->params['categoryChild'][$lefts[9]->id] as $k => $c) { ?>
                        <a href="/danh-muc/<?=$lefts[9]->slug ?>/<?=$c['slug'] ?>">
                            <span class="category-child <?=($k == 0) ? 'bn' : '' ?>"><?= $c['name'] ?></span>
                        </a>
                    <?php } ?>
                <?php } ?>
            </h3>

            <div class="row">
                <?php foreach ($lefts[9]->news as $k => $n) { ?>
                    <?php if ($k < 3 && $k >= 0) { ?>
                        <div class="col-sm-4">
                            <div class="news-item">
                                <a href="/tin-tuc/<?= $n->slug ?>">
                                    <img src="<?= HOST. $n->logo ?>">
                                    <h4>
                                        <strong class="f-title">
                                            <?= $n->title . Functions::getNewsIcon($n->type) ?>
                                        </strong>
                                    </h4>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </section>
    <?php } ?>
    <hr class="w2"/>
</div>
<div class="right-block">
    <div class="parent-group-news-4">
        <?php if (isset($rights[2]) && $rights[2]->news) { ?>
            <section id="group-news-4">
                <h3 class="text-uppercase">
                    <a href="/danh-muc/<?= $rights[2]['slug'] ?>">
                        <strong> <?= $rights[2]->name ?></strong>
                    </a>
                </h3>

                <div class="news-item">
                    <a href="/tin-tuc/<?= $rights[2]->news[0]->slug ?>">
                        <img src="<?= HOST. $rights[2]->news[0]->logo ?>">
                        <h4>
                            <strong class="f-title">
                                <?= $rights[2]->news[0]->title . Functions::getNewsIcon($rights[2]->news[0]->type) ?>
                            </strong>
                        </h4>
                    </a>
                </div>
            </section>
        <?php } ?>
    </div>
</div>
<div class="clearfix"></div>
<?php if (isset($videos) && !empty($videos)) { ?>
    <section id="video-block">
        <h3 class="text-uppercase">
            <!--            <i class="fa fa-film" aria-hidden="true"></i>-->
            <strong class="text-gradiant"> Clip - Ảnh hay</strong></h3>

        <div class="row">
            <?php foreach ($videos as $k => $n) { ?>
                <?php if ($k < 3 && $k >= 0) { ?>
                    <div class="col-sm-4">
                        <div class="video-icon video-block">
                            <a href="/tin-tuc/<?= $n->slug ?>">
                                <img src="<?= HOST. ($n->logo) ? $n->logo : '/frontend/img/news-item.jpg'; ?>">
                            </a>
                        </div>
                        <a href="/tin-tuc/<?= $n->slug ?>">
                            <strong class="f-title">
                                <?= $n->title ?>
                            </strong>
                        </a>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="owl-carousel video">
            <?php foreach ($videos as $k => $n) { ?>
                <?php if ($k >= 3) { ?>
                    <div class="video-slide-item">
                        <div class="video-icon">
                            <a href="/tin-tuc/<?= $n->slug ?>">
                                <img src="<?= HOST. ($n['logo']) ? $n['logo'] : '/frontend/img/news-item.jpg'; ?>">
                            </a>
                        </div>
                        <a href="/tin-tuc/<?= $n->slug ?>">
                            <strong style="font-size: 15px;">
                                <?= $n['title'] ?>
                            </strong>
                        </a>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </section>
<?php } ?>
<div class="clearfix"></div>
<hr class="w2"/>
<div class="row">
    <div class="col-sm-7">
        <?php if (isset($lefts[10]) && $lefts[10]->news) { ?>
            <section id="group-news-3-2" class="group-news-3">
                <h3 class="text-uppercase">
                    <a href="/danh-muc/<?= $lefts[10]['slug'] ?>">
                        <i class="<?= $lefts[10]->icon ?>" aria-hidden="true"></i>
                        <strong class="text-gradiant"> <?= $lefts[10]->name ?></strong>
                    </a>
                </h3>

                <div class="row">
                    <?php foreach ($lefts[10]->news as $k => $n) { ?>
                        <?php if ($k < 2 && $k >= 0) { ?>
                            <div class="col-sm-6">
                                <div class="news-item">
                                    <div class="">
                                        <a href="/tin-tuc/<?= $n->slug ?>">
                                            <img src="<?= HOST. $n->logo ?>">
                                        </a>
                                    </div>
                                    <a href="/tin-tuc/<?= $n->slug ?>">
                                        <h4>
                                            <strong class="f-title">
                                                <?= $n->title . Functions::getNewsIcon($n->type) ?>
                                            </strong>
                                        </h4>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
                <ul>
                    <?php foreach ($lefts[10]->news as $k => $n) { ?>
                        <?php if ($k >= 2 && $k < 8) { ?>
                            <li>
                                <a href="/tin-tuc/<?= $n->slug ?>">
                                    <strong class="f-title">
                                        <?= strip_tags($n->title) . Functions::getNewsIcon($n->type) ?>
                                    </strong>
                                </a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </section>
        <?php } ?>
    </div>
    <div class="col-sm-5">
        <div class="fb-page"
             data-href="https://www.facebook.com/thieunien.abc/"
             data-tabs="timeline"
             data-small-header="true"
             data-adapt-container-width="true"
             data-hide-cover="false"
             data-height="350"
             data-width="500"
             data-show-facepile="true">
            <blockquote cite="https://www.facebook.com/thieunien.abc/" class="fb-xfbml-parse-ignore">
                <a href="https://www.facebook.com/thieunien.abc/">Hoa học trò</a>
            </blockquote>
        </div>
    </div>
</div>
<?php if (isset($ads[9])) { ?>
    <?php
    $this->registerJs("
        $('#slide-ads" . $ads[9]->id . "').carousel({
        interval: " . $ads[9]->time_swap * 1000 . "
    });
    ");
    ?>
    <div id="slide-ads<?= $ads[9]->id ?>" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <?php if ($ads[9]->type == ADS_TYPE_BANNER) { ?>
                <?php foreach ($ads[9]->images as $k => $ai) { ?>
                    <?php if ($ai) {
                        ?>
                        <div class="item <?= ($k == 0) ? "active" : ""; ?>">
                            <a <?php if ($ads[9]->url){ ?>href="<?= $ads[9]->url ?>"<?php } ?> class="ads-custom"
                               target="_blank">
                                <img src="<?= HOST. $ai ?>">
                            </a>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                <?php foreach ($ads[9]->htmls as $l => $ah) { ?>
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

