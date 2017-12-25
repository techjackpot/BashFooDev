<?php

/**
 * Disabling JSON REST API
 *
 */
add_filter('json_enabled', '__return_false');
add_filter('json_jsonp_enabled', '__return_false');

// Custom Admin footer
function _usdp_update_admin_footer () {
    echo '<span id="footer-thankyou">Thank you for working with <a href="http://www.usdigitalpartners.com/" target="_blank">US DIGITAL PARTNERS</a></span>';
}
add_filter( 'admin_footer_text', '_usdp_update_admin_footer' );

/**
 * Edit Defualt email from and from name
 *
 * @param EMAIL_FROM_NAME  wp-config.php
 */
function _mail_from_name_overwrite( $from_name) {
	return defined('EMAIL_FROM_NAME') ? EMAIL_FROM_NAME : $from_name;
}
add_filter('wp_mail_from_name', '_mail_from_name_overwrite');



/**
 * TIMBER Context Extensions
 *
 */
function _usdp_add_items_to_timber_context($context) {
  $context['menu'] = new TimberMenu('primary-navigation');
  $context['mobilemenu'] = new TimberMenu('mobile-navigation');
  $context['footermenu'] = new TimberMenu('secondary-navigation');
  $context['brand_logo_svg'] = file_get_contents(get_template_directory().'/logo.svg');
  $context['_session'] = $_SESSION;
  return $context;
}
add_filter('timber_context', '_usdp_add_items_to_timber_context');


/**
 * TWIG Extensions
 *
 */

add_filter('get_twig', 'add_to_twig');

function add_to_twig($twig)
{
    $twig->addExtension(new Twig_Extension_Debug());

    $d = new Twig_SimpleFunction('d', function ($mixed_content) {
        $results = @Kint::dump($mixed_content);
        return $results;
    });
    $twig->addFunction($d);

    $get_context = new Twig_SimpleFunction('get_context', function () {
        global $context;
        return $context;
    });
    $twig->addFunction($get_context);

    $add_links = new Twig_SimpleFunction('add_links', function ($mixed_content) {
        $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
        if (preg_match($reg_exUrl, $mixed_content, $url)) {
            return preg_replace($reg_exUrl, '<a class="strong" href="' . $url[0] . '" target="_blank">' . $url[0] . '</a> ', $mixed_content);
        } else {
            return $text;
        }
    });
    $twig->addFunction($add_links);

    $bs_alert = new Twig_SimpleFunction('bs_alert', function ($mixed_content, $class) {
        return '<div class="alert alert-' . $class . '">' . $mixed_content . '</div>';
    });
    $twig->addFunction($bs_alert);

    $get_option = new Twig_SimpleFilter('get_option', function ($string) {
        return get_option($string);
    });
    $twig->addFilter($get_option);

    $die_dump = new Twig_SimpleFilter('dd', function ($string) {
        return dd($string);
    });
    $twig->addFilter($die_dump);

    $placeholder = new Twig_SimpleFilter('placeholder', function ($string) {
        return $string == '' ? '/assets/img/placeholder@2x.jpg' : $string;
    });
    $twig->addFilter($placeholder);

    $parenthesis_accent = new Twig_SimpleFilter('parenthesis_accent', function ($string) {
        $reg_ex = "/(\(([^\)]+)\))/";
        if (preg_match($reg_ex, $string, $matches)) {
            return preg_replace($reg_ex, '<span class="label_support">' . $matches[0] . '</span>', $string);
        }
        return $string;
    });
    $twig->addFilter($parenthesis_accent);

    $relativeize_url = new Twig_SimpleFilter('relativeize_url', function ($string) {
        if ($string == '') return '';
        if ($parts = parse_url($string)) {
            return $parts['path'];
        } else {
            return $string;
        }
    });
    $twig->addFilter($relativeize_url);

    return $twig;
}



/**
 * GRAVITY FORMS Extensions
 * 
 */
add_filter( 'gform_init_scripts_footer', '__return_true' );




add_filter( 'wpseo_breadcrumb_output', function($links) {
    $new_home = '<img class="home-icon" src="/assets/images/breadcrumbs-home-icon.png" />';
    $old_home = 'Home';
    return str_replace($old_home, $new_home, $links);
} );

add_filter( 'gform_pre_render', 'populate_choices' );
add_filter( 'gform_pre_validation', 'populate_choices' );
add_filter( 'gform_admin_pre_render', 'populate_choices' );
add_filter( 'gform_pre_submission_filter', 'populate_choices' );
function populate_choices( $form ) {

    if ( $form['id'] != 1 ) {
       return $form;
    }

    $items = array();

    $types = Timber::get_terms('types', array('parent' => 0));

    foreach ($types as $type) {
        $items[] = array('value' => $type->name, 'text' => $type->name);
    }

    foreach ( $form['fields'] as &$field ) {
        if ( $field->inputName == 'types_of_equipment' ) { 
             $field->choices = $items;
        }
    }

    return $form;
}