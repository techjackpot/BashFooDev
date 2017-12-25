<?php

$context = Timber::get_context();

$query->query_vars['s'] = get_search_query();
$query->query_vars['posts_per_page'] = -1;
$query->query_vars['post_type'] = 'equipment';

$search_results = relevanssi_do_query($query);

$ids = array();

foreach($search_results as $search_result) {

	$result = Timber::get_post( $search_result->ID );

	$context['search_results'][$result->order] = $result; 

}


ksort($context['search_results']);

Timber::render('search.twig', $context);
