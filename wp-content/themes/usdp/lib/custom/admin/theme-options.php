<?php

// Remove Dashboard Meta Boxes 
function customize_dashboard() {
	remove_action( 'welcome_panel', 'wp_welcome_panel' );
	remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); // Quick Press Widget
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side'); // Recent Drafts
	remove_meta_box('dashboard_primary', 'dashboard', 'side'); // WordPress.com Blog
	remove_meta_box('dashboard_secondary', 'dashboard', 'side'); // WordPress News
	remove_meta_box('dashboard_activity', 'dashboard', 'normal'); // Recent Comments
}
add_action('wp_dashboard_setup', 'customize_dashboard');

function remove_admin_bar_links() {
	global $wp_admin_bar;

	$wp_admin_bar->remove_menu( 'wp-logo' );
}
add_action('wp_before_admin_bar_render', 'remove_admin_bar_links');


// If the Options add-on is installed and active ....
if( function_exists('acf_add_options_sub_page') )
{

	acf_set_options_page_title( 'Theme Options' ); // Create 'Theme Options' options page
		
	acf_add_options_sub_page(array( // Create sub page of 'Theme Options' named 'Theme Specific'
		'title' 	=> 'Theme Specific'
	));

	acf_add_options_sub_page(array( // Create sub page of 'Theme Options' named 'Custom Post Types'
		'title' 	=> 'Custom Post Types'
	));
		
}

// Register CPT Field Group
// NOTE: Registered field groups will NOT appear in the list of editable field groups. 
if(function_exists("register_field_group"))
{
	// var_dump("here **********");
	register_field_group(array (
		'id' => 'acf_custom-post-types',
		'title' => 'Custom Post Types',
		'fields' => array (
			array (
				'key' => 'field_56322e7cd7d7f',
				'label' => 'Custom Post Type',
				'name' => 'custom_post_type',
				'type' => 'repeater',
				'sub_fields' => array (
					array (
						'key' => 'field_56322e8cd7d80',
						'label' => 'Name',
						'name' => 'name',
						'type' => 'text',
						'instructions' => 'General Name',
						'required' => 1,
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_56322e9dd7d81',
						'label' => 'Singular Name',
						'name' => 'singular_name',
						'type' => 'text',
						'instructions' => 'Singular Name',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_56322eb5d7d82',
						'label' => 'Menu Icon',
						'name' => 'menu_icon',
						'type' => 'text',
						'instructions' => 'Pick an icon from https://developer.wordpress.org/resource/dashicons/#align-left. Leave out \'dashicons\'.',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => 'Example: chart-bar',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_56322edad7d83',
						'label' => 'Supports',
						'name' => 'supports',
						'type' => 'checkbox',
						'required' => 1,
						'column_width' => '',
						'choices' => array (
							'title' => 'title',
							'editor' => 'editor',
							'author' => 'author',
							'thumbnail' => 'thumbnail',
							'excerpt' => 'excerpt',
							'trackbacks' => 'trackbacks',
							'custom-fields' => 'custom-fields',
							'comments' => 'comments',
							'revisions' => 'revisions',
							'page-attributes' => 'page-attributes',
							'post-formats' => 'post-formats',
						),
						'default_value' => '',
						'layout' => 'horizontal',
					),
					array (
						'key' => 'field_56322f00d7d84',
						'label' => 'Has Archive',
						'name' => 'has_archive',
						'type' => 'true_false',
						'instructions' => 'Check for True. Uncheck for False.',
						'column_width' => '',
						'message' => '',
						'default_value' => 1,
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'row',
				'button_label' => 'Add Custom Post Type',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'acf-options-custom-post-types',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_theme-specific-options',
		'title' => 'Theme Specific Options',
		'fields' => array (
			array (
				'key' => 'field_56322a924a5ea',
				'label' => 'Logo',
				'name' => 'logo',
				'type' => 'image',
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'acf-options-theme-specific',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}




// If a custom post type (CPT) is created from the admin using theme options, loop through each CPT including its fields and values.
// Create the custom post type

// if( have_rows('custom_post_type', 'option') ) {

// 	while( have_rows('custom_post_type', 'option') ): the_row();

// 		$name = get_sub_field('name'); // Post type general name
// 		$lowerCaseName = strtolower($name); // Same as above, but lowercase
// 		$createCPT = "create_".$lowerCaseName; // Used in the add_action and function name
// 		$singular_name = get_sub_field('singular_name'); // Post type singular name
// 		$menu_icon = get_sub_field('menu_icon'); // Get post icon from repeater field
// 		$icon = 'dashicons-'.$menu_icon; // Add 'dashicons' to icon name
// 		$supports_array = get_sub_field('supports'); // What will the CPT support
// 		$archive = get_sub_field('has_archive'); // Will the CPT have an archive
// 		if($archive == 1){
// 			$archive = 'true';
// 		} else {
// 			$archive = 'false';
// 		}

// 		$labels = array(
// 			'name' => _x($name, 'post type general name'),
// 			'singular_name' => _x( $singular_name, 'post type singular name'),
// 			'add_new' => _x('Add New', $name),
// 			'add_new_item' => __('Add new '.$name),
// 			'edit_item' => __('Edit '.$singular_name),
// 			'new_item' => __('New '.$singular_name),
// 			'view_item' => __('View '.$singular_name),
// 			'search_items' => __('Search '.$lowerCaseName),
// 			'not_found' =>  __('No '.$lowerCaseName. ' found'),
// 			'not_found_in_trash' => __('No '.$lowerCaseName.' found in Trash'),
// 			'parent_item_colon' => ''
// 		);

// 		$supports = $supports_array;

// 		register_post_type( $lowerCaseName,
// 		  array(
// 		    'labels' => $labels,
// 		    'public' => true,
// 		    'menu_icon' => $icon,
// 		    'supports' => $supports_array,
// 		    'rewrite' => array('slug' => $lowerCaseName),
// 		    'hierarchical' => true,
// 		    'has_archive' => $archive
// 		  )
// 		);

// 	endwhile;

// }

// Change the login logo URL and title
function change_login_logo_url() {
	return home_url();
}

function change_login_logo_url_title() {
	return "US Digital Partners";
}

add_filter('login_headerurl', 'change_login_logo_url');
add_filter('login_headertitle', 'change_login_logo_url_title');

