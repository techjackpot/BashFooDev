<?php

require_once(get_template_directory() . '/lib/vendor/kint/Kint.class.php');

/**
 * Example: Register widget
 *
 * function _usdp_register_widget() {
 *   register_sidebar(array(
 *     // ...
 *   ));
 * }
 * add_action('widgets_init', '_usdp_register_widget');
 */

/**
 * Bind post publishing to LiveReload
 *
 * Works by updating a file in the root called .post_listener
 *
 * @param null
 **/
function update_post_listener()
{
	file_put_contents( get_home_path().'.post_listener', date('U') );
}
if( ENV === 'local' || ENV === 'staging' ) add_action( 'post_updated', 'update_post_listener' );

// Remove Edtior Page From Admin
add_action('admin_init', '_usdp_remove_editor_sub_page_from_admin', 102);
function _usdp_remove_editor_sub_page_from_admin() {
	remove_submenu_page( 'themes.php', 'theme-editor.php' );
	remove_submenu_page( 'plugins.php', 'plugin-editor.php' );
}


// Remove Top Level Menus from admin
function remove_menus() {
	remove_menu_page( 'edit-comments.php' ); //Comments
}
add_action('admin_menu', 'remove_menus');


// Register Addiotional Menu Locations
function _usdp_register_additional_menus() {
  register_nav_menus(
    array(
      'primary-navigation' => __( 'Primary Navigation' ),
      'secondary-navigation' => __( 'Secondary Navigation' ),
      'mobile-navigation' => __( 'Mobile Navigation' )
    )
  );
}
add_action( 'init', '_usdp_register_additional_menus' );

function _usdp_change_login_page() {

	if( function_exists('acf_add_options_sub_page') ) {
		$logo = get_field('logo', 'option');
		$logoURL = $logo['url'];
	?>

		<style>
			body {
				background-color: #FFF;
			}
			.login h1 a {
				background-image: url(<?php echo $logoURL ?>);
				background-size: cover;
		    width: 150px;
		    height: 150px;
		    margin-bottom: 0;
			}
		</style>

<?php }
}
// add_action('login_enqueue_scripts', '_usdp_change_login_page' );

function load_custom_wp_admin_style() {
        wp_register_style( 'custom_wp_admin_css', '/assets/css/lf-icons.css', false, '1.0.0' );
        wp_enqueue_style( 'custom_wp_admin_css' );
}
//add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

/**
* Create function that adds yoast seo breadcrumbs to page where the action is called
**/

add_action('create_breadcrumbs', function() {
  $output = rtrim(yoast_breadcrumb(), '1');
  echo "".$output."";
});
