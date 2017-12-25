<?php

$context = Timber::get_context();
$context['post'] = Timber::get_post();

$context['recentposts'] = Timber::get_posts(array(
	'posts_per_page' => 3,
	'post_type' => 'post',
	'post__not_in' => array(get_the_id())
));

if(get_post_type() == 'equipment') {
?>
    

<?php	$context['specs'] = explode(PHP_EOL, $context['post']->specs);
	//$context['specifc'] =  do_shortcode($context['post']->specs);

	$specific_html = '';
	$spec_data = [];
	$model_names = [];
	foreach($context['specs'] as $spec) {
		if(!trim($spec)) continue;

		preg_match_all("/\[SPECF (.+) ]/", $spec, $out);

		$data = $out[1][0];

		$spec_params = preg_split("/\s{2,}|\|/", $data);

		$spec_name = $spec_params[0];

		unset($spec_params[0]);

		$spec_params_data = [];
		foreach($spec_params as $temp) {
			if(trim($temp)) {
				$spec_params_data[] = $temp;
			}
		}

		$spec_data[] = array('spec_name' => $spec_name, 'spec_params' => $spec_params_data);

		// $specific_html .= '<div class="spec-row"><div class="spec-name">' . $spec_name . '</div>' . '<div class="spec-param">' . implode('</div><div class="spec-param">', $spec_params) . '</div>' . '</div>';

		if(trim($spec_name) == 'MODEL') {
			$model_names = $spec_params_data;
		}
	}

	$specific_html2 = '';
	foreach($spec_data as $spec) {
		$specific_html2 .= '<div class="spec-row spec-'.count($model_names).'"><div class="spec-name">' . $spec['spec_name'] . '</div>';
		foreach($spec['spec_params'] as $ind => $param) {
			$specific_html2 .= '<div class="spec-param">' . ($spec['spec_name'] != 'MODEL' && count($spec['spec_params'])>1 ? '<span class="spec-param-extra">' . $model_names[$ind] . ': </span>' : '') . $param . '</div>';
		}
		// if(count($spec['spec_params'])<count($model_names)) {
		// 	$specific_html2 .= str_repeat('<div class="spec-param"></div>', count($model_names) - count($spec['spec_params']));
		// }
		$specific_html2 .= '</div>';
	// 		// <div class="spec-param">' . implode('</div><div class="spec-param">', $spec_params) . '</div>' . '</div>';
	}

	// $context['specifc'] = $specific_html;
	$context['specifc2'] = $specific_html2;

	$context['equipment_images'] = find_equipment_images($context['post']->custom['cat'], $context['post']->custom['class']);
}

	if($context['post']->custom['_thumbnail_id']) {
		$context['featured_thumbnail'] = get_the_post_thumbnail($context['post']->ID);
	}

Timber::render(array('singles/single-' . get_post_type() . '.twig', 'single.twig', 'index.twig'), $context);
