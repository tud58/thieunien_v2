<?php
use yii\helpers\Html;
use app\helper\Functions;
$this->title = "Clip nổi bật";
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("infinity('video');", \yii\web\View::POS_END, 'my-options');
?>
<div class="container">
    <section id="focus-day">
        <div class="category-block">
            <?php if (count($videos) > 0){ ?>
                <h4>
                    <strong class="text-gradiant text-uppercase"> Clip - Ảnh hay</strong>
                </h4>
                <?php foreach($videos as $kn => $n){ ?>
                    <?php if ($kn == 0){ ?>
                        <div class="news-first-item">
                            <div class="video-first">
                                <?=$videos[0]->content ?>
                            </div>
                            <a href="/clip/<?=$videos[0]->slug ?>">
                                <div class="news-first-item-info">
                                    <h4>
                                        <strong>
                                            <?=$videos[0]->title ?>
                                        </strong>
                                    </h4>
                                    <div>
                                        <?=$videos[0]->description ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php }else { ?>
                        <div class="focus-day-other" id="list_items">
                            <input type="hidden" id="anchor_index" value="0">
                            <input type="hidden" id="is_next" value="<?=$is_next ?>">
                            <div class="news-item">
                                <a href="/clip/<?=$n->slug ?>" class="video-cover">
                                    <img src="<?= HOST.$n->logo ?>">
                                </a>
                                <a href="/clip/<?=$n->slug ?>">
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
