<?php   
use yii\helpers\Html;
use app\helper\Functions;
$this->title = strip_tags(html_entity_decode($news->title));
$this->params['breadcrumbs'][] = strip_tags(html_entity_decode($news->title));
$this->registerJs("infinity('item');", \yii\web\View::POS_END, 'my-options');
$interval = (isset($news->interval)) ? $news->interval : 15;
$interval *= 1000;

$this->registerJs("
	$('.news-detail-detail img').each(function() {
		if($(this).attr('alt')){
			$(this).after('<div class=\'text-center\' style=\'font-size: 12px;\'>' + $(this).attr('alt') + '</div>')	
		}
	});
");

//$this->registerCssFile("frontend/js/imgslide/distr/imgslider.min.css", ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile("frontend/js/imgslide/distr/imgslider.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerCssFile("frontend/js/twentytwenty/css/twentytwenty.css", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("frontend/js/twentytwenty/js/jquery.event.move.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("frontend/js/twentytwenty/js/jquery.twentytwenty.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("frontend/js/img_compare.js", ['depends' => [\yii\web\JqueryAsset::className()]]);

?>
<div class="container" xmlns="http://www.w3.org/1999/html" style="padding-right: 5px;padding-left: 5px">
    <section id="group-news-0-1">
        <?php if ($category){ ?>
            <h3 class="text-uppercase"><i class="<?=$category->icon ?>" aria-hidden="true"></i><strong class="main-color"> <?=$category->name ?></strong></h3>
        <?php } ?>
        <h3 class="news-detail-title"><strong><?=$news->title ?></strong></h3>
        <div class="news-detail-info">

            <span class="news-detail-author text-uppercase"><strong><?= $news->author ?></strong></span>
            <?php if ($news->source){ ?>
                | <span class="news-detail-source text-uppercase"><?=$news->source ?></span>
            <?php } ?>
            <span class="news-detail-time">
                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                <?=date('d-m-Y H:i', $news->publish_time); ?>
                </span>
            <div class="fb-like" data-href="<?=Yii::$app->request->hostInfo . Yii::$app->request->getUrl()?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>
        </div>

<!--        <div class="news-detail-social">-->
<!--            <a class="news-detail-comment-count btn"><i class="fa fa-comment-o" aria-hidden="true"></i> <label for="message">Bình luận</label></a>-->
<!--        </div>-->
        <?php if (isset($ads[81])){ ?>
            <?php
            $this->registerJs("
        $('#slide-ads" . $ads[81]->id . "').carousel({
        interval: " . $ads[81]->time_swap * 1000 . "
    });
    ");
            ?>
            <div id="slide-ads<?= $ads[81]->id ?>" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner" role="listbox">
                    <?php if ($ads[81]->type == ADS_TYPE_BANNER) { ?>
                        <?php foreach ($ads[81]->images as $k => $ai) { ?>
                            <?php if ($ai) {
                                ?>
                                <div class="item <?= ($k == 0) ? "active" : ""; ?>">
                                    <a <?php if ($ads[81]->url){ ?>href="<?= $ads[81]->url ?>"<?php } ?> class="ads"
                                       target="_blank">
                                        <img src="<?= HOST. $ai ?>">
                                    </a>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    <?php } else { ?>
                        <?php foreach ($ads[81]->htmls as $l => $ah) { ?>
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
            <strong class="text-left"><?=$news->description ?></strong>
        </div>
        <div class="news-detail-detail text-justify">
            <?php
                $content_arr = explode('</p>', $news->content);
                $keyAds = 83;
                foreach ($content_arr as $k => $ca){
                    echo $ca."</p>";
                    if (($k+1)%3 == 0){
                        ?>
                            <div class="ads-block" style="margin-bottom: 10px;">
                                <?php if (isset($ads[$keyAds])){ ?>
                                    <?php
                                    $this->registerJs("
        $('#slide-ads" . $ads[$keyAds]->id . "').carousel({
        interval: " . $ads[$keyAds]->time_swap * 1000 . "
    });
    ");
                                    ?>
                                    <div id="slide-ads<?= $ads[$keyAds]->id ?>" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner" role="listbox">
                                            <?php if ($ads[$keyAds]->type == ADS_TYPE_BANNER) { ?>
                                                <?php foreach ($ads[$keyAds]->images as $k => $ai) { ?>
                                                    <?php if ($ai) {
                                                        ?>
                                                        <div class="item <?= ($k == 0) ? "active" : ""; ?>">
                                                            <a <?php if ($ads[$keyAds]->url){ ?>href="<?= $ads[$keyAds]->url ?>"<?php } ?> class="ads"
                                                               target="_blank">
                                                                <img src="<?= HOST. $ai ?>">
                                                            </a>
                                                        </div>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <?php foreach ($ads[$keyAds]->htmls as $l => $ah) { ?>
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
                        <?php
                        $keyAds ++;
                    }
                }
            ?>
			
			            <div class="fb-like" data-href="<?=Yii::$app->request->hostInfo . Yii::$app->request->getUrl()?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>

						
        </div>
        <div id=AdAsia></div>
<!--        <hr>-->
        <ul class="list-unstyled news-detail-tag">
            <?php foreach($tags as $t){?>
                <li>
                    <a class="border-gradiant-round border-radius-12" href="<?=($t->slug) ? '/tag/'.$t->slug : '#'; ?>">#<?=Functions::renameTag($t->name); ?><span class="text-gradiant">#<?=Functions::renameTag($t->name); ?></span></a>
                </li>
            <?php } ?>
        </ul>
        <hr>
    </section>
<div class="ads-block">
    <?php if (isset($ads[82])) { ?>
        <?php
        $this->registerJs("
        $('#slide-ads" . $ads[82]->id . "').carousel({
        interval: " . $ads[82]->time_swap * 1000 . "
    });
    ");
        ?>
        <div id="slide-ads<?= $ads[82]->id ?>" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                <?php if ($ads[82]->type == ADS_TYPE_BANNER) { ?>
                    <?php foreach ($ads[82]->images as $k => $ai) { ?>
                        <?php if ($ai) {
                            ?>
                            <div class="item <?= ($k == 0) ? "active" : ""; ?>">
                                <a <?php if ($ads[82]->url){ ?>href="<?= $ads[82]->url ?>"<?php } ?> class="ads"
                                   target="_blank">
                                    <img src="<?= HOST. $ai ?>">
                                </a>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } else { ?>
                    <?php foreach ($ads[82]->htmls as $l => $ah) { ?>
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
    <?php if (isset($news) && $news){ ?>
        <section id="comment-block">
<!--            <div class="comment-input-block ">-->
<!--                <div class="row">-->
<!--                    <div class="col-sm-2">-->
<!--                        <a href="#"><img src="/uploads/user_avatar/--><?//=Yii::$app->user->id?><!--.png"></a>-->
<!--                    </div>-->
<!--                    <div class="col-sm-10">-->
<!--                        <input type="hidden" value="--><?//=$news->id ?><!--" id="news_id">-->
<!--                        <textarea id="message" class="form-control" placeholder="Bình luận..."></textarea>-->
<!--                        <div class="comment-control-block pull-right">-->
<!--                            <button class="btn" type="button" onclick="send_comment(0);">Gửi</button>-->
<!--                            <button class="btn" type="reset">Hủy</button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            --><?php //if (isset($comments) && $comments){ ?>
<!--                <div class="comment-list-block ">-->
<!--                    <input type="hidden" id="index_comment" value="0">-->
<!--                    <input type="hidden" id="next_comment" value="--><?//=$next_comment ?><!--">-->
<!--                    <ul class="list-unstyled">-->
<!--                        <li id="list_comments">-->
<!--                            --><?php //foreach($comments as $k => $c){?>
<!--                                <div class="row">-->
<!--                                    <div class="col-sm-2">-->
<!--                                        <a href="javascript:void(0)"><img src="/uploads/user_avatar/--><?//=$c->user_id?><!--.png"></a>-->
<!--                                    </div>-->
<!--                                    <div class="col-sm-10">-->
<!--                                        <a href="javascript:void(0)" class="comment-user-name">-->
<!--                                            <strong>--><?//=$c->user_name ?><!--</strong>-->
<!--                                        </a>-->
<!--                                        <span><i class="fa fa-clock-o" aria-hidden="true"></i> --><?//=date('d-m-Y H:i:s', $c->create_time); ?><!--</span>-->
<!--                                        <p>-->
<!--                                            --><?//=$c->message ?>
<!--                                        </p>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                --><?php //if ($k < (count($comments) - 1)){ ?>
<!--                                    <hr>-->
<!--                                --><?php //} ?>
<!--                            --><?php //} ?>
<!--                        </li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--            --><?php //} ?>
<!--            --><?php //if ($next_comment == 1){ ?>
<!--                <a class="text-center btn-more" id="loading-layer" onclick="show_more_comment();">Xem thêm bình luận khác</a>-->
<!--            --><?php //} ?>
<!--        </section>-->
<!--        <section id="comment-block">-->
<!--            <div class="fb-comments" data-href="--><?//=Yii::$app->request->hostInfo . Yii::$app->request->getUrl()?><!--" data-width="100%" data-numposts="5"></div>-->
        </section>
    <?php } ?>
    <div class="clearfix"></div>
    <input type="hidden" value="<?=$news->id ?>" id="news_id">
    <?php if ($category){ ?>
        <input type="hidden" id="category_id" value="<?=$category->id ?>">
    <?php }else { ?>
        <input type="hidden" id="tag_id" value="<?=$tag->id ?>">
    <?php } ?>
    <input type="hidden" id="anchor_index" value="0">
    <input type="hidden" id="is_next" value="1">
    <div id="more-news">

    </div>
</div>

<div id="showModalDownload" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <p><b>Hoa học trò</b> đem đến cho bạn đọc nội dung đa chiều bằng hình thức trình bày trực quan, hiện đại. <b>Tải ứng dụng để luôn được cập nhật tin tức mới nhất.</b></p>
      </div>
      <div class="modal-footer" style="text-align: center;">
        <a href="https://play.google.com/store/apps/details?id=com.vietdroid.apps.h2tonline"><img src="/frontend/img/itune.png"></a>
    <a href="https://itunes.apple.com/us/app/h2t-hoa-hoc-tro-online/id1296127514?ls=1&mt=8"><img src="/frontend/img/gplay.png"></a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    var detail = true;
</script>
<style type="text/css">
    #showModalDownload img{
        width: 48%;
        margin-bottom: 10px
    }
</style>