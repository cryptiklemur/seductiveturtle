<?php 
$menu = Bootstrap::getDataM('menu','type = "front" AND visible = 1','order ASC');
foreach($menu as $item) { ?>
	<li id='<?=$item->alt?>'><a href="<?=$item->link?>"><?=$item->name?></a></li>
<?php } ?>
<?php if(Bootstrap::isInGroup('administrator') || Bootstrap::isInGroup('demo')) { ?>
<li><a href="#">Admin</a>
	<ul>
		<?php
		$menu = Bootstrap::getDataM('menu','type = "admin" AND visible = 1','order ASC');
		foreach($menu as $item) { ?>
			<li id='<?=$item->alt?>'><a href="<?=$item->link?>"><?=$item->name?></a></li>
		<?php } ?>
	</ul>
<?php } ?>
</li>
