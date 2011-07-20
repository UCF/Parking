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
	
	// shortcode, info-box top
	global $short_codes;
	if(isset($short_codes['top'])){
		printf('<div id="infobox-top" class="rock">%s</div>', $short_codes['top']);
	}

?>

<div class="span-15 append-1" id="<?=$post->post_name?>">
	
	<div class="page-content">
		<h2><?php the_title();?></h2>
		<?=$content?>
	</div>
	
</div>

<div id="sidebar" class="span-8 last">
	<?=get_sidebar();?>
</div>
	
<div class="clear"></div>
	
<?php get_template_part('templates/below-the-fold'); ?>
<?php get_footer();?>