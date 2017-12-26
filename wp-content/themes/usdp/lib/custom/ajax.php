<?php

function get_cart_count() {
	$count = 0;
	foreach ($_SESSION['quote']['items'] as $items) foreach ($items as $item) $count++;
	wp_die($count);
};

add_action('wp_ajax_get_cart_count', 'get_cart_count');
add_action('wp_ajax_nopriv_get_cart_count', 'get_cart_count');


function add_to_cart_session() {

	if(!empty($_POST['id'])) {
		$_SESSION['quote']['items'][$_POST['id']][] = array(
			'quantity' => $_POST['quantity'],
			'date'     => $_POST['date'],
			'po'       => $_POST['po'],
			'city'     => $_POST['city'],
			'title'     => $_POST['title']
		);
	}

	get_cart_count();
};

add_action('wp_ajax_add_to_cart', 'add_to_cart_session');
add_action('wp_ajax_nopriv_add_to_cart', 'add_to_cart_session');


function delete_from_cart_session() {
	unset($_SESSION['quote']['items'][$_POST['e_id']][$_POST['a_id']]);
	get_cart_count();
};

add_action('wp_ajax_delete_from_cart_session', 'delete_from_cart_session');
add_action('wp_ajax_nopriv_delete_from_cart_session', 'delete_from_cart_session');


function update_single_item_details() {
	$_SESSION['quote']['items'][$_POST['equip_id']][$_POST['array_key']]['quantity'] = $_POST['quantity'];
	$_SESSION['quote']['items'][$_POST['equip_id']][$_POST['array_key']]['date'] = $_POST['date_needed'];
	$_SESSION['quote']['items'][$_POST['equip_id']][$_POST['array_key']]['po'] = $_POST['po'];
	$_SESSION['quote']['items'][$_POST['equip_id']][$_POST['array_key']]['city'] = $_POST['city'];
	$_SESSION['quote']['items'][$_POST['equip_id']][$_POST['array_key']]['title'] = $_POST['title'];
	wp_die();
};

add_action('wp_ajax_update_single_item_details', 'update_single_item_details');
add_action('wp_ajax_nopriv_update_single_item_details', 'update_single_item_details');


function submit_checkout() {

	$list = array();

	foreach($_SESSION['quote']['items'] as $postid => $items) {

		$cat   = get_post_meta($postid, 'cat',   true);
		$class = get_post_meta($postid, 'class', true);

		foreach ($items as $item) {

			$list[] = array(
				'Cat-Class' => $cat . '-' . $class,
				'Quantity' => $item['quantity'],
				'Date' => $item['date'],
				'PO' => $item['po'],
				'Delivery Zipcode' => $item['city'],
				'Title' => $item['title']
			);

		}

	}
	
	$entry_id = GFAPI::add_entry(array(
		'form_id' => '4',
		'1' => $_POST['company-name'],
		'2' => $_POST['full-name'],
		'3' => $_POST['last-name'],
		'4' => $_POST['email-address'],
		'5' => $_POST['phone-number'],
		'6' => $_POST['additional-information'],
		'7' => serialize($list)
	));

	send_notifications(4, $entry_id);

	unset($_SESSION['quote']['items']);

	wp_die();

};

add_action('wp_ajax_submit_checkout', 'submit_checkout');
add_action('wp_ajax_nopriv_submit_checkout', 'submit_checkout');

function get_all_types() {

	$types_query = new WP_Term_Query(array( 'taxonomy' => 'types', 'orderby' => 'name', 'order' => 'ASC'));

	$types = array();

	if(!empty($types_query->terms)) {

		foreach ($types_query->terms as $type) $parent_id_table[$type->term_id] = $type->parent;

		foreach ($types_query->terms as $type) {

			if($type->parent == 0) $types[$type->term_id]['name'] = $type->name; // Parent

			else {

				if($parent_id_table[$type->parent] == 0) $types[$parent_id_table[$type->term_id]]['children'][$type->term_id]['name'] = $type->name; // Child

				else $types[$parent_id_table[$type->parent]]['children'][$type->parent]['children'][$type->term_id] = $type->name; // Grandchild

			}

		}

	}

	echo json_encode($types);

	wp_die();
}

add_action('wp_ajax_get_all_types', 'get_all_types');
add_action('wp_ajax_nopriv_get_all_types', 'get_all_types');


function get_equipment_by_type() {

	$equipment_query = new WP_Query(array(
		'post_type' => 'equipment',
		'tax_query' => array(
			array(
				'taxonomy' => 'types',
				'field'    => 'term_id',
				'terms'    => $_POST['term_id'],
			)
		)
	));

	echo json_encode($equipment_query->posts);

	wp_die();

}
add_action('wp_ajax_get_equipment_by_type', 'get_equipment_by_type');
add_action('wp_ajax_nopriv_get_equipment_by_type', 'get_equipment_by_type');


function get_equipment_by_id() {

	$equipment = get_post($_POST['post_id'], ARRAY_A);

	$equipment['custom'] = get_post_meta($_POST['post_id']);

	$equipment['equipment_images'] = find_equipment_images($equipment['custom']['cat'][0], $equipment['custom']['class'][0]);

	echo json_encode($equipment);

	wp_die();

}
add_action('wp_ajax_get_equipment_by_id', 'get_equipment_by_id');
add_action('wp_ajax_nopriv_get_equipment_by_id', 'get_equipment_by_id');