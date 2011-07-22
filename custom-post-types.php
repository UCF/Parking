<?php

abstract class CustomPostType{
	public 
		$name           = 'custom_post_type',
		$plural_name    = 'Custom Posts',
		$singular_name  = 'Custom Post',
		$add_new_item   = 'Add New Custom Post',
		$edit_item      = 'Edit Custom Post',
		$new_item       = 'New Custom Post',
		$public         = True,  # I dunno...leave it true
		$use_title      = True,  # Title field
		$use_editor     = True,  # WYSIWYG editor, post content field
		$use_revisions  = True,  # Revisions on post content and titles
		$use_tags       = True,  # Tags taxonomy
		$use_categories = False, # Categories taxonomy
		$use_thumbnails = False, # Featured images
		$use_order      = False, # Wordpress built-in order meta data
		$use_metabox    = False, # Enable if you have custom fields to display in admin
		$use_shortcode  = False; # Auto generate a shortcode for the post type (see also toHTML method)
	
	
	/**
	 * Wrapper for get_posts function, that predefines post_type for this
	 * custom post type.  Any options valid in get_posts can be passed as an
	 * option array.  Returns an array of objects.
	 **/
	public function get_objects($options=array()){
		$defaults = array(
			'numberposts'   => -1,
			'orderby'       => 'title',
			'order'         => 'ASC',
			'post_type'     => $this->options('name'),
		);
		$options = array_merge($defaults, $options);
		$objects = get_posts($options);
		return $objects;
	}
	
	
	/**
	 * Similar to get_objects, but returns array of key values mapping post
	 * title to id if available, otherwise it defaults to id=>id.
	 **/
	public function get_objects_as_options($options=array()){
		$objects = $this->get_objects($options);
		$opt     = array();
		foreach($objects as $o){
			switch(True){
				case $this->options('use_title'):
					$opt[$o->post_title] = $o->ID;
					break;
				default:
					$opt[$o->ID] = $o->ID;
					break;
			}
		}
		return $opt;
	}
	
	
	/**
	 * Return the instances values defined by $key.
	 **/
	public function options($key){
		$vars = get_object_vars($this);
		return $vars[$key];
	}
	
	
	/**
	 * Additional fields on a custom post type may be defined by overriding this
	 * method on an descendant object.
	 **/
	public function fields(){
		return array();
	}
	
	
	/**
	 * Using instance variables defined, returns an array defining what this
	 * custom post type supports.
	 **/
	public function supports(){
		#Default support array
		$supports = array();
		if ($this->options('use_title')){
			$supports[] = 'title';
		}
		if ($this->options('use_order')){
			$supports[] = 'page-attributes';
		}
		if ($this->options('use_thumbnails')){
			$supports[] = 'thumbnail';
		}
		if ($this->options('use_editor')){
			$supports[] = 'editor';
		}
		if ($this->options('use_revisions')){
			$supports[] = 'revisions';
		}
		return $supports;
	}
	
	
	/**
	 * Creates labels array, defining names for admin panel.
	 **/
	public function labels(){
		return array(
			'name'          => __($this->options('plural_name')),
			'singular_name' => __($this->options('singular_name')),
			'add_new_item'  => __($this->options('add_new_item')),
			'edit_item'     => __($this->options('edit_item')),
			'new_item'      => __($this->options('new_item')),
		);
	}
	
	
	/**
	 * Creates metabox array for custom post type. Override method in
	 * descendants to add or modify metaboxes.
	 **/
	public function metabox(){
		if ($this->options('use_metabox')){
			return array(
				'id'       => $this->options('name').'_metabox',
				'title'    => __($this->options('singular_name').' Fields'),
				'page'     => $this->options('name'),
				'context'  => 'normal',
				'priority' => 'high',
				'fields'   => $this->fields(),
			);
		}
		return null;
	}
	
	
	/**
	 * Registers metaboxes defined for custom post type.
	 **/
	public function register_metaboxes(){
		if ($this->options('use_metabox')){
			$metabox = $this->metabox();
			add_meta_box(
				$metabox['id'],
				$metabox['title'],
				'show_meta_boxes',
				$metabox['page'],
				$metabox['context'],
				$metabox['priority']
			);
		}
	}
	
	
	/**
	 * Registers the custom post type and any other ancillary actions that are
	 * required for the post to function properly.
	 **/
	public function register(){
		$registration = array(
			'labels'   => $this->labels(),
			'supports' => $this->supports(),
			'public'   => $this->options('public'),
		);
		
		if ($this->options('use_order')){
			$regisration = array_merge($registration, array('hierarchical' => True,));
		}
		
		register_post_type($this->options('name'), $registration);
		
		if ($this->options('use_categories')){
			register_taxonomy_for_object_type('category', $this->options('name'));
		}
		
		if ($this->options('use_tags')){
			register_taxonomy_for_object_type('post_tag', $this->options('name'));
		}
		
		if ($this->options('use_shortcode')){
			add_shortcode($this->options('name').'-list', array($this, 'shortcode'));
		}
	}
	
	
	/**
	 * Shortcode for this custom post type.  Can be overridden for descendants.
	 * Defaults to just outputting a list of objects outputted as defined by
	 * toHTML method.
	 **/
	public function shortcode($attr){
		$default = array(
			'type' => $this->options('name'),
		);
		if (is_array($attr)){
			$attr = array_merge($default, $attr);
		}else{
			$attr = $default;
		}
		return sc_object($attr);
	}
	
	
	/**
	 * Outputs this item in HTML.  Can be overridden for descendants.
	 **/
	public function toHTML($post){
		if (is_int($post)){
			$post = get_post($post);
		}
		
		$html = '<a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a>';
		return $html;
	}
}


