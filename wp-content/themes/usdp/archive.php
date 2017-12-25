<?php

switch(get_post_type()) {

	case 'equipment':
		wp_redirect('/equipment-catalog/');
		break;

	default: 

		$context = Timber::get_context();
		$context['term'] = new TimberTerm(get_query_var('cat'));
		$context['terms'] = Timber::get_terms('category');
		$context['posts'] = Timber::get_posts(array('posts_per_page' => -1, 'cat' => get_query_var('cat') ));

		Timber::render(array('archives/archive-' . get_query_var('category_name')  . '.twig', 'archive.twig', 'index.twig'), $context);
		break;
}