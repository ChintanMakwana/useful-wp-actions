<?php

/**
 * Change WordPress Admin login logo
 *
*/
add_action( 'login_enqueue_scripts', 'login_enqueue_scripts_example' );
function login_enqueue_scripts_example() {
 
    echo '<style type="text/css">'
            . '#login h1 a {'
                . 'background-image: url(' . get_bloginfo( 'template_directory' ) . '/images/login-logo.png);'
                . 'padding-bottom: 30px;'
            . '}'
        . '</style>';
         
}

/**
 * Add support for core custom logo
 */
add_theme_support(
	'custom-logo',
	array(
		'height'      => YOUR_THEME_LOGO_HEIGHT,
		'width'       => YOUR_THEME_LOGO_WEIGHT,
		'flex-width'  => false,
		'flex-height' => false,
	)
);

/**
 * Add desired attributes to menu link item
 */
function add_specific_menu_location_atts( $atts, $item, $args ) {
    // check if the item is in the primary menu
    if( $args->theme_location == 'primary_menu' ) {
      	// add the desired attributes:
    	$atts['class'] = 'navLink';

    	$atts['data-text'] = $item->title;
    	
    }
    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'add_specific_menu_location_atts', 10, 3 );

/**
 * Remove version string from scripts and styles
 */
function remove_version_scripts_styles($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'remove_version_scripts_styles', 9999);
add_filter('script_loader_src', 'remove_version_scripts_styles', 9999);

/**
 * Add Custom meta tags in the top of the head tag
 */
function add_meta_tags() {
    echo '<link rel="mask-icon" href="" color="#5bbad5">' . "\n";
    echo '<meta name="msapplication-TileColor" content="#da532c">' . "\n";
    echo '<meta name="msapplication-config" content="">' . "\n";
    echo '<meta name="theme-color" content="#ffffff">  ' . "\n";
}
add_action( 'wp_head', 'add_meta_tags' , 0 );

/**
 * Remove Private or Protected text from post title
 */
function the_title_trim($title) {

    $title = attribute_escape($title);

    $findthese = array(
        '#Protected:#',
        '#Private:#'
    );

    $replacewith = array(
        '', // What to replace &quot;Protected:&quot; with
        '' // What to replace &quot;Private:&quot; with
    );

    $title = preg_replace($findthese, $replacewith, $title);

    return $title;
}
add_filter('the_title', 'the_title_trim');
