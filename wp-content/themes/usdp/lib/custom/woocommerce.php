<?php 

/**
 * Additional woocommerce setup
 *
 */

/**
 * REQUIRED | Timber Filter to retrieve correct product image in archive loop
 *
 * @param $post object
 */
function timber_set_product( $post ) {
    global $product;
    if ( is_woocommerce() ) {
        $product = get_product($post->ID);
    }
}

/**
 * Navigation Cart Icon - add to timber context
 *
 * @param global $context
 * @return obj $context
 */
function _add_woo_cart_to_context( $context )
{
	global $woocommerce;
	$context['woo_cart'] = array(
		'cart_url' => $woocommerce->cart->get_cart_url(),
		'shop_url' => get_permalink( woocommerce_get_page_id( 'shop' ) ),
		'cart_contents' => $woocommerce->cart->cart_contents,
		'cart_contents_count' => $woocommerce->cart->cart_contents_count,
		'cart_total' => $woocommerce->cart->get_cart_total()
	);
	return $context;
}
add_filter( 'timber_context', '_add_woo_cart_to_context' );

/**
 * Change varaible product 'Select Options' text
 *
 * @param null
 * @return str
 */
function _variable_product_add_to_cart_text()
{
	global $product;
	if( $product->product_type == 'variable' )	return __( 'Buy Now', 'woocommerce' );
}
// add_filter( 'woocommerce_product_add_to_cart_text' , '_variable_product_add_to_cart_text' );

/**
 * Append content to Shop Loop items
 *
 * @param null
 * @return mixed
 */
function _append_to_shop_loop_item()
{
	global $woocommerce;
	$methods = $woocommerce->shipping->load_shipping_methods();
	if( $methods['free_shipping']->enabled == 'yes' ) {
		echo '<span class="special">Special Offer - <strong class="text-danger uppercase">Free Shipping</strong></span>';
	}
}
// add_action( 'woocommerce_after_shop_loop_item', '_append_to_shop_loop_item', 9 );

/**
 * Custom Product Description Tab to fix duplicate content issue
 *
 * @param void
 * @return null
 */
function woo_custom_description_tab_content() {
	global $post;
	// dd($post);
	echo '<h2>Product Description</h2>';
	echo '<p>'.$post->post_content.'</p>';
}
/**
 * Accompanying filter hook
 *
 */
function woo_custom_description_tab( $tabs ) 
{
	$tabs['description']['callback'] = 'woo_custom_description_tab_content';	// Custom description callback
	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'woo_custom_description_tab', 98 );