class Example extends CustomPostType{
	public 
		$name           = 'example',
		$plural_name    = 'Examples',
		$singular_name  = 'Example',
		$add_new_item   = 'Add New Example',
		$edit_item      = 'Edit Example',
		$new_item       = 'New Example',
		$public         = True,
		$use_categories = True,
		$use_thumbnails = True,
		$use_editor     = True,
		$use_order      = True,
		$use_title      = True,
		$use_shortcode  = True,
		$use_metabox    = True;
	
	public function fields(){
		return array(
			array(
				'name'  => 'Helpy Help',
				'desc'  => 'Help Example, static content to assist the nice users.',
				'id'    => $this->options('name').'_help',
				'type'  => 'help',
			),
			array(
				'name' => 'Text',
				'desc' => 'Text field example',
				'id'   => $this->options('name').'_text',
				'type' => 'text',
			),
			array(
				'name' => 'Textarea',
				'desc' => 'Textarea example',
				'id'   => $this->options('name').'_textarea',
				'type' => 'textarea',
			),
			array(
				'name'    => 'Select',
				'desc'    => 'Select example',
				'default' => '(None)',
				'id'      => $this->options('name').'_select',
				'options' => array('Select One' => 1, 'Select Two' => 2,),
				'type'    => 'select',
			),
			array(
				'name'    => 'Radio',
				'desc'    => 'Radio example',
				'id'      => $this->options('name').'_radio',
				'options' => array('Key One' => 1, 'Key Two' => 2,),
				'type'    => 'radio',
			),
			array(
				'name'  => 'Checkbox',
				'desc'  => 'Checkbox example',
				'id'    => $this->options('name').'_checkbox',
				'type'  => 'checkbox',
			),
		);
	}
}


class InfoBox extends CustomPostType{
	public 
		$name           = 'infobox',
		$plural_name    = 'Info Boxes',
		$singular_name  = 'Info Box',
		$add_new_item   = 'Add Information Box',
		$edit_item      = 'Edit Information Box',
		$new_item       = 'New Information Box',
		$public         = True,
		$use_categories = False,
		$use_thumbnails = False,
		$use_editor     = True,
		$use_order      = False,
		$use_title      = True,
		$use_shortcode  = True,
		$use_metabox    = True;
	
	public function fields(){
		return array(
			array(
				'name' => 'Slug',
				'desc' => 'Unique identifier for this Information Box (used with the shortcode)',
				'id'   => $this->options('name').'_slug',
				'type' => 'text',
			),
			array(
				'name'  => 'Example Information Boxes',
				'desc'  => 'Question/Answer:
							<br><code>
								&lt;strong&gt;Question&lt;/strong&gt;: What is the number one reason citations are given?&lt;br&gt;<br>
								&lt;strong&gt;Answer&lt;/strong&gt;: Parking in the wrong lot. &lt;span&gt;People just don&rsquo;t obey signs and park in the wrong lots.&lt;/span&gt;
							</code>
							<br><br>
							Factoid:<br>
							<code>
								&lt;h2&gt;Did you Know?&lt;/h2&gt;<br>
								The registered owner of the permit is responsible for all violations. So don&rsquo;t share your permit, you may end up paying your friend&rsquo;s citation.
							</code>',
				'id'    => $this->options('name').'_help',
				'type'  => 'help',
			),
		);
	}
}


/**
 * Header alert message. (.e.g. traffic advisory, severe weather)
 **/
class Alert extends CustomPostType{
	public 
		$name           = 'alert',
		$plural_name    = 'Alerts',
		$singular_name  = 'Alert',
		$add_new_item   = 'Add New Alert',
		$edit_item      = 'Edit Alert',
		$new_item       = 'New Alert',
		$use_thumbnails = False,
		$use_tags       = False,
		$use_metabox    = True;
		
	public function fields() {
		$prefix = $this->options('name').'_';
		return array(
			array(
				'name'		=> 'Alert Type',
				'desc'		=> '',
				'id'		=> $prefix.'type',
				'type'		=> 'select',
				'options'	=> array('Information (styled blue)' => 'info', 'Advisory (styled orange)' => 'advisory', 'Severe (styled red)' => 'severe'),
				'std'		=> 'advisory'
			),
		);
	}
}

