<?php

$context = Timber::get_context();
$context['post'] = new TimberPost();
$context['acf'] = get_fields(get_the_ID());
$types = Timber::get_terms('types', array('parent' => 0, 'posts_per_page' => -1));

$context['types'] = array();
$context['acf']['home_featured_types'] = array();

foreach($types as $type) {

	unset($order);
	unset($homepgord);

	$order = $type->order;
	$homepgord = $type->homepgord;

	if (!empty($order)) {
		if(!array_key_exists($order, $context['types'])) $context['types'][$order] = $type;
		else $context['types'][$order++] = $type;
	}

	else $context['types'][] = $type;


	if (!empty($homepgord)) {
		$context['acf']['home_featured_types'][$homepgord] = $type;
	}

}

if(!empty($context['types'])) ksort($context['types']);

if(!empty($context['acf']['home_featured_types'])) ksort($context['acf']['home_featured_types']);




Timber::render(array('pages/page-home.twig'), $context);