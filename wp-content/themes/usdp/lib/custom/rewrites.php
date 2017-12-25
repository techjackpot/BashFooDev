<?php

/**
 * Custom Url Rewrite funcitonality for URL structures
 *
 */
function _usdp_general_rewrite( $wp_rewrite ) {
    $feed_rules = array(
        'board-games/(.+)/(.+)' => 'index.php?post_type=games&games=' . $wp_rewrite->preg_index(2) . '&name=' . $wp_rewrite->preg_index(2),
        'board-games/(.+)' => 'index.php?Categories=' . $wp_rewrite->preg_index(1),
        'board-games/' => 'index.php?post_type=games'
    );

    $wp_rewrite->rules = $feed_rules + $wp_rewrite->rules;
    return $wp_rewrite->rules;
}
//add_filter( 'generate_rewrite_rules', '_usdp_general_rewrite' );


/**
 * Custom Permalink Structures
 *
 */
function _usdp_rewrite_permalink( $url, $post, $keep=true ) {

    if ( 'games' == get_post_type( $post ) ) {
    	$cats = get_the_terms( $post->ID, 'Categories' );
    	// var_dump($cats);
    	if ( ! is_array( $cats ) or ! isset ( $cats[0]->slug ) )
    	{
    		return $url;
    	}
    	return home_url( user_trailingslashit( 'board-games' . '/' . $cats[0]->slug . '/' . $post->post_name ) );
    }
    return $url;
}
//add_filter( 'post_type_link', '_usdp_rewrite_permalink', 10, 2 );