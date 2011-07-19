<?php 

/**
 * Empty shortcode
 **/
function sc_empty_shortcode(){
	return 'shortcode';
}
add_shortcode('empty-shortcode', 'sc_empty_shortcode');


/**
 * InfoBoxes short codes
 **/

$all_infoboxes = array();
$boxes = get_posts(array(
	'numberposts' => -1, 
	'post_type'   => 'infobox'
));
foreach($boxes as $box){
	$slug = get_post_meta($box->ID, 'infobox_slug', true);
	if(!$slug){
		continue;
	}
	$content = $box->post_content;
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]>', $content);
	$all_infoboxes[$slug] = $content;
}
function get_infobox($atts){
	// $atts is a list of user-given slugs for infoboxes
	// use each slug to search for an infobox, if match push content into $boxes
	// return a random selection
	global $all_infoboxes;
	$boxes = array();
	foreach($atts as $slug){
		if(isset($all_infoboxes[$slug])){
			$boxes[] = $all_infoboxes[$slug];
		}
	}
	if(count($boxes) > 0) return $boxes[array_rand($boxes)];
	else return false;
}

function sc_infobox_top($atts, $content = null) {
	global $short_codes;
	$short_codes['top'] = get_infobox($atts);
	return '';
}
add_shortcode('infobox-top', 'sc_infobox_top');

function sc_infobox_right($atts, $content = null) {
	global $short_codes;
	$short_codes['right'] = get_infobox($atts);
	return '';
}
add_shortcode('infobox-right', 'sc_infobox_right');


/**
 * Fetches objects defined by arguments passed, outputs the objects according
 * to the toHTML method located on the object.
 **/
function sc_object($attr){
	if (!is_array($attr)){return '';}
	
	$defaults = array(
		'tags'       => '',
		'categories' => '',
		'type'       => '',
		'limit'      => -1,
	);
	$options = array_merge($defaults, $attr);
	
	$tax_query = array(
		'relation' => 'OR',
	);
	
	if ($options['tags']){
		$tax_query[] = array(
			'taxonomy' => 'post_tag',
			'field'    => 'slug',
			'terms'    => explode(' ', $options['tags']),
		);
	}
	
	if ($options['categories']){
		$tax_query[] = array(
			'taxonomy' => 'category',
			'field'    => 'slug',
			'terms'    => explode(' ', $options['categories']),
		);
	}
	
	$query_array = array(
		'tax_query'      => $tax_query,
		'post_status'    => 'publish',
		'post_type'      => $options['type'],
		'posts_per_page' => $options['limit'],
	);
	$query = new WP_Query($query_array);
	
	global $post;
	ob_start();
	?>
	
	<ul class="object-list <?=$options['type']?>">
		<?php while($query->have_posts()): $query->the_post();
		$class = get_custom_post_type($post->post_type);
		$class = new $class;?>
		<li>
			<?=$class->toHTML($post->ID)?>
		</li>
		<?php endwhile;?>
	</ul>
	
	<?php
	$results = ob_get_clean();
	wp_reset_postdata();
	return $results;
}
add_shortcode('sc-object', 'sc_object');
?>