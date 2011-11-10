<?php
	disallow_direct_load('page.php');
	get_header(); 
	the_post();

	// must get content to process shortcodes
	$content = get_the_content();
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]>', $content);
	// remove linebreaks that followed shortcodes
	$content = preg_replace('/^(<br \/>\s+)+/', '', $content);
	$content = preg_replace('/^\s*<\/p>/', '', $content);
	$content = preg_replace('/^\s*<p><\/p>/', '', $content);
	// fix absolute URLs for local dev
	$content = preg_replace('/href="\//', 'href="' . trailingslashit(get_bloginfo('url')), $content);
	
	// shortcode, info-box top
	global $short_codes;
	if(isset($short_codes['top'])){
		printf('<div id="infobox-top" class="rock">%s</div>', $short_codes['top']);
	}

?>


<?php
	global $parents;
	if(!in_array(basename(get_permalink($post)), $parents)):
?>
<div class="page-title">
	<h2><?php the_title();?></h2>
</div>
<?php endif; ?>



<?php if(isset($short_codes['no-sidebar'])): ?>

	<div class="page-content clear">
		<?=$content?>
	</div>

<?php else: ?>

	<div class="span-15 append-1" id="<?=$post->post_name?>">
	
		<div class="page-content">
			<?=$content?>
		</div>
	
	</div>

	<div id="sidebar" class="span-8 last">
		<?=get_sidebar();?>
	</div>
	
	<div class="clear"></div>

<?php endif; ?>
<?php get_template_part('templates/below-the-fold'); ?>
<?php get_footer();?>