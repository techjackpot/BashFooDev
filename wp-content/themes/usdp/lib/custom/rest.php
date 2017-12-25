<?php
/**
 * REST API endpoint for Equipment
 *
 * @package Wordpress
 * @subpackage USDP
 * @version 1.0.0
 */

/**
 * Regsiter Rest ENDPOINTS
 *
 */
 add_action('rest_api_init', function() {
    $rest_base = 'vandalia/v1';
    register_rest_route($rest_base, '/equipment', [
        'methods' => 'GET',
        'callback' => '_api_get_equipment'
    ]);
 });


/**
 * REST API endpoint for Categories
 *
 * @package Wordpress
 * @subpackage USDP
 * @version 1.0.0
 */

/**
 * Regsiter Rest ENDPOINTS
 *
 */
add_action('rest_api_init', function() {
    $rest_base = 'vandalia/v1';
    register_rest_route( $rest_base, '/category', [
        'methods' => 'GET',
        'callback' => '_api_get_category',
    ]);
});

/**
 * 
 * Category Payload
 * 
 * @endpoint /wp-json/vandalia/v1/equipment
 * @param request $request 
 * @return respones $response
 * 
 */

function _api_get_equipment( WP_REST_Request $request = null) {
    $response = array();
    $equipment = Timber::get_posts(array(
        'post_type' => 'equipment',
        'numberposts' => -1,
    ));
    // print_r($equipment);
    //print_r($equipment[0]->terms);
    // die();
    
    foreach ($equipment as $hash => $value) {
        $response[$hash] = array(
            'name' => $value->post_title,
            'cat' => $value->cat,
            'class' => $value->class,
            'daily_rate' => $value->day,
            'weekly_rate' => $value->week,
            'monthly_rate' => $value->month,
            'image_url' => $value->type_image['url'],
            'terms' => array()
        );
        foreach($value->terms as $term) {
            $response[$hash]['terms'][] = array(
                'name' => $term->name,
                'id' => $term->ID
            );
        }
    }
    return new WP_REST_Response($response, 200);
}


/**
 * 
 * Category Payload
 * 
 * @endpoint /wp-json/vandalia/v1/category
 * @param request $request 
 * @return respones $response
 * 
 */

function _api_get_category( WP_REST_Request $request = null) {

    $response = array();
    $terms = Timber::get_terms('types');

    function getChildren($term_id) {

        $child_terms = get_terms(array('parent' => $term_id, 'taxonomy' => 'types'));

        if(!empty($child_terms)) {
            
            foreach ($child_terms as $child_term) {

                $grandchildren = getChildren($child_term->term_id);
                if($grandchildren !== false) {
                     $temp_array[$child_term->term_id] = array(
                         'name' => $child_term->name,
                         'children' => $grandchildren
                    );
                }
                else {
                    $temp_array[$child_term->term_id] = array(
                        'name' => $child_term->name,
                        'children' => array()
                    );
                }

            }

            return $temp_array;
        }
        else {
            return array();
        }
    }

    foreach ($terms as $tidx => $term) {
        if ($term->parent == 0 ) {
           $response[$term->id]['name'] = $term->name;
           $response[$term->id]['children'] = getChildren($term->id);
        }
    }
    // print_r($response);
    // die();
    return new WP_REST_Response($response, 200);
}