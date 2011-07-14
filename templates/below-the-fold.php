<div id="below-fold">
	
	<div class="span-7">
		<h2>Parking Updates</h2>
		<?php while(have_posts()): the_post();?>
		<article>
			<h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
			<p><a href="<?php the_permalink();?>"><?php the_excerpt();?></a></p>
		</article>
		<?php endwhile;?>
	</div>
	
	<div class="span-8">
		<h2>Traffic Updates</h2>
		<article>
			<h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
			<p><a href="<?php the_permalink();?>"><?php the_excerpt();?></a></p>
		</article>
	</div>
	
	<div class="span-9 last">
		<div id="search">
			Search
		</div>
		
		<div class="more">
			<h3>More Resources</h3>
			<ul>
				<li><a>Bicycles</a></li>
				<li><a>Carpooling</a></li>
				<li><a>Disability Parking</a></li>
				<li><a>Escort Services</a></li>
				<li><a>Golf Carts</a></li>
				<li><a>KnightLynx</a></li>
				<li><a>Park ‘n’ Ride</a></li>
				<li><a>Parking at UCF</a></li>
				<li><a>Service Vehicles</a></li>
			</ul>
		</div>
	</div>
		
</div>