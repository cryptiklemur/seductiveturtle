<div class='grid_12' id="footer_nav">
	<ul>
		<?php 
        $menu = Bootstrap::getDataM('menu','type = "front" AND visible = 1','order ASC');
        foreach($menu as $item) { ?>
            <li id='<?=$item->alt?>'><a href="<?=$item->link?>"><?=ucwords($item->name)?></a></li>
        <?php } ?>
	</ul>
</div>
<div class='grid_12' id="footer_text">
	Galactic Edge &amp; Seductive Turtle
	<a href='/admin' style='text-decoration:none; color:#3c3c3c; cursor:default;'> | </a>
	Copyright  &copy; <?php echo date('Y'); ?>
</div>
