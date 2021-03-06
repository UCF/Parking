<!DOCTYPE html>
<html lang="en-US">
	<head>
		<?="\n".header_()."\n"?>
		<!--[if IE]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<style>article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section {display: block;}</style>
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
				<div class="span-14">
					<h1 class="light">Parking and <br>Transportation</h1>
				</div>
				<div class="span-10 last">
					<?=gen_alerts_html()?>
				</div>
				<div class="clear"></div>
			</div>


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
								global $parents;
								if(in_array($slug, $parents))
									printf('%s<span>%s</span>',
										ucwords($slug),
										str_replace('UCF', '', get_bloginfo('name')));
								else
								 	print 'Parking and <br>Transportation';
							?>
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
