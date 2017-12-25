<?php

add_action( 'init', function() {

	$labels = array(
		'name'                  => 'Equipment',
		'singular_name'         => 'Equipment',
		'menu_name'             => 'Equipment',
		'name_admin_bar'        => 'Equipment',
		'archives'              => 'Equipment Archives',
		'attributes'            => 'Equipment Attributes',
		'parent_item_colon'     => 'Parent Equipment:',
		'all_items'             => 'All Equipment',
		'add_new_item'          => 'Add New Equipment',
		'add_new'               => 'Add New',
		'new_item'              => 'New Equipment',
		'edit_item'             => 'Edit Equipment',
		'update_item'           => 'Update Equipment',
		'view_item'             => 'View Equipment',
		'view_items'            => 'View Equipment',
		'search_items'          => 'Search Equipment',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => 'Insert into equipment',
		'uploaded_to_this_item' => 'Uploaded to this equipment',
		'items_list'            => 'Equipment list',
		'items_list_navigation' => 'Equipment list navigation',
		'filter_items_list'     => 'Filter equipment list',
	);
	$args = array(
		'label'                 => 'Equipment',
		'description'           => 'A post type for Rental Equipment',
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-hammer',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => false,
	);
	register_post_type( 'equipment', $args );

}, 0 );