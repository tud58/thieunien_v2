<?php
use yii\helpers\Html;
use app\helper\Functions;
$this->title = $event->name;
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("infinity('event');", \yii\web\View::POS_END, 'my-options');
?>
<div class="container">
    <section id="focus-day">
        <div class="category-block">
            <?php if (count($news) > 0){ ?>
                <h4>
                    <strong class="text-gradiant text-uppercase"> <?=$event->name ?></strong>
                </h4>
                <?php foreach($news as $kn => $n){ ?>
                    <?php if ($kn == 0){ ?>
                        <div class="news-item first">
                            <a href="/tin-tuc/<?=$n->slug ?>">
                                <img src="<?= HOST.$n->logo ?>">
                            </a>
                            <h4><strong><?=$n->title ?></strong></h4>
                            <div class="des">
                                <?=$n->description ?>
                            </div>
                        </div>
                    <?php }else { ?>
                        <div class="focus-day-other" id="list_items">
                            <input type="hidden" id="anchor_index" value="0">
                            <input type="hidden" id="is_next" value="<?=$is_next ?>">
                            <input type="hidden" id="event_id" value="<?=$event->id ?>">
                            <div class="news-item">
                                <a href="/tin-tuc/<?=$n->slug ?>">
                                    <img src="<?= HOST.$n->logo ?>">
                                    <h5><strong><?=$n->title ?></strong></h5>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </div>
    </section>
</div>
