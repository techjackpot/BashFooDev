<?php

// Base functions
require_once(locate_template('/lib/activate.php'));          			// Theme activation
require_once(locate_template('/lib/config.php'));            			// Configuration
require_once(locate_template('/lib/init.php'));              			// Initialization
require_once(locate_template('/lib/scripts.php'));           			// Stylesheets and JavaScripts

// Custom functions
require_once(locate_template('/lib/custom/shortcodes.php')); 			// Shortcodes
require_once(locate_template('/lib/custom/helpers.php'));    			// Helpers
require_once(locate_template('/lib/custom/actions.php'));    			// Actions
require_once(locate_template('/lib/custom/filters.php'));    			// Filters
// require_once(locate_template('/lib/custom/admin/options-markup.php')); 	// Options Markup Support
// require_once(locate_template('/lib/custom/options.php')); 	 			// Options
require_once(locate_template('/lib/custom/posttypes.php')); 	 		// Post Types
require_once(locate_template('/lib/custom/taxonomies.php')); 	 		// Taxonomies
require_once(locate_template('/lib/custom/ajax.php')); 	 		        // AJAX
// require_once(locate_template('/lib/custom/rest.php'));                         //rest endpoint

// Woocommerce
// if ( class_exists( 'WooCommerce' ) ) {
// 	require_once(locate_template('/lib/custom/woocommerce.php'));		// Woocommerce
// }

// SEO
require_once(locate_template('/lib/custom/rewrites.php'));	 			// Rewrites


add_shortcode( 'SPECF', 'specification_shortcode' );

function specification_shortcode($attr){
 
    $data='';
    foreach($attr as $at){
      $data .= $at . ' ';
    }
   $i=0;
   $data=explode('|',$data);
   $return='';
   foreach($data as $dt){
      if($i==0){
         $return .='<div class="col-xs-12 col-sm-4"><b>'. $dt .' </b></div>';
      }else{

	$return .='<div class="col-xs-12 col-sm-4">'. $dt .' </div>';	
      }
       if($i++==count($data)-1){
		$return .='<div class="clearfix visible-xs xsbormar"></div>';
       }

   }	

   return $return; //die;

}
