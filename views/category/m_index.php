<?php
use yii\helpers\Html;
use app\helper\Functions;
$this->title = $category->name;
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("infinity('category');", \yii\web\View::POS_END, 'my-options');
?>
<div class="container">
    <input type="hidden" value="<?=$type ?>" id="type">
    <section id="focus-day">
        <div class="category-block">
            <?php if (count($news) > 0){ ?>
                <h4>
                    <strong class="main-color text-uppercase"> <?=$category->name ?></strong>
                </h4>
                <hr style="margin-bottom: 5px;margin-top: 5px;margin-left: -15px;margin-right: -15px">
                <ul class="row tab-list-home list-unstyled text-center text-uppercase" role="tablist">
                    <?php foreach($categoryChilds as $k => $c){ ?>
                        <li class="<?php if ($categoryChild && $categoryChild->id == $c->id) echo 'active'; ?>">
                            <a href="/danh-muc/<?=$category->slug ?>/<?=$c->slug ?>">
                                <?=$c->name ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>

                <div class="clearfix"></div>

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
                            <input type="hidden" id="category_id" value="<?=$category->id ?>">
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
