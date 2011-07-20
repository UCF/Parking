<?php
disallow_direct_load('sidebar.php');
global $short_codes;

if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Sidebar')):

	if($short_codes['menu']){
		$pages  = $short_codes['menu']['pages'];
		$broken = $short_codes['menu']['broken'];
		$title  = $short_codes['menu']['title'];
		
		echo '<div class="side-nav page-menu">';
		if($title) printf('<h2>%s</h2>', $title);
		foreach($broken as $b){
			printf('<!-- %s is not a page -->%s', $b, "\n");
		}
		
		echo "<ul>\n";
		foreach($pages as $page){
			printf('<li><a href="%s">%s</a></li>%s', get_permalink($page), $page->post_title, "\n");
		}
		echo "</ul></div>\n";
		
	} else {
		
	
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
	
	} // end right-menus
	
	/* shortcode, info-box right */
	if(isset($short_codes['right'])) 
		printf('<div id="infobox-right" class="rock">%s</div>', $short_codes['right']);
	

endif;