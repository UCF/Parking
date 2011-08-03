<?php @header("HTTP/1.1 404 Not found", true, 404);?>
<?php disallow_direct_load('404.php');?>

<?php get_header(); the_post();?>
	<div class="page-content" id="page-not-found">
		<h2>Page Not Found</h2>
		<p>The page you requested doesn't exist.  Sorry about that, did you try the search?</p>
	</div>
	
	<?php get_template_part('templates/below-the-fold'); ?>

<?php get_footer();?>