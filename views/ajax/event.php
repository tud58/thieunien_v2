<?php if (\app\helper\Functions::isMobile()){ ?>
    <?php foreach($news as $k => $n){ ?>
        <div class="news-item">
            <a href="/tin-tuc/<?=$n->slug ?>">
                <img src="<?=$n->logo ?>">
                <h5><strong class="f-title"><?=$n->title ?></strong></h5>
            </a>
        </div>
    <?php } ?>
<?php }else { ?>
    <?php foreach($news as $k => $n){ ?>
        <div class="news-item">
            <div class="col-md-4">
                <a href="/tin-tuc/<?=$n->slug ?>">
                    <img src="<?=$n->logo ?>" alt="...">
                </a>
            </div>
            <div class="col-md-8">
                <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?=date('d-m-Y H:i:s', $n->publish_time); ?></span>
                <h5>
                    <a href="/tin-tuc/<?=$n->slug ?>">
                        <strong class="f-title">
                            <?=$n->title ?>
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
<?php } ?>
<script>
    var is_next = <?=$is_next ?>;
    $("#is_next").val(is_next);
//    if (is_next == 0)
//        $("#loading-layer").hide();
</script>