<?php

$context = Timber::get_context();
$context['post'] = new TimberPost(get_option('page_for_posts'));
$context['posts'] = Timber::get_posts();
$context['pagination'] = Timber::get_pagination();
Timber::render('index.twig', $context);