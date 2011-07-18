<div id="below-fold">
	
	<div class="span-7">
		<h2 class="rock">Parking Updates</h2>
		<?php while(have_posts()): the_post();?>
		<article>
			<h3><a class="bold" href="<?php the_permalink();?>"><?php the_title();?></a></h3>
			<p><a href="<?php the_permalink();?>"><?php the_excerpt();?></a></p>
		</article>
		<?php endwhile;?>
	</div>
	
	<div class="span-8">
		<h2 class="rock">Traffic Updates</h2>
		<article>
			<h3><a class="bold" href="<?php the_permalink();?>"><?php the_title();?></a></h3>
			<p><a href="<?php the_permalink();?>"><?php the_excerpt();?></a></p>
		</article>
	</div>
	
	<div class="span-9 last">
		<div id="search">
			<?php get_template_part('searchform'); ?>
		</div>
		
		<div class="more">
			<h3 class="rock">More Resources</h3>
			<?php
			wp_nav_menu(array(
				'menu' => 'More Resources',
				'menu_class' => 'light'
			)); ?>
			
			
			<ul>
				<li><a href="" class="light">Bicycles</a></li>
				<li><a href="" class="light">Carpooling</a></li>
				<li><a href="" class="light">Disability Parking</a></li>
				<li><a href="" class="light">Escort Services</a></li>
				<li><a href="" class="light">Golf Carts</a></li>
				<li><a href="" class="light">KnightLynx</a></li>
				<li><a href="" class="light">Park ‘n’ Ride</a></li>
				<li><a href="" class="light">Parking at UCF</a></li>
				<li><a href="" class="light">Service Vehicles</a></li>
			</ul>
		</div>
	</div>
		
</div>