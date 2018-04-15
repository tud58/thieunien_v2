<?php
use yii\helpers\Html;
use app\helper\Functions;
$this->title = $tag->name;
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("infinity('category');", \yii\web\View::POS_END, 'my-options');
?>
<div class="container">
    <section id="focus-day">
        <div class="category-block">
            <?php if (count($news) > 0){ ?>
                <p style="margin-top: 10px">
                    <a class="border-gradiant-round border-radius-12">#<?=$tag->name ?><span class="text-gradiant">#<?=$tag->name ?></php></span></a>
                </p>
                <?php foreach($news as $kn => $n){ ?>
                    <?php if ($kn == 0){ ?>
                        <div class="news-item first">
                            <a href="/tin-tuc/<?=$n->slug ?>">
                                <img src="<?=$n->logo ?>">
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
                            <input type="hidden" id="tag_id" value="<?=$tag->id ?>">
                            <div class="news-item">
                                <a href="/tin-tuc/<?=$n->slug ?>">
                                    <img src="<?=$n->logo ?>">
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
