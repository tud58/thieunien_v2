<?php   
use yii\helpers\Html;
use app\helper\Functions;
$this->title = strip_tags(html_entity_decode($news->title));
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container" xmlns="http://www.w3.org/1999/html">
    <section id="group-news-0-1">
        <?php if ($event){ ?>
            <h3 class="text-uppercase"><strong class="text-gradiant"> <?=$event->name ?></strong></h3>
        <?php } ?>
        <h4 class="news-detail-title"><strong><?=$news->title ?></strong></h4>
        <div class="news-detail-info">
            <span class="news-detail-author text-uppercase"><?=$news->user_full_name ?></span>
            <?php if ($news->source){ ?>
                | <span class="news-detail-source text-uppercase"><?=$news->source ?></span>
            <?php } ?>
            <span class="news-detail-time">
                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                <?=date('d-m-Y H:i', $news->publish_time); ?>
                </span>
        </div>
        <div class="news-detail-social">
            <a class="news-detail-comment-count btn"><i class="fa fa-comment-o" aria-hidden="true"></i> <label for="message">Bình luận</label></a>
        </div>
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
        <div class="news-detail-description">
            <strong class=""><?=$news->description ?></strong>
        </div>
        <div class="news-detail-detail">
            <?=$news->content ?>
        </div>
        <hr>
        <ul class="list-unstyled news-detail-tag">
            <?php foreach($tags as $t){?>
                <li>
                    <a class="border-gradiant-round border-radius-12" href="<?=($t->slug) ? '/tag/'.$t->slug : '#'; ?>">#<?=Functions::renameTag($t->name); ?><span class="text-gradiant">#<?=Functions::renameTag($t->name); ?></span></a>
                </li>
            <?php } ?>
        </ul>
        <?php if (isset($ads[42])){ ?>
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
                                        <img src="<?= $ai ?>">
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
    </section>
    <?php if (isset($news) && $news){ ?>
        <section id="comment-block">
            <div class="comment-input-block ">
                <div class="row">
                    <div class="col-sm-2">
                        <a href="#"><img src="/uploads/user_avatar/<?=Yii::$app->user->id?>.png"></a>
                    </div>
                    <div class="col-sm-10">
                        <input type="hidden" value="<?=$news->id ?>" id="news_id">
                        <textarea id="message" class="form-control" placeholder="Bình luận..."></textarea>
                        <div class="comment-control-block pull-right">
                            <button class="btn" type="button" onclick="send_comment(0);">Gửi</button>
                            <button class="btn" type="reset">Hủy</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (isset($comments) && $comments){ ?>
                <div class="comment-list-block ">
                    <input type="hidden" id="index_comment" value="0">
                    <input type="hidden" id="next_comment" value="<?=$next_comment ?>">
                    <ul class="list-unstyled">
                        <li id="list_comments">
                            <?php foreach($comments as $k => $c){?>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <a href="javascript:void(0)"><img src="/uploads/user_avatar/<?=$c->user_id?>.png"></a>
                                    </div>
                                    <div class="col-sm-10">
                                        <a href="javascript:void(0)" class="comment-user-name">
                                            <strong><?=$c->user_name ?></strong>
                                        </a>
                                        <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?=date('d-m-Y H:i:s', $c->create_time); ?></span>
                                        <p>
                                            <?=$c->message ?>
                                        </p>
                                    </div>
                                </div>
                                <?php if ($k < (count($comments) - 1)){ ?>
                                    <hr>
                                <?php } ?>
                            <?php } ?>
                        </li>
                    </ul>
                </div>
            <?php } ?>
            <?php if ($next_comment == 1){ ?>
                <a class="text-center btn-more" id="loading-layer" onclick="show_more_comment();">Xem thêm bình luận khác</a>
            <?php } ?>
        </section>
        <section id="comment-block">
            <div class="fb-comments" data-href="<?=Yii::$app->request->hostInfo . Yii::$app->request->getUrl()?>" data-width="100%" data-numposts="5"></div>
        </section>
    <?php } ?>
    <div class="clearfix"></div>
    <?php if (isset($newsSame) && $newsSame){ ?>
        <a class="border-gradiant-round border-radius-12 text-uppercase">Cùng sự kiện<span class="text-gradiant">Cùng sự kiện</span></a>
        <div id="group-news-slide-1" class="row">
            <?php foreach($newsSame as $k => $n){?>
                <?php if ($k < 10){ ?>
                    <a href="/tin-tuc/<?=$n->slug ?>" class="col-sm-3 col-xs-6">
                        <img src="<?=($n->logo) ? $n->logo : '/frontend/img/news-item.jpg'; ?>">
                        <h5>
                            <strong>
                                <?=$n->title . Functions::getNewsIcon($n->type) ?>
                            </strong>
                        </h5>
                    </a>
                <?php } ?>
            <?php } ?>
        </div>
    <?php } ?>
</div>
