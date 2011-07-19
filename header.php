<!DOCTYPE html>
<html lang="en-US">
	<head>
		<?=header_()?>
		<!--[if IE]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<style>article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section {display: block;}</style>
		<link href="http://cdn.ucf.edu/webcom/-/css/blueprint-ie.css" rel="stylesheet" media="screen, projection">
		<![endif]-->
		<script type="text/javascript">
			<?php if(GA_ACCOUNT):?>
			var GA_ACCOUNT      = '<?=GA_ACCOUNT?>';
			<?php endif;?>
			<?php if(CB_UID):?>
			var CB_UID          = '<?=CB_UID?>';
			var CB_DOMAIN       = '<?=CB_DOMAIN?>';
			<?php endif?>	
			var _sf_startpt     = (new Date()).getTime();
			var _gaq            = _gaq || [];
		</script>
	</head>
	<body class="<?=body_classes()?>">
		<div id="blueprint-container" class="container">
			
			<?php if (is_home() || is_front_page() ): ?>
			<div id="header">
				<h1 class="light">Parking and <br>Transportation</h1>
			</div>
			<?php else: ?>
			<div id="header">
				<div class="span-11 page">
					<h1 class="light"><a href="<?=bloginfo('url')?>"><?=str_replace('UCF', '', get_bloginfo('name'))?></a></h1>
				</div>
				<div class="span-13 last">
					
					<?php
						$locations = get_nav_menu_locations();
						$menu      = @$locations['header-menu'];
						if (!$menu){
							echo "<div class='error'>Header menu not yet created.</div>"; 
						} else {
							$items = wp_get_nav_menu_items($menu);
							printf('<ul class="%s">', $post->post_name);
							foreach($items as $key=>$item){
								printf('<li><a class="%s" href="%s">%s</a></li>'."\n",
									basename($item->url), $item->url, $item->title);
							}
							echo '</ul>';
						}
					?>
				</div>
				<div class="clear"></div>
			</div>
			<?php endif; ?>
