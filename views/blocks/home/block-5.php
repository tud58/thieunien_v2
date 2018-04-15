<?php
//3 lớn trên 6 dưới
use app\helper\Functions;

?>
    <section>
		<?=$this->render('@app/views/blocks/common/_block-header', ['category' => $category])?>	
		
        <div class="row">
            <?php foreach ($newsList as $k => $news) { ?>
                <?php if ($k < 3 && $k >= 0) { ?>
                    <div class="col-sm-4">
						<?=$this->render('@app/views/blocks/common/_news-item', ['news' => $news])?>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="owl-carousel video">
            <?php foreach ($newsList as $k => $news) { ?>
                <?php if ($k >= 3) { ?>
                    <div class="video-slide-item">
						<?=$this->render('@app/views/blocks/common/_news-item', ['news' => $news])?>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </section>
