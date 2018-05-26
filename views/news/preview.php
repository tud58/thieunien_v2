<?php
use app\helper\Functions;

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
");
?>
<div class="container container-detail <?php if (Functions::isIpad()) echo "ipad"; ?>"
     xmlns="http://www.w3.org/1999/html">
<div class="left-block">
<section id="group-news-0-1" class="news-box">
    <?php if ($category) { ?>
        <h3 class="text-uppercase"><i class="<?= $category->icon ?>" aria-hidden="true"></i><strong
                class="text-gradiant"> <?= $category->name ?></strong></h3>
    <?php } ?>
    <h2 class="news-detail-title"><strong class="f-title"><?= $news->title ?></strong></h2>

    <div class="news-detail-info text-uppercase">
        <!--                <span class="news-detail-author text-uppercase">-->
        <?//=$news->user_full_name ?><!--</span>-->
        <?php if ($news->source) { ?>
            | <span class="news-detail-source text-uppercase"><?= $news->source ?></span>
        <?php } ?>

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
    <?php } ?>

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
        <!--                <div class="comment-input-block ">-->
        <!--                    <div class="row">-->
        <!--                        <div class="col-sm-2">-->
        <!--                            <a href="#"><img src="/uploads/user_avatar/-->
        <?//=Yii::$app->user->id?><!--.png"></a>-->
        <!--                        </div>-->
        <!--                        <div class="col-sm-10">-->
        <!--                            <input type="hidden" value="--><?//=$news->id ?><!--" id="news_id">-->
        <!--                            <textarea id="message" class="form-control" placeholder="Bình luận..."></textarea>-->
        <!--                            <div class="comment-control-block pull-right">-->
        <!--                                <button class="btn" type="button" onclick="send_comment(0);">Gửi</button>-->
        <!--                                <button class="btn" type="reset">Hủy</button>-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--                --><?php //if (isset($comments) && $comments){ ?>
        <!--                    <div class="comment-list-block ">-->
        <!--                        <input type="hidden" id="index_comment" value="0">-->
        <!--                        <input type="hidden" id="next_comment" value="--><?//=$next_comment ?><!--">-->
        <!--                        <ul class="list-unstyled">-->
        <!--                            <li id="list_comments">-->
        <!--                                --><?php //foreach($comments as $k => $c){?>
        <!--                                    <div class="row">-->
        <!--                                        <div class="col-sm-2">-->
        <!--                                            <a href="javascript:void(0)"><img src="/uploads/user_avatar/-->
        <?//=$c->user_id?><!--.png"></a>-->
        <!--                                        </div>-->
        <!--                                        <div class="col-sm-10">-->
        <!--                                            <a href="javascript:void(0)" class="comment-user-name">-->
        <!--                                                <strong>--><?//=$c->user_name ?><!--</strong>-->
        <!--                                            </a>-->
        <!--                                            <span><i class="fa fa-clock-o" aria-hidden="true"></i> -->
        <?//=date('d-m-Y H:i:s', $c->create_time); ?><!--</span>-->
        <!--                                            <p>-->
        <!--                                                --><? //=$c->message ?>
        <!--                                            </p>-->
        <!--                                        </div>-->
        <!--                                    </div>-->
        <!--                                    --><?php //if ($k < (count($comments) - 1)){ ?>
        <!--                                        <hr>-->
        <!--                                    --><?php //} ?>
        <!--                                --><?php //} ?>
        <!--                            </li>-->
        <!--                        </ul>-->
        <!--                    </div>-->
        <!--                --><?php //} ?>
        <!--                --><?php //if ($next_comment == 1){ ?>
        <!--                    <a class="text-center btn-more" id="loading-layer" onclick="show_more_comment();">Xem thêm bình luận khác</a>-->
        <!--                --><?php //} ?>
        <!--            </section>-->
        <!--			<section id="comment-block">-->
        <!--				<div class="fb-comments" data-href="-->
        <?//=Yii::$app->request->hostInfo . Yii::$app->request->getUrl()?><!--" data-width="100%" data-numposts="5"></div>-->
    </section>
<?php } ?>
<div class="clearfix"></div>
<?php if (isset($sameNews) && $sameNews) { ?>
    <a class="border-gradiant-round border-radius-12 text-uppercase">Bạn đã đọc chưa?<span class="text-gradiant">Bạn đã đọc chưa?</span></a>
    <div id="group-news-slide-1" class="owl-carousel home">
        <?php foreach ($sameNews as $k => $n) { ?>
            <?php if ($k < 10) { ?>
                <div class="item">
                    <div class="embed-responsive embed-responsive-16by9">
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
<?php } ?>
<div class="row">
    <?php /* if ($events) { ?>
        <div class="col-sm-<?= ($newsRelates) ? '6' : '12' ?> group-news-6">
            <a class="border-gradiant-round border-radius-12 text-uppercase">Dòng sự kiện<span class="text-gradiant">Dòng sự kiện</span></a>
            <ul class="list-unstyled events">
                <?php foreach ($events as $k => $e) { ?>
                    <li>
                        <a href="/su-kien/<?= $e->slug ?>">
                            <strong>
                                <i class="fa fa-circle" aria-hidden="true"></i><?= $e->name ?>
                            </strong>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php } */ ?>
    <?php /* if ($newsRelates) { ?>
        <div class="col-sm-<?= ($events) ? '6' : '12' ?> group-news-6">
            <a href="#" class="border-gradiant-round border-radius-12 text-uppercase">Tin liên quan<span
                    class="text-gradiant">Tin liên quan</span></a>
            <ul class="list-unstyled news-popular">
                <?php foreach ($newsRelates as $k => $n) { ?>
                    <li>
                        <a href="/tin-tuc/<?= ($category) ? $category['id'] : 'tag-' . $tag['id']; ?>/<?= $n->slug ?>">
                            <strong class="f-title">
                                <i class="fa fa-circle"
                                   aria-hidden="true"></i><?= strip_tags($n->title) . Functions::getNewsIcon($n->type) ?>
                            </strong>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php } */ ?>
</div>
</div>
<div class="right-block">
    <?php if (count($ads) > 1) { ?>
        <?php foreach ($ads as $k => $a) { ?>
            <?php if ($k > 42) { ?>
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
<div class="clearfix"></div>
<?php if (isset($videos) && $videos) { ?>
    <section id="video-block">
        <h3 class="text-uppercase">
            <!--                <i class="fa fa-film" aria-hidden="true"></i>-->
            <strong class="text-gradiant"> Video nổi bật</strong></h3>

        <div class="row">
            <?php foreach ($videos as $k => $v) { ?>
                <?php if ($k < 3 && $k >= 0) { ?>
                    <div class="col-sm-4">
                        <div class="embed-responsive embed-responsive-16by9 video-icon">
                            <a href="/video/<?= $v->slug ?>">
                                <img src="<?= HOST. $v->logo ?>">
                            </a>
                        </div>
                        <a href="/video/<?= $v->slug ?>">
                            <strong class="f-title">
                                <?= $v->title ?>
                            </strong>
                        </a>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="owl-carousel video">
            <?php foreach ($videos as $k => $v) { ?>
                <?php if ($k >= 3) { ?>
                    <div class="video-slide-item">
                        <div class="embed-responsive embed-responsive-16by9 video-icon">
                            <a href="/video/<?= $v->slug ?>">
                                <img src="<?= HOST. $v->logo ?>">
                            </a>
                        </div>
                        <a href="/video/<?= $v->slug ?>">
                            <strong class="f-title">
                                <?= $v->title ?>
                            </strong>
                        </a>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </section>
    <hr>
<?php } ?>


</div>
