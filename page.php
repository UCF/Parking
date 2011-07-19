<?php disallow_direct_load('page.php');?>
<?php get_header(); the_post();?>


<?php get_template_part('templates/info-question'); ?>

<div class="span-15 append-1" id="<?=$post->post_name?>">
	
	<div class="page-content">
		<h2><?php the_title();?></h2>
		<?php the_content();?>
	</div>
	
</div>

<div id="sidebar" class="span-8 last">
	<?=get_sidebar();?>
</div>
	
<div class="clear"></div>
	
<?php get_template_part('templates/below-the-fold'); ?>
<?php get_footer();?>