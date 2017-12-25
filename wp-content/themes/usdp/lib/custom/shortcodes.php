<?php

/**
 * Example: Render Twig shortcode template
 *
 * function _usdp_render_twig_shortcode($atts) {
 *   if (is_string($atts)) $atts = array();
 *
 *   ob_start();
 *   Timber::render('shortcodes/example.twig', $atts);
 *   return ob_get_clean();
 * }
 * add_shortcode('example', '_usdp_render_twig_shortcode');
 */