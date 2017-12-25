<?php

// Constants
define('RELATIVE_PLUGIN_PATH',  str_replace(home_url() . '/', '', plugins_url()));
define('RELATIVE_CONTENT_PATH', str_replace(home_url() . '/', '', content_url()));
define('THEME_NAME', get_template());
define('THEME_PATH', RELATIVE_CONTENT_PATH . '/themes/' . THEME_NAME);
define('UPLOADS_PATH', RELATIVE_CONTENT_PATH . '/uploads/');

// Register theme support
$theme_supports = apply_filters('_usdp_theme_supports', array());
foreach ($theme_supports as $i => $theme_support) {
  add_theme_support($theme_support);
}

// Register image thumbnail sizes
$image_sizes = apply_filters('_usdp_image_sizes', array());
foreach ($image_sizes as $name => $size) {
  if (count($size) != 2) continue;
  add_image_size($name, $size[0], $size[1]);
}


add_action('init',function() { 
	if (session_status() == PHP_SESSION_NONE) session_start();
	// session_destroy();
	if(empty($_SESSION['cart_count'])) $_SESSION['cart_count'] = 0;
	if(empty($_SESSION['quote'])) $_SESSION['quote'] = array();
} );