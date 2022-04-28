<?php
/**
 * Handicraft Liquids Script Loader Tag
 *
 * Clean tag script
 *
 * @link https://developer.wordpress.org/reference/hooks/script_loader_tag/
 *
 * @package Handicraft Liquids
 * @subpackage Handicraft Liquids
 * @since Handicraft Liquids 1.0.0
 */

//Remove jQuery Migrate
//https://github.com/cedaro/dequeue-jquery-migrate
function cedaro_dequeue_jquery_migrate( $scripts ) {
	if ( ! is_admin() && ! empty( $scripts->registered['jquery'] ) ) {
		$jquery_dependencies = $scripts->registered['jquery']->deps;
		$scripts->registered['jquery']->deps = array_diff( $jquery_dependencies, array( 'jquery-migrate' ) );
	}
}
add_action( 'wp_default_scripts', 'cedaro_dequeue_jquery_migrate' );


// Custom Scripts Loader Tags
function update_script_loader_tags( $tag, $handle, $src ) {
	$tag = "\t".'<script src="'.$src.'"></script>'."\n";
	//$src = str_replace("type='text/javascript' ", '', $src);
	return $tag;
}
add_filter('script_loader_tag', 'update_script_loader_tags', 10, 3);