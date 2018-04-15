<?php foreach($comments as $k => $c){?>
    <hr>
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
<script>
    var is_next = <?=$is_next ?>;
    $("#next_comment").val(is_next);
    if (is_next == 0)
        $("#loading-layer").hide();
</script>