<?php

/**@+
 *
 * CUSTOM THEME OPTIONS
 *
 * Add custom menu and submenu pages by configuring the 
 * functions and registering the respective pages in the 
 * _custom_options_pages call
 *
 **@+*/

add_action('admin_menu', '_usdp_custom_options_pages');
function _usdp_custom_options_pages() {
	
	/** parent_page | Title, Menu Title, Permissions, Page, Callback, Menu Icon, Order **/
	add_menu_page('USDP Options', 'USDP Options', 'manage_options', 'functions', '_usdp_general_options_markup', 'dashicons-menu', 1);
	
	/** child_page | Parent, Title, Menu Title, Permissions, Slug, Callback, Menu Icon, Order **/
	add_submenu_page( 'functions', 'Archive', 'Archive', 'manage_options', 'archive-options', '_usdp_general_options_submenu_markup', 'dashicons-gear', 1);
}

/**
 * General Options Menu page configuration | THIS IS THE GENERAL MARKUP FOR OPTIONS PAGE CREATION
 * @param null
 * @return null
 */
function _usdp_general_options_markup(){
	
	/** START REQUIRED **/
	$title = "USDP Theme Options";
	$description = "Configure the basic theme settings here.";
	$theme_options = array(
		"USDP Example" => array(
			"Example Text" => array( "text", "example_options_text", "This is the description text. OPTIONAL"),
			"Example Textarea" => array( "textarea", "example_options_textarea", "This is the description text. OPTIONAL" ),
			"Example Checkbox" => array( "checkbox", "example_options_checkbox", "This is the description text. OPTIONAL"),
			"Example Image" => array( "image", "example_options_image", "This is the description text. OPTIONAL"),
			"Example Select" => array( 
				"select", "example_options_select", "This is the description text. OPTIONAL",
				array( 
					["select_option_value_1", "Select Option Name 1"],
					["select_option_value_2", "Select Option Name 2"]
				) 
			)
		) // APPEND ADDITIONAL OPTIONS SECTIONS USING ABOVE MARKUP STRUCTURE
	);
	/** END REQUIRED **/

	$page_options_string = _usdp_generate_options_string($theme_options);
	_usdp_generate_options_page_markup($title, $description, $theme_options, $page_options_string);
}

/**
 * General Options Submenu page configuration
 * @param null
 * @return null
 */
function _usdp_general_options_submenu_markup(){
	
	/** START REQUIRED **/
	$title = "USDP Theme Options Submenu Page";
	$description = "An example submenu page setup.";
	$theme_options = array(
		"USDP Example" => array(
			"Example Text" => array( "text", "example_options_text", "This is the description text. OPTIONAL"),
			"Example Textarea" => array( "textarea", "example_options_textarea", "This is the description text. OPTIONAL" ),
			"Example Checkbox" => array( "checkbox", "example_options_checkbox", "This is the description text. OPTIONAL"),
			"Example Image" => array( "image", "example_options_image", "This is the description text. OPTIONAL"),
			"Example Select" => array( 
				"select", "example_options_select", "This is the description text. OPTIONAL",
				array( 
					["select_option_value_1", "Select Option Name 1"],
					["select_option_value_2", "Select Option Name 2"]
				) 
			)
		)
	);
	/** END REQUIRED **/

	$page_options_string = _usdp_generate_options_string($theme_options);
	_usdp_generate_options_page_markup($title, $description, $theme_options, $page_options_string);
}