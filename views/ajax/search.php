<?php if (\app\helper\Functions::isMobile()){ ?>
    <?php foreach($newsList as $k => $n){ ?>
        <div class="focus-day-other">
            <div class="news-item">
                <a href="/tin-tuc/<?=$n->slug ?>">
                    <img src="<?=$n->logo ?>">
                    <h5><strong class="f-title"><?=$n->title ?></strong></h5>
                </a>
            </div>
        </div>
    <?php } ?>
<?php }else { ?>
    <?php foreach($newsList as $k => $n){ ?>
        <div class="col-sm-4">
            <div class="news-item">
                <div class="embed-responsive embed-responsive-16by9">
                    <a href="/tin-tuc/<?=$n->slug ?>">
                        <img src="<?=$n->logo ?>" alt="...">
                    </a>
                </div>
                <a href="/tin-tuc/<?=$n->slug ?>">
                    <h5>
                        <strong class="f-title">
                            <?=$n->title ?>
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