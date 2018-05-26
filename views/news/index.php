<?php
use app\helper\Functions;

$this->registerJsFile("http://stickyjs.com/jquery.sticky.js", ['depends' => [\yii\web\JqueryAsset::className()]]);

//$this->registerCssFile("frontend/js/imgslide/distr/imgslider.min.css", ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile("frontend/js/imgslide/distr/imgslider.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerCssFile("frontend/js/twentytwenty/css/twentytwenty.css", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("frontend/js/twentytwenty/js/jquery.event.move.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("frontend/js/twentytwenty/js/jquery.twentytwenty.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("frontend/js/img_compare.js", ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->title = strip_tags(html_entity_decode($news->title));
$this->params['breadcrumbs'][] = strip_tags(html_entity_decode($news->title));
$this->registerJs("infinity('item');", \yii\web\View::POS_END, 'my-options');
$interval = (isset($news->interval)) ? $news->interval : 15;
$interval *= 1000;
if ($news->type == 3)
    $this->registerJs("setInterval(function(){ loadNews(); }, " . $interval . ");", \yii\web\View::POS_END, 'my-options');


$this->registerJs("
	$('.news-content img').each(function() {
		if($(this).attr('alt')){
			$(this).after('<div class=\'text-center\' style=\'font-size: 12px;\'>' + $(this).attr('alt') + '</div>')	
		}
	});
	
	$('.right-block').sticky({
		topSpacing:0,
		className: 'is-sticky right-block'
		});
	
");

?>
<style>
    .news-detail-info .news-detail-author {
        color: <?php echo MAIN_COLOR2;?>;
    }
</style>
<div class="container container-detail <?php if (Functions::isIpad()) echo "ipad"; ?>"
     xmlns="http://www.w3.org/1999/html">
    <div class="left-block categories">
        <section>
            <?php if ($categories) { ?>
                <h3 class="text-uppercase">
                    <?php foreach ($categories as $k => $c) { ?>
                        <?php if (($c->id == $category->parent_id && $category->parent_id > 0) || $c->id == $category->id) { ?>
                            <span class="category-parent"><strong> <?= $c->name ?></strong></span>
                            <?php break;
                        } ?>
                    <?php } ?>
                    <?php foreach ($categories as $k => $c) { ?>
                        <?php if ($c->id != $category->parent_id && $category->parent_id > 0) { ?>
                            <a href="/danh-muc/<?=$category['slug'] ?>/<?=$c['slug'] ?>">
                                <span class="category-child <?=($c->id == $category->id) ? 'active' : '' ?> <?=($k == 1) ? 'bn' : '' ?>"><?= $c->name ?></span>
                            </a>
                        <?php } ?>
                    <?php } ?>
                </h3>
            <?php } ?>
        </section>
    </div>
    <div class="right-block">

    </div>
</div>
<div id="news-cover">
    <?php if ($news->cover) { ?>
        <img src="<?= HOST. $news->cover ?>" alt="<?= $news->title ?>"/>
    <?php } ?>
</div>
<div class="container container-detail <?php if (Functions::isIpad()) echo "ipad"; ?>"
     xmlns="http://www.w3.org/1999/html">
<div class="left-block">
<section id="group-news-0-1" class="news-box">
    <h2 class="news-detail-title"><strong class="f-title"><?= $news->title ?></strong></h2>

    <div class="news-detail-info text-uppercase">
        <span class="news-detail-author text-uppercase"><strong><?= $news->author ?></strong></span>
        <?php if ($news->source) { ?>
            | <span class="news-detail-source text-uppercase"><?= $news->source ?></span>
        <?php } ?>
        <span class="news-detail-time">
                    <i class="fa fa-clock-o" aria-hidden="true"></i>
            <?= date(' H:i d/m/Y', $news->publish_time); ?>
                </span>

        <div class="fb-like" data-href="<?= Yii::$app->request->hostInfo . Yii::$app->request->getUrl() ?>"
             data-layout="button_count" data-action="like" data-size="small" data-show-faces="false"
             data-share="true"></div>
    </div>
    <!--            <div class="news-detail-social">-->
    <!--                <a class="news-detail-comment-count btn"><i class="fa fa-comment-o" aria-hidden="true"></i> <label for="message">Bình luận</label></a>-->
    <!--            </div>-->
    <?php if (isset($ads[41])) { ?>
        <?php
        $this->registerJs("
        $('#slide-ads" . $ads[41]->id . "').carousel({
        interval: " . $ads[41]->time_swap * 1000 . "
    });
    ");
        ?>
        <div id="slide-ads<?= $ads[41]->id ?>" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                <?php if ($ads[41]->type == ADS_TYPE_BANNER) { ?>
                    <?php foreach ($ads[41]->images as $k => $ai) { ?>
                        <?php if ($ai) {
                            ?>
                            <div class="item <?= ($k == 0) ? "active" : ""; ?>">
                                <a <?php if ($ads[41]->url){ ?>href="<?= $ads[41]->url ?>"<?php } ?> class="ads"
                                   target="_blank">
                                    <img src="<?= HOST. $ai ?>">
                                </a>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } else { ?>
                    <?php foreach ($ads[41]->htmls as $l => $ah) { ?>
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
    <?php if ($news->type == 3) { ?>
        <div class="news-content news-content-live">
            <input type="hidden" value="<?= count($newsLive) ?>" id="live_index">
            <strong class=""><?= $news->description ?></strong>
            <ul class="list-unstyled" id="news-live">
                <?php foreach ($newsLive as $nl) { ?>
                    <li>
                        <div class="news-live-item">
                            <strong class="f-title"><?= $nl->title ?></strong>

                            <p class="text-justify">
                                <?= $nl->content ?>
                            </p>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="video-content text-justify">
            <?= $news->content ?>
        </div>
    <?php } else { ?>
        <div class="news-content video-content">
            <p class="text-left fs-16">
                <strong><?= $news->description ?></strong>
            </p>

            <p class="text-justify">
                <?= $news->content ?>
            </p>
        </div>
        <div id=AdAsia></div>
    <?php } ?>
    <div class="clearfix"></div>
</section>

<div class="clearfix"></div>
<?php if (isset($tags) && $tags) { ?>
    <div>
        <ul class="list-unstyled news-detail-tag">
            <?php foreach ($tags as $t) { ?>
                <li>
                    <a class="border-gradiant-round border-radius-12"
                       href="<?= ($t->slug) ? '/tag/' . $t->slug : '#'; ?>">#<?= Functions::renameTag($t->name); ?><span
                            class="text-gradiant">#<?= Functions::renameTag($t->name); ?></span></a>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>
<div class="ads-block">
    <?php if (isset($ads[42])) { ?>
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
<?php if (isset($news) && $news) { ?>
    <section id="comment-block">
    </section>
<?php } ?>
<div class="clearfix"></div>
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
                                <img src="<?= ($n->logo) ? HOST. $n->logo : '/frontend/img/news-item.jpg'; ?>">
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
<div class="row" style="margin-bottom: 25px">
    <?php if ($lastestNews) { ?>
        <div class="col-sm-<?= ($weeklyNews) ? '6' : '12' ?> group-news-6" id="news-lastest">
            <h3 class="text-uppercase">
                <strong class="text-gradiant"> Tin mới nhất</strong>
            </h3>
            <a href="/tin-tuc/<?= $lastestNews[0]->slug ?>" class="first" title="<?= strip_tags($lastestNews[0]->title) ?>">
                <img src="<?= ($lastestNews[0]->logo) ? HOST. $lastestNews[0]->logo : HOST. '/frontend/img/news-item.jpg'; ?>"
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
                <img src="<?= ($weeklyNews[0]->logo) ? HOST. $weeklyNews[0]->logo : '/frontend/img/news-item.jpg'; ?>"
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
</div>
<div>
    <div>
        <div class="right-block">
            <?php if (count($ads) > 1) { ?>
                <?php foreach ($ads as $key => $a) { ?>
                    <?php if ($key > 42 && $key <= 60) { ?>
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
</div>
<div class="clearfix"></div>

<input type="hidden" value="<?= $news->id ?>" id="news_id">
<?php if ($category) { ?>
    <input type="hidden" id="category_id" value="<?= $category->id ?>">
<?php } else { ?>
    <input type="hidden" id="tag_id" value="<?= $tag->id ?>">
<?php } ?>
<input type="hidden" id="anchor_index" value="0">
<input type="hidden" id="is_next" value="1">

<div id="more-news">

</div>
</div>