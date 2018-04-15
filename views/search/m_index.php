<?php
use yii\helpers\Html;
use app\helper\Functions;
$this->title = "Tìm kiếm";
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("infinity('search');", \yii\web\View::POS_END, 'my-options');
?>
<div class="container">
    <section id="focus-day">
        <h4 class="text-uppercase">
            <?php if ($keyword){ ?>
                <strong>Kết quả tìm kiếm cho: "<?=$keyword ?>"</strong>
            <?php }else { ?>
                <strong class="main-color">Tin mới nhất</strong>
            <?php } ?>
        </h4>
        <div class="category-block">
            <?php if (count($newsList) > 0){ ?>
                <div id="list_items">
                    <input type="hidden" id="anchor_index" value="0">
                    <input type="hidden" id="is_next" value="<?=$is_next ?>">
                    <input type="hidden" id="keyword" value="<?=$keyword ?>">
                    <?php foreach($newsList as $kn => $n){ ?>
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
                            <div class="focus-day-other">
                                <div class="news-item">
                                    <a href="/tin-tuc/<?=$n->slug ?>">
                                        <img src="<?=$n->logo ?>">
                                        <h5><strong><?=$n->title ?></strong></h5>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </section>
</div>
