<?php
# Define stuff
define('THEME_URL', get_bloginfo('stylesheet_directory'));
define('THEME_DIR', get_stylesheet_directory());
define('THEME_STATIC_URL', THEME_URL.'/static');
define('THEME_IMG_URL', THEME_STATIC_URL.'/img');
define('THEME_JS_URL', THEME_STATIC_URL.'/js');
define('THEME_CSS_URL', THEME_STATIC_URL.'/css');
define('THEME_OPTIONS_GROUP', 'settings');
define('THEME_OPTIONS_NAME', 'theme');
define('THEME_OPTIONS_PAGE_TITLE', 'Theme Options');

require_once('functions-base.php');     # Base theme functions
require_once('custom-post-types.php');  # Where per theme post types are defined
require_once('shortcodes.php');         # Per theme shortcodes
require_once('functions-admin.php');    # Admin/login functions

$theme_options = get_option(THEME_OPTIONS_NAME);

define('GA_ACCOUNT', $theme_options['ga_account']);
define('GW_VERIFY', $theme_options['gw_verify']);
define('CB_UID', $theme_options['cb_uid']);
define('CB_DOMAIN', $theme_options['cb_domain']);

/**
 * Set config values including meta tags, registered custom post types, styles,
 * scripts, and any other statically defined assets that belong in the Config
 * object.
 **/
Config::$custom_post_types = array(
	'InfoBox', 'Alert',
);

Config::$body_classes = array();

/**
 * Configure theme settings, see abstract class Field's descendants for
 * available fields. -- functions-base.php
 **/
Config::$theme_settings = array(
	new TextField(array(
		'name'        => 'Google Analytics Account',
		'id'          => THEME_OPTIONS_NAME.'[ga_account]',
		'description' => 'Example: <em>UA-9876543-21</em>. Leave blank for development.',
		'default'     => null,
		'value'       => $theme_options['ga_account'],
	)),
	new TextField(array(
		'name'        => 'Google WebMaster Verification',
		'id'          => THEME_OPTIONS_NAME.'[gw_verify]',
		'description' => 'Example <em>9Wsa3fspoaoRE8zx8COo48-GCMdi5Kd-1qFpQTTXSIw</em>',
		'default'     => null,
		'value'       => $theme_options['gw_verify'],
	)),
	new TextField(array(
		'name'        => 'Chartbeat UID',
		'id'          => THEME_OPTIONS_NAME.'[cb_uid]',
		'description' => 'Example <em>1842</em>',
		'default'     => null,
		'value'       => $theme_options['cb_uid'],
	)),
	new TextField(array(
		'name'        => 'Chartbeat Domain',
		'id'          => THEME_OPTIONS_NAME.'[cb_domain]',
		'description' => 'Example <em>some.domain.com</em>',
		'default'     => null,
		'value'       => $theme_options['cb_domain'],
	)),
);

/**
 * Configure theme settings, see abstract class Field's descendants for
 * available fields. -- functions-base.php
 **/

Config::$links = array(
	array('rel' => 'shortcut icon', 'href' => THEME_IMG_URL.'/favicon.ico',),
	array('rel' => 'alternate', 'type' => 'application/rss+xml', 'href' => get_bloginfo('rss_url'),),
);

Config::$styles = array(
	array('admin' => True, 'src' => THEME_CSS_URL.'/admin.css',),
	'http://universityheader.ucf.edu/bar/css/bar.css',
	THEME_CSS_URL.'/jquery-ui.css',
	THEME_CSS_URL.'/jquery-uniform.css',
	THEME_CSS_URL.'/blueprint-screen.css',
	array('media' => 'print', 'src' => THEME_CSS_URL.'/blueprint-print.css',),
	THEME_CSS_URL.'/yahoo-reset.css',
	THEME_CSS_URL.'/yahoo-fonts.css',
	THEME_CSS_URL.'/webcom-base.css',
	get_bloginfo('stylesheet_url'),
);

