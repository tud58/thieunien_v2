<p>Tổng số: <?=$count_items?><?php if($page_count > 0){?>, trang <?=$page?>/<?=$page_count?><?}?>.</p>
<?php if($page_count > 0){?>
<ul class="pagination">
	<?php if($page > 1){?>
		<li class=""><a  href="<?= $pageUrl?>&page=1">1</a></li>
	<?php }?>
	<?php if(max(2, $page - 5) > 2){?>
		<li class=""><a>...</a></li>
	<?php }?>
	<?php for($i = max(2, $page - 5); $i < $page; $i++){?>
		<li class=""><a  href="<?= $pageUrl?>&page=<?=$i?>"><?=$i?></a></li>
	<?php }?>
	<li class="active"><a><?= $page ?></a></li>
	<?php for($i = $page + 1; $i < min($page_count, $page + 5); $i++){?>
		<li class=""><a  href="<?= $pageUrl?>&page=<?=$i?>"><?=$i?></a></li>
	<?php }?>
	<?php if(min($page_count, $page + 5) < $page_count){?>
		<li class=""><a>...</a></li>
	<?php }?>
	<?php if($page < $page_count){?>
		<li class=""><a  href="<?= $pageUrl?>&page=<?=$page_count?>"><?=$page_count?></a></li>
	<?php }?>
</ul>
<?}?>