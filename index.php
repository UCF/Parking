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