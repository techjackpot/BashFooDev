<?php

define('ASSET_REVISION_MANIFEST', $_SERVER['DOCUMENT_ROOT'] . '/assets/rev-manifest.json');

/**
 * Add custom styles
 */
function _usdp_enqueue_css() {

  if( defined('BOOTSTRAP_CSS') ) {
    if( BOOTSTRAP_CSS == 'cdn' ) {
      $styles[] = 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css';
    } elseif ( BOOTSTRAP_CSS == 'custom' ) {
      $styles[] = '/assets/css/bootstrap.min.css';
    }
  }

  if( defined('INCLUDE_FONT_AWESOME') && INCLUDE_FONT_AWESOME == true ) 
    $styles[] = 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css';
  
  if( defined('INCLUDE_IONICONS') && INCLUDE_IONICONS == true ) 
    $styles[] = "http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css";
  

  if(ENV == 'local'){
    $styles[] = '/assets/css/main.css';
  } else {
    $revisions = json_decode( file_get_contents( ASSET_REVISION_MANIFEST ), true );
    $styles[] = '/assets/' . $revisions['css/main.min.css'];
  }

  $styles[] = "/wp-content/plugins/gravityforms/css/datepicker.min.css?ver=2.2.3";

  $styles[] = "https://fonts.googleapis.com/icon?family=Material+Icons";

  foreach ($styles as $i => $style) {
    wp_enqueue_style(sprintf('_usdp_styles_%d', $i), $style);
  }
}

/**
 * Add custom scripts
 *
 * Reworked to Fix Compatibility Issues
 */
function _usdp_enqueue_js() {
  // ex. array( name, source, dependencies, version, load_in_footer )

  // jQuery
  if( defined('INCLUDE_JQUERY') && INCLUDE_JQUERY == true )
  {
    if( !is_admin() && $GLOBALS['pagenow'] != 'wp-login.php' && !isset( $_GET['fl_builder'] ) )
      $scripts[] = ['jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js', null, '3.0.0', false];
      $scripts[] = ['jquery-ui', 'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js', null, '1.12.1', false];
  }

  // Modernizer
  if( defined('INCLUDE_MODERNIZR') && INCLUDE_MODERNIZR == true )
    $scripts[] = ['modernizr', 'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js', null, '2.8.3', false];

  // Bootstrap & Tether
  if( defined('INCLUDE_BOOTSTRAP_JS') && INCLUDE_BOOTSTRAP_JS == true ) {
    $scripts[] = ['tether', 'https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js', null, '1.2.0', true];
    $scripts[] = ['bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js', ['tether'], '4.0.0', true];
  }

  // Vue
  if( defined('INCLUDE_VUE') && INCLUDE_VUE == true )
    $scripts[] = ['vue', 'https://cdnjs.cloudflare.com/ajax/libs/vue/2.0.1/vue.min.js', null, '2.0.1', true];

  // Custom
  if( ENV == 'local' ) {
    $scripts[] = ['main', '/assets/js/main.js', ['jquery', 'bootstrap'], '1.0.0', true];
    $scripts[] = ['livereload', 'http://localhost:35729/livereload.js', null, '1.0.0', true];
  } else {
    $revisions = json_decode( file_get_contents( ASSET_REVISION_MANIFEST ), true );
    $scripts[] = ['main', '/assets/' . $revisions['js/main.min.js'], ['jquery', 'bootstrap'], '1.0.0', true];
  }

  foreach( $scripts as $script ) {
    wp_deregister_script( $script[0] );
    wp_register_script( $script[0], $script[1], $script[2], $script[3], $script[4] );
    wp_enqueue_script( $script[0] );
  }
}

/**
 * Action hook for script enqueue
 */
function _usdp_enqueue_scripts() {
  // Enqueue custom scripts
  _usdp_enqueue_css();
  _usdp_enqueue_js();
}
add_action('wp_enqueue_scripts', '_usdp_enqueue_scripts', 100);
