<?php disallow_direct_load('sidebar.php');?>

<?php if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Sidebar')):?>
	
	
	<?php
	
	$locations = get_nav_menu_locations();
	
	// sidebar nav one
	$menu      = @$locations['sidebar-nav-one'];
	if (!$menu){
		echo "<!-- Sidebar Nav One is not set -->";
	} else {
		$menu = wp_get_nav_menu_object($menu);
		printf(
			'<div class="side-nav"> <h2>%s</h2> %s </div>',
			$menu->name,
			wp_nav_menu(array(
				'menu' => $menu,
				'menu_class' => 'light',
				'echo'       => false
			)));
	}
	
	// sidebar nav two
	$menu = @$locations['sidebar-nav-two'];
	if (!$menu){
		echo "<!-- Sidebar Nav Two is not set -->";
	} else {
		$menu = wp_get_nav_menu_object($menu);
		printf(
			'<div class="side-nav"> <h2>%s</h2> %s </div>',
			$menu->name,
			wp_nav_menu(array(
				'menu' => $menu,
				'menu_class' => 'light',
				'echo'       => false
			)));
	}
	?>
	
	
<?php endif;?>