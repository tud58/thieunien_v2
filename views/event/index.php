<?php
use yii\helpers\Html;
use app\helper\Functions;
$this->title = $event->name;
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("infinity('event');", \yii\web\View::POS_END, 'my-options');
?>
<div class="container">
    <div class="left-block">
        <div class="event-description">
            <h3 class="text-uppercase">
                <span class="text-gradiant"> <?=$event->name ?></span>
            </h3>
            <?=$event->description ?>
        </div>
        <section id="group-news-5">
            <div id="list_items">
                <input type="hidden" id="anchor_index" value="0">
                <input type="hidden" id="is_next" value="<?=$is_next ?>">
                <input type="hidden" id="event_id" value="<?=$event->id ?>">
                <?php foreach($news as $k => $n){ ?>
                    <div class="news-item">
                        <div class="col-md-4">
                            <a href="/tin-tuc/<?=$n->slug ?>">
                                <img src="<?= HOST.$n->logo ?>" alt="...">
                            </a>
                        </div>
                        <div class="col-md-8">
                            <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?=date('d-m-Y H:i:s', $n->publish_time); ?></span>
                            <h5>
                                <a href="/tin-tuc/<?=$n->slug ?>">
                                    <strong class="f-title">
                                        <?=$n->title . Functions::getNewsIcon($n->type) ?>
                                    </strong>
                                </a>
                            </h5>
                            <div class="f-description">
                                <?=$n->description ?>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                <?php } ?>
            </div>
        </section>
<!--        --><?php //if ($is_next == 1){ ?>
<!--            <a class="text-center btn-more" id="loading-layer" onclick="show_more_event();">Xem thêm</a>-->
<!--        --><?php //} ?>
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
</div>
