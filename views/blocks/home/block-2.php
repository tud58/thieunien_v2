<?php
//6 bài 2 hàng
use app\helper\Functions;

?>
    <section>
		<?=$this->render('@app/views/blocks/common/_block-header', ['category' => $category])?>	
		
        <div class="row">
            <?php foreach ($newsList as $k => $news) { ?>
                <?php if ($k < 6) { ?>
                    <div class="col-sm-4">
                        <?=$this->render('@app/views/blocks/common/_news-item', ['news' => $news])?>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </section>