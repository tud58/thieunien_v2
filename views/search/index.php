<?php
use app\helper\Functions;
$this->title = "Tìm kiếm";
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("infinity('search');", \yii\web\View::POS_END, 'my-options');
?>
<div class="container">
    <div class="left-block">
        <section id="group-news-1">
            <h3 class="text-uppercase">
                <?php if ($keyword){ ?>
                    <strong>Kết quả tìm kiếm cho: "<?=$keyword ?>"</strong>
                <?php }else { ?>
                    <strong>Tất cả bài viết</strong>
                <?php } ?>
            </h3>
            <div class="row video-list" id="list_items">
                <input type="hidden" id="anchor_index" value="0">
                <input type="hidden" id="is_next" value="<?=$is_next ?>">
                <input type="hidden" id="keyword" value="<?=$keyword ?>">
                <?php foreach($newsList as $k => $n){ ?>
                    <div class="col-sm-4">
                        <div class="news-item">
                            <div class="embed-responsive embed-responsive-16by9">
                                <a href="/tin-tuc/<?=$n->slug ?>">
                                    <img src="<?= HOST.$n->logo ?>" alt="...">
                                </a>
                            </div>
                            <a href="/tin-tuc/<?=$n->slug ?>">
                                <h5>
                                    <strong class="f-title">
                                        <?=$n->title . Functions::getNewsIcon($n->type) ?>
                                    </strong>
                                </h5>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <hr>
<!--            --><?php //if ($is_next == 1){ ?>
<!--                <a class="text-center btn-more" id="loading-layer" onclick="show_more_search();">Xem thêm</a>-->
<!--            --><?php //} ?>
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
