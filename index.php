<?php get_header();?>

<div class="page-content" id="post-list">

	<div class="span-15">
		
		<?php if (is_home() || is_front_page() ): ?>
		<div id="home-menu">
			
			<?php
			
			$locations = get_nav_menu_locations();
			$menu      = @$locations['home-navigation'];
			if (!$menu) {
				echo "<div class='error'>Home Page Navigation not defined</div>";
			} else {
				
				echo '<ul class="light">';
				$items = wp_get_nav_menu_items($menu);
				foreach($items as $key=>$item){
					printf(
						'<li><a href="%s" id="home-%s">%s</a></li>',
						$item->url,
						basename($item->url),
						$item->title
					);
				}
				echo '</ul>';
			
			} ?>
			
			<div class="clear"></div>
		</div>
		<?php else: ?>
			<a href="/">Back to home.</a>
		<?php endif; ?>
	</div>
	
	<div class="span-9 last">
		<?=get_sidebar();?>
	</div>
	
	<div class="clear"></div>
	<?php get_template_part('templates/below-the-fold'); ?>
	
</div>


<?php get_footer();?>