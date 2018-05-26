<?php if (\app\helper\Functions::isMobile()){ ?>
    <?php foreach($videos as $k => $v){ ?>
        <div class="news-item">
            <a href="/clip/<?=$v->slug ?>" class="video-cover">
                <img src="<?= HOST.$v->logo ?>">
            </a>
            <a href="/clip/<?=$v->slug ?>">
                <h5><strong class="f-title"><?=$v->title ?></strong></h5>
            </a>
        </div>
    <?php } ?>
<?php }else { ?>
    <?php foreach($videos as $k => $v){ ?>
        <div class="col-sm-4">
            <div class="news-item">
                <div class="embed-responsive embed-responsive-16by9 video-icon">
                    <a href="/clip/<?=$v->slug ?>">
                        <img src="<?= HOST.$v->logo ?>">
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
<?php } ?>
<script>
    var is_next = <?=$is_next ?>;
    $("#is_next").val(is_next);
//    if (is_next == 0)
//        $("#loading-layer").hide();
</script>