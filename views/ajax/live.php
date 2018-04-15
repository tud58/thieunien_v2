<?php foreach($newsLive as $nl){?>
    <li>
        <div class="news-live-item">
            <strong class="f-title"><?=$nl->title ?></strong>
            <div class="text-justify">
                <?=$nl->content ?>
            </div>
        </div>
    </li>
<?php } ?>
<script>
    var newsMore = parseInt(<?=count($newsLive) ?>) + parseInt($("#live_index").val());
    $("#live_index").val(newsMore);
</script>