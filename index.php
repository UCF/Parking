<?php get_header();?>

<div class="page-content" id="post-list">
	
	<div class="span-15">
		
		<?php if (is_home() || is_front_page() ): ?>
		<div id="home-menu">
			<ul>
				<li><a href="" class="light" id="home-perm">Permits</a></li>
				<li><a href="" class="light" id="home-cita">Citations</a></li>
				<li><a href="" class="light" id="home-shut">Shuttles</a></li>
				<li><a href="" class="light" id="home-rule">Rules</a></li>
				<li><a href="" class="light" id="home-mail">Contact</a></li>
				<li><a href="" class="light" id="home-form">Forms</a></li>
			</ul>
			<div class="clear"></div>
		</div>
		<?php endif; ?>
			
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
	<div class="span-9 last">
		<?=get_sidebar();?>
	</div>
	
	<div class="clear"></div>
	<?php get_template_part('templates/below-the-fold'); ?>
	
</div>


<?php get_footer();?>