<?php

$context = Timber::get_context();
require_once 'Mobile_Detect.php';
$detect = new Mobile_Detect;
$context['current_term'] = Timber::get_terms('types', array('include' => get_queried_object()->term_id));
$context['current_term'] = $context['current_term'][0];

$types = Timber::get_terms('types', array('parent' => get_queried_object()->term_id, 'number' => 0));

if(!empty($types)) {

	$context['types'] = array();

	foreach($types as $type) {

		$order = get_term_meta($type->ID, 'order', true);

		if (!empty($order)) {
			if(!array_key_exists($order, $context['types'])) $context['types'][$order] = $type;
			else $context['types'][$order++] = $type;
		}

		else $context['types'][] = $type;

	}

	ksort($context['types']);

	//Timber::render(array('archives/archive-types.twig', 'page.twig'), $context);
}
if( $detect->isMobile() && !$detect->isTablet() ){
	Timber::render(array('archives/archive-typesmob.twig', 'page.twig'), $context);
}else{
	Timber::render(array('archives/archive-types.twig', 'page.twig'), $context);
} 
