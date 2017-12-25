<?php

// Theme support
function _usdp_custom_theme_supports($supports) {
  $supports = array_merge($supports, array(
    'post-thumbnails',
    'menus'
  ));

  return $supports;
}
add_filter('_usdp_theme_supports', '_usdp_custom_theme_supports', 10, 1);

// Thumbnail sizes
function _usdp_custom_image_sizes($sizes) {
  // Example:
  // $sizes['category-thumb'] => array(300, 300);

  return $sizes;
}
add_filter('_usdp_image_sizes', '_usdp_custom_image_sizes', 10, 1);