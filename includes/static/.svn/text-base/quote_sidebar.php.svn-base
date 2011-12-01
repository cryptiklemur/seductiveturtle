<div id="username">
	<?php $user = Bootstrap::getDataS('Default_Model_User','id = '.Bootstrap::getUser());?>
	<?=$user->user_firstname?>'s Control Panel
</div>

<div id="quote_steps">
	<ul><?php 
		$data = Bootstrap::getDataS('Default_Model_Quote_Full','quote_user = '.Bootstrap::getUser());
		if(empty($data->quote_type)) { ?>
			<li><a onClick="ajaxR('quote_step','');">Let's Begin!</a></li>
		<?php }
		
		if($data->quote_type == "business") { ?>
			<li><a onClick="ajaxR('quote_step','');">Website type - Step 1</a></li>
			<?php 
			if(!empty($data->quote_about)) { ?>
				<li><a onClick="ajaxR('quote_step','1');">About your company - Step 2</a></li>				
			<?php }
			if(!empty($data->quote_shopping) && $data->quote_website == "new website") { ?>
				<li><a onClick="ajaxR('quote_step','2');">Ecommerce option - Step 3</a></li>
			<?php }
			if(!empty($data->quote_upgrade_type) && $data->quote_website != "new website") { ?>
				<li><a onClick="ajaxR('quote_step','2');">Upgrade options - Step 3</a></li>
			<?php }
			if(!empty($data->quote_cms) && $data->quote_website == "new website") { ?>
				<li><a onClick="ajaxR('quote_step','3');">CMS option - Step 4</a></li>	
			<?php }
			if(!empty($data->quote_technology) && $data->quote_website != "new website") { ?>
				<li><a onClick="ajaxR('quote_step','3');">Existing features - Step 4</a></li>
			<?php }
			if(!empty($data->quote_features) && $data->quote_website == "new website") { ?>
				<li><a onClick="ajaxR('quote_step','4');">New features - Step 5</a></li>
			<?php }
			if(!empty($data->quote_services) && $data->quote_website != "new website") { ?>
				<li><a onClick="ajaxR('quote_step','4');">Our services - Step 5</a></li>
			<?php }
			if(!empty($data->quote_services) && $data->quote_website == "new website") { ?>
				<li><a onClick="ajaxR('quote_step','5');">New services - Step 6</a></li>	
			<?php }
			}
			
		if($data->quote_type == "personal") { ?>
			<li><a onClick="ajaxR('quote_step','');">Website type - Step 1</a></li>
			<?php 
			if(!empty($data->quote_about)) { ?>
				<li><a onClick="ajaxR('quote_step','1');">About yourself - Step 2</a></li>
			<?php }
			if(!empty($data->quote_cms) && $data->quote_website == "new website") { ?>
				<li><a onClick="ajaxR('quote_step','2');">CMS option - Step 3</a></li>	
			<?php }
			if(!empty($data->quote_upgrade_type) && $data->quote_website != "new website") { ?>
				<li><a onClick="ajaxR('quote_step','2');">Upgrade options - Step 3</a></li>
			<?php }
			if(!empty($data->quote_technology) && $data->quote_website != "new website") { ?>
				<li><a onClick="ajaxR('quote_step','3');">Existing features - Step 4</a></li>
			<?php }
			if(!empty($data->quote_features) && $data->quote_website == "new website") { ?>
				<li><a onClick="ajaxR('quote_step','4');">New features - Step 4</a></li>
			<?php }
			if(!empty($data->quote_features) && $data->quote_website != "new website") { ?>
				<li><a onClick="ajaxR('quote_step','4');">New features - Step 5</a></li>
			<?php }
			if(!empty($data->quote_services) && $data->quote_website == "new website") { ?>
				<li><a onClick="ajaxR('quote_step','4');">Our services - Step 5</a></li>
			<?php }
			if(!empty($data->quote_services) && $data->quote_website != "new website") { ?>
				<li><a onClick="ajaxR('quote_step','4');">Our services - Step 6</a></li>
				
			
		<?php } } ?>
		<li><a href="/quote/summary">Summary</a></li>
	</ul>
</div>

<div id="quote_estimate">
	<div class="price_box">
		Website Cost (minimum):<br />
		<div id="total_price_min"></div>
		Website Cost (average):<br />
		<div id="total_price_avg"></div>
	</div>
	<div class="price_box">
		Monthly Cost:<br />
		<div id="month_price"></div>
	</div>
</div>

<div id="quote_chat">
	<!-- webim button -->
	<a href="http://CHANGEME.info/chat/client.php?locale=en&amp;style=referer_style&amp;group=2" target="_blank" onclick="if(navigator.userAgent.toLowerCase().indexOf('opera') != -1 &amp;&amp; window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open('http://CHANGEME.info/chat/client.php?locale=en&amp;style=referer_style&amp;group=2&amp;url='+escape(document.location.href)+'&amp;referrer='+escape(document.referrer), 'webim', 'toolbar=0,scrollbars=0,location=0,status=1,menubar=0,width=800,height=600,resizable=1');this.newWindow.focus();this.newWindow.opener=window;return false;"><img src="http://CHANGEME.info/chat/button.php?i=galacticedge&amp;lang=en&amp;group=2" border="0" width="200" height="55" alt=""/></a>
	<!-- / webim button --><br />
	<a target="_blank" href="/faq"><img alt='F.A.Q.' title='Frequently Asked Questions' src='/includes/images/faq-button.jpg'/></a>
</div>
