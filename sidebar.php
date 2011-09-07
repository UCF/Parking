<?php
disallow_direct_load('sidebar.php');
global $short_codes, $parents;

$slug = isset($post->post_parent) ?
	basename(get_permalink($post->post_parent)) :
	basename(get_permalink($post));

if($slug=='citations'): ?>
	<a href="https://secure.parking.ucf.edu/citations/" class="park-button red">Pay Citation</a>
<?php elseif($slug=='permits'): ?>
	<a href="https://secure.parking.ucf.edu/PermitOrder/" class="park-button">Purchase Permits</a>
<?php endif;


if(isset($short_codes['sidebar-content'])) printf('<div id="sidebar-content">%s</div>', $short_codes['sidebar-content']);

if(!function_exists('dynamic_sidebar') or !dynamic_sidebar('Sidebar')):

	if($short_codes['menu']){
		$pages   = $short_codes['menu']['pages'];
		$broken  = $short_codes['menu']['broken'];
		$title   = $short_codes['menu']['title'];
		$anchors = $short_codes['menu']['anchors'];
		
		echo '<div class="side-nav page-menu">';
		if($title) printf('<h2>%s</h2>', $title);
		foreach($broken as $b){
			printf('<!-- %s is not a page -->%s', $b, "\n");
		}
		
		echo '<ul class="light">'."\n";
		foreach($pages as $page){
			$anchor = '';
			if(isset($anchors[$page->ID])){
				$anchor = '#' . $anchors[$page->ID];
			}
			printf('<li><a href="%s%s">%s</a></li>%s', get_permalink($page), $anchor, $page->post_title, "\n");
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