Config::$scripts = array(
	array('admin' => True, 'src' => THEME_JS_URL.'/admin.js',),
	'http://universityheader.ucf.edu/bar/js/university-header.js',
	array('name' => 'jquery', 'src' => 'http://code.jquery.com/jquery-1.6.1.min.js',),
	THEME_JS_URL.'/jquery-ui.js',
	THEME_JS_URL.'/jquery-browser.js',
	THEME_JS_URL.'/jquery-uniform.js',
	array('name' => 'theme-script', 'src' => THEME_JS_URL.'/script.js',),
);

Config::$metas = array(
	array('charset' => 'utf-8',),
);
if ((bool)$theme_options['gw_verify']){
	Config::$metas[] = array(
		'name'    => 'google-site-verification',
		'content' => htmlentities($theme_options['gw_verify']),
	);
}



/**
 * Parking Contents
 **/
register_nav_menu('home-navigation', "Home Navigation");
register_nav_menu('sidebar-nav-one', "Sidebar Nav One");
register_nav_menu('sidebar-nav-two', "Sidebar Nav Two");
register_nav_menu('below-fold-nav' , "Below the Fold Navigation");

define('ALERT_COOKIE_NAME', 'parking_alerts');
add_image_size('alert', 47, 49, True);
function gen_alerts_html()
{		
		$alerts 		= get_posts(Array('post_type' => 'alert'));
		$hidden_alerts	= Array();
		$alerts_html 	= '';
		
		// Parse hidden alerts from cookie
		if(isset($_COOKIE[ALERT_COOKIE_NAME])) {
			$raw_hidden_alerts = explode(',', htmlspecialchars($_COOKIE[ALERT_COOKIE_NAME]));
			foreach($raw_hidden_alerts as $alert_data) {
				$alert = explode('-', $alert_data);
				if(count($alert) == 2) {
					$hidden_alerts[$alert[0]] = $alert[1]; // post_id -> post_time
				}
			}
		}
		
		if(count($alerts) < 1) return;
		
		foreach($alerts as $alert) {
			
			$text       = get_post_meta($alert->ID, 'alert_text', True);
			$link_text  = get_post_meta($alert->ID, 'alert_link_text', True);
			$link_url   = get_post_meta($alert->ID, 'alert_link_url', True);
			$type       = get_post_meta($alert->ID, 'alert_type', True);
			$bg_color   = get_post_meta($alert->ID, 'alert_bg_color', True);
			$text_color = get_post_meta($alert->ID, 'alert_text_color', True);
			
			$css_clss           = Array($type);
			$li_inline_styles   = Array();
			$span_inline_styles = Array();
			
			$link_html = ($link_text && $link_url) ? "<a href=\"$link_url\">$link_text</a>" : '';
			
			$thumbnail_id = get_post_thumbnail_id($alert->ID);
			if($thumbnail_id != '') {
				$thumbnail = wp_get_attachment_image_src($thumbnail_id, 'alert');
				array_push($li_inline_styles, 'background-image: url('.$thumbnail[0].');');
			}
			
			if($bg_color != '') {
				if(substr($bg_color, 0, 1) != '#') {
					$bg_color = '#'.$bg_color;
				}
				array_push($span_inline_styles, 'background-color: '.$bg_color.';');
			}
			if($text_color != '') {
				if(substr($text_color, 0, 1) != '#') {
					$text_color = '#'.$text_color;
				}
				array_push($span_inline_styles, 'color: '.$text_color.';');
			}
			
			
			// Even if alert is hidden, show it if it's updated
			if(isset($hidden_alerts[$alert->ID]) && strtotime($alert->post_modified) <= $hidden_alerts[$alert->ID]) {
				array_push($css_clss, 'hide');
			}
			
		 	$alert_html = '<li style="'.implode(' ',$li_inline_styles).'" class="'.implode(' ',$css_clss).'" id="alert-'.$alert->ID.'-'.strtotime($alert->post_modified).'">
								<span class="msg" style="'.implode(' ', $span_inline_styles).'">
									'.$text.'
									'.$link_html.'
									<a class="close">Close</a>
								</span>
							</li>';
			$alerts_html .= $alert_html."\n";
		}
		
		return '<ul id="alerts" class="span-24">' . $alerts_html . '</ul>';
}

