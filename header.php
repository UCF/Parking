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
			<div id="header" class="home">
				<h1 class="light">Parking and <br>Transportation</h1>
			</div>
			<?=gen_alerts_html()?>
			
			<?php else: ?>
			<div id="header">
				<?php 
					// use parent slug
					$slug = isset($post->post_parent) ?
						basename(get_permalink($post->post_parent)) :
						basename(get_permalink($post));
				?>
				<div class="span-11 <?=$slug?>">
					<h1 class="light">
						<a href="<?=bloginfo('url')?>">
							<?php
								// format and print page slug
								echo in_array($slug, array("permits", "citations", "shuttles", "rules", "contact", "forms")) ?
									ucwords($slug) :
									'<span class="unknown-size">' . ucwords(str_replace('-', ' ', $slug)) . '</span>';
							?>
							<span><?=str_replace('UCF', '', get_bloginfo('name'))?></span>
						</a>
					</h1>
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
