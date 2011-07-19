<div id="below-fold">
	
	<div class="span-7">
		<h2 class="rock">Parking Updates</h2>
		<?php
			$cat = get_category_by_slug('parking');
			if(!$cat->term_id) echo "<!-- Parking Category Missing -->";
			$posts = query_posts( array ( 'cat' => $cat->term_id, 'posts_per_page' => 1 ) );
			if($cat->term_id && count($posts) > 0):
				the_post();
		?>
		<article>
			<h3><a class="bold" href="<?php the_permalink();?>"><?php the_title();?></a></h3>
			<p><a href="<?php the_permalink();?>"><?php the_excerpt();?></a></p>
		</article>
		<?php else: ?>
		<p>There are no parking updates.</p>
		<?php endif; ?>
	</div>
	
	<div class="span-8">
		<h2 class="rock">Traffic Updates</h2>
		<?php
			$cat = get_category_by_slug('traffic');
			if(!$cat->term_id) echo "<!-- Traffic Category Missing -->";
			$posts = query_posts( array ( 'cat' => $cat->term_id, 'posts_per_page' => 1 ) );
			if($cat->term_id && count($posts) > 0):
				the_post();
		?>
		<article>
			<h3><a class="bold" href="<?php the_permalink();?>"><?php the_title();?></a></h3>
			<p><a href="<?php the_permalink();?>"><?php the_excerpt();?></a></p>
		</article>
		<?php else: ?>
		<p>There are no traffic updates.</p>
		<?php endif; ?>
	</div>
	
	<div class="span-9 last">
		<div id="search">
			<?php get_template_part('searchform'); ?>
		</div>
		
		<div class="more">
			<?php
			$locations = get_nav_menu_locations();
			$menu      = @$locations['below-fold-nav'];
			if (!$menu){
				echo "<!-- Below the fold navigation is not set -->";
			} else {
				$menu = wp_get_nav_menu_object($menu);
				printf(
					'<h3 class="rock">%s</h3> %s',
					$menu->name,
					wp_nav_menu(array(
						'menu' => $menu,
						'menu_class' => 'light',
						'echo'       => false
					)));
			} ?>
		</div>
	</div>
		
</div>