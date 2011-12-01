<ul id="mainnav">
<?php 
$menu = Bootstrap::getDataM('menu','type = "front" AND visible = 1','order ASC');
foreach($menu as $item) { ?>
	<li id='<?=$item->alt?>'><a href="<?=$item->link?>"><?=$item->name?></a></li>
<?php } ?>
<div id="administration">
<?php if(Bootstrap::isInGroup('administrator') || Bootstrap::isInGroup('demo')) { 
	$menu = Bootstrap::getDataM('menu','type = "admin" AND visible = 1','order ASC');
	foreach($menu as $item) { ?>
		<li id='<?=$item->alt?>'><a href="<?=$item->link?>"><?=$item->name?></a></li>
	<?php }
}
?>
</div>
</ul>