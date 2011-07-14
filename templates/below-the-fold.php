<div id="below-fold">
	<?php while(have_posts()): the_post();?>
	<article>
		<h1><a href="<?php the_permalink();?>"><?php the_title();?></a></h1>
		<div class="meta">
			<span class="date">Posted on <?php the_time("F j, Y");?></span>
			<span class="author">by <?php the_author_posts_link();?></span>
		</div>
		<?php the_excerpt();?>
	</article>
	<?php endwhile;?>
</div>