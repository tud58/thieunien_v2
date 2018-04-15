<?php
use yii\helpers\Html;
use app\helper\Functions;
$this->title = strip_tags(html_entity_decode($video->title));
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("infinity('video');", \yii\web\View::POS_END, 'my-options');
?>
<style>
    .news-detail-info .news-detail-author {
        color: <?php echo MAIN_COLOR2;?>;
    }
</style>
<div class="container">
    <div class="left-block">
        <section id="group-news-0-1" class="new-box">
            <h2 class="news-detail-title"><strong class="f-title"><?=$video->title ?></strong></h2>
            <div class="news-detail-info text-uppercase">
                <span class="news-detail-author text-uppercase"><strong><?= $video->author ?></strong></span>
                <?php if ($video->source) { ?>
                    | <span class="news-detail-source text-uppercase"><?= $video->source ?></span>
                <?php } ?>
                <span class="news-detail-time">
                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                    <?=date('d-m-Y H:i:s', $video->publish_time); ?>
                </span>
            </div>
<!--            <div class="news-detail-social">-->
<!--                <a class="news-detail-comment-count btn"><i class="fa fa-comment-o" aria-hidden="true"></i> <label for="message">Bình luận</label></a>-->
<!--            </div>-->
            <div class="video-content">
                <div class="">
                    <strong><?=$video->description ?></strong>
                </div>
                <div class="text-justify">
                    <?=$video->content ?>
                </div>
            </div>
            <hr>
            <?php if (isset($tags) && $tags){ ?>
                <ul class="list-unstyled news-detail-tag">
                    <?php foreach($tags as $t){?>
                        <li>
                            <a class="border-gradiant-round border-radius-12" href="<?=($t->slug) ? '/tag/'.$t->slug : '#'; ?>">#<?=Functions::renameTag($t->name); ?><span class="text-gradiant">#<?=Functions::renameTag($t->name); ?></span></a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
            <?php if (isset($ads[41])){ ?>
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
                                            <img src="<?= $ai ?>">
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
        </section>
        <div class="clearfix"></div>
        <?php if (isset($video) && $video){ ?>
            <section id="comment-block">
<!--                <div class="comment-input-block ">-->
<!--                    <div class="row">-->
<!--                        <div class="col-sm-2">-->
<!--                            <a href="#"><img src="/uploads/user_avatar/--><?//=Yii::$app->user->id?><!--.png"></a>-->
<!--                        </div>-->
<!--                        <div class="col-sm-10">-->
<!--                            <input type="hidden" value="--><?//=$video->id ?><!--" id="news_id">-->
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
<!--                                            <a href="javascript:void(0)"><img src="/uploads/user_avatar/--><?//=$c->user_id?><!--.png"></a>-->
<!--                                        </div>-->
<!--                                        <div class="col-sm-10">-->
<!--                                            <a href="javascript:void(0)" class="comment-user-name">-->
<!--                                                <strong>--><?//=$c->user_name ?><!--</strong>-->
<!--                                            </a>-->
<!--                                            <span><i class="fa fa-clock-o" aria-hidden="true"></i> --><?//=date('d-m-Y H:i:s', $c->create_time); ?><!--</span>-->
<!--                                            <p>-->
<!--                                                --><?//=$c->message ?>
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
            </section>
        <?php } ?>
        <div class="clearfix"></div>
        <p>
            <a class="border-gradiant-round border-radius-12 text-uppercase">Cùng chuyên mục<span class="text-gradiant">Cùng chuyên mục</span></a>
        </p>
        <section id="group-news-1">
            <div class="video-list" id="list_items">
                <input type="hidden" id="anchor_index" value="0">
                <input type="hidden" id="is_next" value="<?=$is_next ?>">
                <input type="hidden" id="video_id" value="<?=$video->id ?>">
                <?php foreach($videos as $k => $v){ ?>
                    <div class="col-sm-4">
                        <div class="news-item">
                            <div class="embed-responsive embed-responsive-16by9 video-icon">
                                <a href="/clip/<?=$v->slug ?>">
                                    <img src="<?=$v->logo ?>">
                                </a>
                            </div>
                            <a href="/clip/<?=$v->slug ?>">
                                <h5>
                                    <strong class="f-title">
                                        <?=$v->title ?>
                                    </strong>
                                </h5>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
        <div class="clearfix"></div>
        <!--            --><?php //if ($is_next == 1){ ?>
        <!--                <a class="text-center btn-more" id="loading-layer" onclick="show_more_video();">Xem thêm</a>-->
        <!--            --><?php //} ?>
    </div>
    <div class="right-block">
        <?php if (count($ads) > 1){ ?>
            <?php foreach($ads as $k => $a){?>
                <?php if ($k > 41){ ?>
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
