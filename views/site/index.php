<?php
use app\helper\Functions;

$this->title = 'Thiếu niên';
//var_dump($this->params['categoryChild']);die;
?>
<div class="container">
    <div class="row">
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
    </div>

    <div class="row">
        <div class="left-block">
            <?php if (isset($lefts[0]) && $lefts[0]->news) { ?>
                <section id="focus-day">
                    <div class="row">
                        <div class="col-sm-8">
                            <div id="carousel-home" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner" role="listbox">
                                    <?php if(!empty($lefts[0]->news[0])) {
                                        $n = $lefts[0]->news[0];
                                        ?>
                                        <div class="item active">
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
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 news-ex-item">
                            <div class="box-right-left-block">
                                <?php if (count($lefts[0]->news) >= 5) { ?>
                                    <?php $count = 0;
                                    foreach ($lefts[0]->news as $n) {
                                        if($count >= 4 && $count <= 7) {
                                            if($count == 4) { ?>
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
                                                <hr>
                                            <?php }else{ ?>
                                                <div class="news-item">
                                                    <a href="/tin-tuc/<?= $n->slug ?>">
                                                        <h5>
                                                            <strong class="f-title">
                                                                <?= $n->title . Functions::getNewsIcon($n->type) ?>
                                                            </strong>
                                                        </h5>
                                                    </a>
                                                </div>
                                                <hr>
                                            <?php }
                                        }
                                        $count++;
                                    } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php if (count($lefts[0]->news) >= 2) { ?>
                        <div class="row">
                            <?php $count = 0;
                            foreach ($lefts[0]->news as $n) {
                                if($count >= 1 && $count <= 3) { ?>
                                    <div class="news-item col-sm-4">
                                        <a href="/tin-tuc/<?= $n->slug ?>">
                                            <img src="<?= HOST. $n->logo ?>">
                                            <h5>
                                                <strong class="f-title">
                                                    <?= $n->title . Functions::getNewsIcon($n->type) ?>
                                                </strong>
                                            </h5>
                                        </a>
                                    </div>
                                <?php }
                                $count++;
                            } ?>
                        </div>
                    <?php } ?>
                </section>
                <!--    <hr class="w2"/>-->
            <?php } ?>
            <?php if (isset($lefts[1]) && $lefts[1]->news) { ?>
                <section id="group-news-0-1">
                    <h3 class="text-uppercase df">
                        <div class="line-left-title"></div>
                        <a href="/danh-muc/<?= $lefts[1]['slug'] ?>">
                            <span class="category-parent"><strong> <?= $lefts[1]->name ?></strong></span>
                        </a>
                        <div class="line-right-title"></div>
                    </h3>

                    <div class="row">
                        <?php if (count($lefts[1]->news) >=1) {
                            $count = 0; ?>
                            <div class="col-sm-8" style="padding-right: 0; ">
                                <?php foreach ($lefts[1]->news as $n) { ?>
                                    <?php if ($count >= 0 && $count <= 3 ) {?>
                                        <div class="news-item col-sm-6">
                                            <a href="/tin-tuc/<?= $n->slug ?>">
                                                <img src="<?= HOST. $n->logo ?>" alt="...">
                                            </a>

                                            <div class="news-item-info">
                                                <h4>
                                                    <a href="/tin-tuc/<?= $n->slug ?>">
                                                        <strong class="f-title">
                                                            <?= $n->title . Functions::getNewsIcon($n->type) ?>
                                                        </strong>
                                                    </a>
                                                </h4>
                                            </div>
                                        </div>
                                    <?php } $count++; ?>
                                <?php } ?>
                            </div>
                        <?php }?>
                        <?php if (count($lefts[1]->news) >=5) {
                            $count = 0; ?>
                            <div class="col-sm-4">
                                <?php foreach ($lefts[1]->news as $n) { ?>
                                    <?php if ($count >= 4 && $count <= 9 ) {?>
                                        <div class="news-item">
                                            <div class="">
                                                <i class="glyphicon glyphicon-move"></i>
                                            </div>
                                            <div class="news-item-info">
                                                <h5>
                                                    <a href="/tin-tuc/<?= $n->slug ?>">
                                                        <strong class="f-title">
                                                            <?= $n->title . Functions::getNewsIcon($n->type) ?>
                                                        </strong>
                                                    </a>
                                                </h5>
                                            </div>
                                        </div>
                                    <?php } $count++; ?>
                                <?php } ?>
                            </div>
                        <?php }?>
                    </div>
                </section>
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

            <?php if (isset($lefts[2]) && $lefts[2]->news) { ?>
                <section id="group-news-0-2">
                    <h3 class="text-uppercase df">
                        <div class="line-left-title"></div>
                        <a href="/danh-muc/<?= $lefts[2]['slug'] ?>">
                            <span class="category-parent"><strong> <?= $lefts[2]->name ?></strong></span>
                        </a>
                        <div class="line-right-title" style="width: 80%; "></div>
                    </h3>

                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row">
                                <?php if (isset($lefts[2]->news[0])) { ?>
                                    <div class="news-item col-sm-6">
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
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (isset($lefts[2]->news[1])) { ?>
                                    <div class="news-item col-sm-6">
                                        <a href="/tin-tuc/<?= $lefts[2]->news[1]->slug ?>">
                                            <img src="<?= HOST. $lefts[2]->news[1]->logo ?>" alt="...">
                                        </a>

                                        <div class="news-first-item-info">
                                            <h4>
                                                <a href="/tin-tuc/<?= $lefts[2]->news[1]->slug ?>">
                                                    <strong class="f-title">
                                                        <?= $lefts[2]->news[1]->title . Functions::getNewsIcon($lefts[2]->news[1]->type) ?>
                                                    </strong>
                                                </a>
                                            </h4>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php if (count($lefts[2]->news) > 8) { ?>
                                <div class="row slide-news">
                                    <div id="group-news-slide-3" class="owl-carousel">
                                        <?php foreach ($lefts[2]->news as $k => $n) { ?>
                                            <?php if ($k > 7) { ?>
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
                                </div>
                            <?php } ?>
                        </div>
                        <?php if (count($lefts[2]->news) >=3) {
                            $count = 0; ?>
                            <div class="col-sm-4">
                                <?php foreach ($lefts[2]->news as $n) { ?>
                                    <?php if ($count >= 2 && $count <= 7 ) {?>
                                        <div class="news-item">
                                            <div class="">
                                                <i class="glyphicon glyphicon-move"></i>
                                            </div>
                                            <div class="news-item-info">
                                                <h5>
                                                    <a href="/tin-tuc/<?= $n->slug ?>">
                                                        <strong class="f-title">
                                                            <?= $n->title . Functions::getNewsIcon($n->type) ?>
                                                        </strong>
                                                    </a>
                                                </h5>
                                            </div>
                                        </div>
                                    <?php } $count++; ?>
                                <?php } ?>
                            </div>
                        <?php }?>
                    </div>
                </section>
            <?php } ?>

            <?php if (isset($lefts[3]) && $lefts[3]->news) { $nl3 = $lefts[3]->news; ?>
                <section id="group-news-0-3">
                    <h3 class="text-uppercase df">
                        <div class="line-left-title"></div>
                        <a href="/danh-muc/<?= $lefts[3]['slug'] ?>">
                            <span class="category-parent"><strong> <?= $lefts[3]->name ?></strong></span>
                        </a>
                        <div class="line-right-title" style="width: 80%; "></div>
                    </h3>

                    <div class="row">
                        <div class="col-sm-4 news-item">
                            <?php if (isset($nl3[0])) { ?>
                                <div class="news-item">
                                    <a href="/tin-tuc/<?= $nl3[0]->slug ?>">
                                        <img src="<?= HOST. $nl3[0]->logo ?>" alt="...">
                                        <h5>
                                            <strong class="f-title">
                                                <?= $nl3[0]->title . Functions::getNewsIcon($nl3[0]->type) ?>
                                            </strong>
                                        </h5>
                                    </a>
                                </div>
                            <?php } ?>
                            <?php if (isset($nl3[1])) { ?>
                                <div class="news-item">
                                    <a href="/tin-tuc/<?= $nl3[1]->slug ?>">
                                        <h5>
                                            <p class="f-title">
                                                <?= $nl3[1]->title . Functions::getNewsIcon($nl3[1]->type) ?>
                                            </p>
                                        </h5>
                                    </a>
                                </div>
                            <?php } ?>
                            <?php if (isset($nl3[2])) { ?>
                                <div class="news-item">
                                    <a href="/tin-tuc/<?= $nl3[2]->slug ?>">
                                        <h5>
                                            <p class="f-title">
                                                <?= $nl3[2]->title . Functions::getNewsIcon($nl3[2]->type) ?>
                                            </p>
                                        </h5>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-sm-4 news-item">
                            <?php if (isset($nl3[3])) { ?>
                                <div class="news-item">
                                    <a href="/tin-tuc/<?= $nl3[3]->slug ?>">
                                        <img src="<?= HOST. $nl3[3]->logo ?>" alt="...">
                                        <h5>
                                            <strong class="f-title">
                                                <?= $nl3[3]->title . Functions::getNewsIcon($nl3[3]->type) ?>
                                            </strong>
                                        </h5>
                                    </a>
                                </div>
                            <?php } ?>
                            <?php if (isset($nl3[4])) { ?>
                                <div class="news-item">
                                    <a href="/tin-tuc/<?= $nl3[4]->slug ?>">
                                        <h5>
                                            <p class="f-title">
                                                <?= $nl3[4]->title . Functions::getNewsIcon($nl3[4]->type) ?>
                                            </p>
                                        </h5>
                                    </a>
                                </div>
                            <?php } ?>
                            <?php if (isset($nl3[5])) { ?>
                                <div class="news-item">
                                    <a href="/tin-tuc/<?= $nl3[5]->slug ?>">
                                        <h5>
                                            <p class="f-title">
                                                <?= $nl3[5]->title . Functions::getNewsIcon($nl3[5]->type) ?>
                                            </p>
                                        </h5>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-sm-4 news-item">
                            <?php if (isset($nl3[6])) { ?>
                                <div class="news-item">
                                    <a href="/tin-tuc/<?= $nl3[6]->slug ?>">
                                        <img src="<?= HOST. $nl3[6]->logo ?>" alt="...">
                                        <h5>
                                            <strong class="f-title">
                                                <?= $nl3[6]->title . Functions::getNewsIcon($nl3[6]->type) ?>
                                            </strong>
                                        </h5>
                                    </a>
                                </div>
                            <?php } ?>
                            <?php if (isset($nl3[7])) { ?>
                                <div class="news-item">
                                    <a href="/tin-tuc/<?= $nl3[7]->slug ?>">
                                        <h5>
                                            <p class="f-title">
                                                <?= $nl3[7]->title . Functions::getNewsIcon($nl3[7]->type) ?>
                                            </p>
                                        </h5>
                                    </a>
                                </div>
                            <?php } ?>
                            <?php if (isset($nl3[8])) { ?>
                                <div class="news-item">
                                    <a href="/tin-tuc/<?= $nl3[8]->slug ?>">
                                        <h5>
                                            <p class="f-title">
                                                <?= $nl3[8]->title . Functions::getNewsIcon($nl3[8]->type) ?>
                                            </p>
                                        </h5>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </section>
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
            <?php if (isset($hotNews) && $hotNews) { ?>
                <section id="business-news">
                    <h3 class="text-uppercase text-center">
                        <a>
                            <strong class="text-gradiant"> Tin đọc nhiều</strong>
                        </a>
                    </h3>
                    <ul class="list-unstyled right-news-list right-news-list-2">
                        <?php foreach ($hotNews as $k => $n) { ?>
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
        </div>
    </div>

    <div class="row">
        <?php if (isset($lefts[4]) && $lefts[4]->news) { ?>
            <section id="group-news-0-4">
                <h3 class="text-uppercase df">
                    <div class="line-left-title"></div>
                    <a href="/danh-muc/<?= $lefts[4]['slug'] ?>">
                        <span class="category-parent"><strong> <?= $lefts[4]->name ?></strong></span>
                    </a>
                    <div class="line-right-title" style="width: 86%; "></div>
                </h3>

                <div class="row">
                    <div class="col-sm-4">
                        <?php if (isset($lefts[4]->news[0])) { ?>
                            <div class="news-item">
                                <a href="/tin-tuc/<?= $lefts[4]->news[0]->slug ?>">
                                    <img src="<?= HOST. $lefts[4]->news[0]->logo ?>" alt="...">
                                </a>

                                <div class="news-first-item-info">
                                    <h4>
                                        <a href="/tin-tuc/<?= $lefts[4]->news[0]->slug ?>">
                                            <strong class="f-title">
                                                <?= $lefts[4]->news[0]->title . Functions::getNewsIcon($lefts[4]->news[0]->type) ?>
                                            </strong>
                                        </a>
                                    </h4>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-4">
                        <?php if (isset($lefts[4]['news'][1])) { ?>
                            <div class="news-item">
                                <a href="/tin-tuc/<?= $lefts[4]->news[1]->slug ?>">
                                    <img src="<?= HOST. $lefts[4]->news[1]->logo ?>" alt="...">
                                    <h5>
                                        <strong class="f-title">
                                            <?= $lefts[4]->news[1]->title . Functions::getNewsIcon($lefts[4]->news[1]->type) ?>
                                        </strong>
                                    </h5>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-4">
                        <?php if (isset($lefts[4]['news'][2])) { ?>
                            <div class="news-item">
                                <a href="/tin-tuc/<?= $lefts[4]->news[2]->slug ?>">
                                    <img src="<?= HOST. $lefts[4]->news[2]->logo ?>" alt="...">
                                    <h5>
                                        <strong class="f-title">
                                            <?= $lefts[4]->news[2]->title . Functions::getNewsIcon($lefts[4]->news[2]->type) ?>
                                        </strong>
                                    </h5>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php if (count($lefts[4]->news) > 3) { ?>
                    <div id="group-news-slide-6" class="owl-carousel">
                        <?php foreach ($lefts[4]->news as $k => $n) { ?>
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

    <div class="row">
        <div class="left-block">
            <?php if (isset($lefts[5]) && $lefts[5]->news) { ?>
                <section id="group-news-0-5">
                    <h3 class="text-uppercase df">
                        <div class="line-left-title"></div>
                        <a href="/danh-muc/<?= $lefts[5]['slug'] ?>">
                            <span class="category-parent"><strong> <?= $lefts[5]->name ?></strong></span>
                        </a>
                        <div class="line-right-title" style="width: 75%; "></div>
                    </h3>

                    <div class="row">
                        <?php foreach ($lefts[5]->news as $k => $n) { ?>
                            <?php if ($k < 6) { ?>
                                <div class="col-sm-4">
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
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </section>
            <?php } ?>

            <?php if (isset($lefts[6]) && $lefts[6]->news) { ?>
                <section id="group-news-0-6">
                    <h3 class="text-uppercase df">
                        <div class="line-left-title"></div>
                        <a href="/danh-muc/<?= $lefts[6]['slug'] ?>">
                            <span class="category-parent"><strong> <?= $lefts[6]->name ?></strong></span>
                        </a>
                        <div class="line-right-title" style="width: 78%; "></div>
                    </h3>

                    <div class="row">
                        <?php foreach ($lefts[6]->news as $k => $n) { ?>
                            <?php if ($k < 3) { ?>
                                <div class="col-sm-4">
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
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </section>
            <?php } ?>
        </div>

        <div class="right-block">
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
        </div>
    </div>

    <div class="row">
        <?php if (isset($lefts[7]) && $lefts[7]->news) { $nl7 = $lefts[7]->news; ?>
            <section id="group-news-0-7">
                <h3 class="text-uppercase df">
                    <div class="line-left-title"></div>
                    <a href="/danh-muc/<?= $lefts[7]['slug'] ?>">
                        <span class="category-parent"><strong> <?= $lefts[7]->name ?></strong></span>
                    </a>
                    <div class="line-right-title" style="width: 81%; "></div>
                </h3>

                <div class="row">
                    <div class="col-sm-4 news-item">
                        <?php if (isset($nl7[0])) { ?>
                            <div class="news-item">
                                <a href="/tin-tuc/<?= $nl7[0]->slug ?>">
                                    <img src="<?= HOST. $nl7[0]->logo ?>" alt="...">
                                    <h5>
                                        <strong class="f-title">
                                            <?= $nl7[0]->title . Functions::getNewsIcon($nl7[0]->type) ?>
                                        </strong>
                                    </h5>
                                </a>
                            </div>
                            <hr class="">
                        <?php } ?>
                        <?php if (isset($nl7[1])) { ?>
                            <div class="news-item">
                                <a href="/tin-tuc/<?= $nl7[1]->slug ?>">
                                    <h5>
                                        <p class="f-title">
                                            <?= $nl7[1]->title . Functions::getNewsIcon($nl7[1]->type) ?>
                                        </p>
                                    </h5>
                                </a>
                            </div>
                            <hr class="">
                        <?php } ?>
                        <?php if (isset($nl7[2])) { ?>
                            <div class="news-item">
                                <a href="/tin-tuc/<?= $nl7[2]->slug ?>">
                                    <h5>
                                        <p class="f-title">
                                            <?= $nl7[2]->title . Functions::getNewsIcon($nl7[2]->type) ?>
                                        </p>
                                    </h5>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-4 news-item">
                        <?php if (isset($nl7[3])) { ?>
                            <div class="news-item">
                                <a href="/tin-tuc/<?= $nl7[3]->slug ?>">
                                    <img src="<?= HOST. $nl7[3]->logo ?>" alt="...">
                                    <h5>
                                        <strong class="f-title">
                                            <?= $nl7[3]->title . Functions::getNewsIcon($nl7[3]->type) ?>
                                        </strong>
                                    </h5>
                                </a>
                            </div>
                            <hr class="">
                        <?php } ?>
                        <?php if (isset($nl7[4])) { ?>
                            <div class="news-item">
                                <a href="/tin-tuc/<?= $nl7[4]->slug ?>">
                                    <h5>
                                        <p class="f-title">
                                            <?= $nl7[4]->title . Functions::getNewsIcon($nl7[4]->type) ?>
                                        </p>
                                    </h5>
                                </a>
                            </div>
                            <hr class="">
                        <?php } ?>
                        <?php if (isset($nl7[5])) { ?>
                            <div class="news-item">
                                <a href="/tin-tuc/<?= $nl7[5]->slug ?>">
                                    <h5>
                                        <p class="f-title">
                                            <?= $nl7[5]->title . Functions::getNewsIcon($nl7[5]->type) ?>
                                        </p>
                                    </h5>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-4 news-item">
                        <?php if (isset($nl7[6])) { ?>
                            <div class="news-item">
                                <a href="/tin-tuc/<?= $nl7[6]->slug ?>">
                                    <img src="<?= HOST. $nl7[6]->logo ?>" alt="...">
                                    <h5>
                                        <strong class="f-title">
                                            <?= $nl7[6]->title . Functions::getNewsIcon($nl7[6]->type) ?>
                                        </strong>
                                    </h5>
                                </a>
                            </div>
                            <hr class="">
                        <?php } ?>
                        <?php if (isset($nl7[7])) { ?>
                            <div class="news-item">
                                <a href="/tin-tuc/<?= $nl7[7]->slug ?>">
                                    <h5>
                                        <p class="f-title">
                                            <?= $nl7[7]->title . Functions::getNewsIcon($nl7[7]->type) ?>
                                        </p>
                                    </h5>
                                </a>
                            </div>
                            <hr class="">
                        <?php } ?>
                        <?php if (isset($nl7[8])) { ?>
                            <div class="news-item">
                                <a href="/tin-tuc/<?= $nl7[8]->slug ?>">
                                    <h5>
                                        <p class="f-title">
                                            <?= $nl7[8]->title . Functions::getNewsIcon($nl7[8]->type) ?>
                                        </p>
                                    </h5>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </section>
        <?php } ?>
        <hr class="w2 m10"/>
    </div>

    <div class="row">
        <?php if (isset($ads[6])) { ?>
            <div id="slide-ads<?= $ads[6]->id ?>" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner" role="listbox" style="text-align: center;">
                    <?php if ($ads[6]->type == ADS_TYPE_BANNER) { ?>
                        <?php foreach ($ads[6]->images as $k => $ai) { ?>
                            <?php if ($ai) {
                                ?>
                                <div class="item <?= ($k == 0) ? "active" : ""; ?>" style="text-align: center;">
                                    <a <?php if ($ads[6]->url){ ?>href="<?= $ads[6]->url ?>"<?php } ?> class="ads-custom"
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
    </div>
</div>

