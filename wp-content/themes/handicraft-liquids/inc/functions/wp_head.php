<?php
/**
 * WP Head
 *
 * @package Handicraft Liquids
 * @subpackage Handicraft Liquids
 * @since Handicraft Liquids 1.0.0
 */

/**
 * Add meta name="viewport" in <head>
 */
function handicraft_liquids_meta_viewport() {
	echo '<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">'."\n";
}
add_action( 'wp_head', 'handicraft_liquids_meta_viewport', 0 );

/**
 * Add link rel="shortcut icon"
 */
function handicraft_liquids_shortcut_icon() {
	echo '<link href="'.get_theme_file_uri('/img/icons/favicon.ico').'" rel="shortcut icon" />'."\n";
}
add_action( 'wp_head', 'handicraft_liquids_shortcut_icon', 0 );

//Removing Emoji code from header
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );