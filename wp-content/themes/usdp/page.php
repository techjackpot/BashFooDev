<?php

$context = Timber::get_context();
$context['post'] = new TimberPost();
$context['acf'] = get_fields(get_the_ID());

/* Page Header Stuff */
$context['pageheader'] = array();

$hero_image = get_post_thumbnail_id($context['post']->id);

if(!empty($hero_image)) {
	$context['pageheader']['hero_image'] = new TimberImage($hero_image);
}
else {

	if($context['post']->post_parent != 0) {
		$parent_hero_image = get_post_thumbnail_id($context['post']->post_parent);
		if(!empty($parent_hero_image)) {
			$context['pageheader']['hero_image'] = new TimberImage($parent_hero_image);
		}
	}
}

if(!empty($context['post']->custom['title'])) {
	$context['pageheader']['title']   = $context['post']->custom['title'];
}

if(!empty($context['post']->custom['tagline'])) {
	$context['pageheader']['tagline'] = $context['post']->custom['tagline'];
}

/* Page specific custom context stuff */
switch($post->post_name) {
	case 'equipment-catalog':
		$types = Timber::get_terms('types', array('parent' => 0, 'meta_key' => 'order', 'orderby' => 'meta_value', 'order' => 'ASC'));

		foreach ($types as $type) $context['types'][$type->order] =  $type;
		
		ksort($context['types']);

		break;

	case 'cart':
		break;

	case 'get-a-quote':
		$context['types'] = Timber::get_terms('types', array('parent' => 0, 'meta_key' => 'order', 'orderby' => 'meta_value', 'order' => 'ASC'));
		break;

	case 'blog':
		wp_redirect('/category/news-and-events');
		break;
}
if($post->post_name=='equipment-catalog'){
	require_once 'Mobile_Detect.php';
	$detect = new Mobile_Detect;
	if( $detect->isMobile() && !$detect->isTablet() ){
		Timber::render(array('pages/page-' . $post->post_name . 'mob.twig', 'page.twig'), $context);
	}else{
		Timber::render(array('pages/page-' . $post->post_name . '.twig', 'page.twig'), $context);
	} 
	
	
}else{	
Timber::render(array('pages/page-' . $post->post_name . '.twig', 'page.twig'), $context);

}
?>
<style type="text/css">
	.gform_wrapper .gform_body .gform_fields .gfield .gfield_label, .gform_wrapper.gform_validation_error form .gform_body .gform_fields .gfield_error .validation_message {
		display: inline-block;
	}
</style>