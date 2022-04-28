<?php
/**
 * Handicraft Liquids functions and definitions
 *
 * @package Handicraft Liquids
 * @subpackage Handicraft Liquids
 * @since Handicraft Liquids 1.0.0
 */

 /**
 * Add Options Page
 */
 if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Опции темы',
		'menu_title'	=> 'Опции темы',
		'menu_slug' 	=> 'theme-settings',
		'parent_slug'	=> 'themes.php',
		'update_button' => 'Обновить'
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Настройка цен',
		'menu_title'	=> 'Настройка цен',
		'menu_slug' 	=> 'theme-settings-price',
		'parent_slug'	=> 'themes.php',
		'update_button' => 'Обновить'
	));
	
}

/**
 * Get Theme Options
 */
function theme_field( $field, $echo = true ){
	if( $echo == false) {
		$field = get_field( $field, 'option' );
		return $field;
	} else {
		$field = get_field( $field, 'option' );
		echo do_shortcode( $field );
	}
	
}

if ( ! function_exists( 'handicraft_liquids_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 */
function handicraft_liquids_setup() {

	/*
	 * Add <title> tag.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails.
	 */
	add_theme_support( 'post-thumbnails' );
	
	// Add image size
	add_image_size( 'review', 70, 70, true );
	add_image_size( 'catalog', 180, 180 );

	// Register Nav Menus locations.
	register_nav_menus( array(
		'primary' => 'Главное меню',
		'catalog' => 'Каталог',
		'social'  => 'Социальное меню',
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

}
endif; // handicraft_liquids
add_action( 'after_setup_theme', 'handicraft_liquids_setup' );

/**
 * Theme Custom Functions
 */
require get_parent_theme_file_path( '/inc/functions/custom.php' );

/**
 * WP Head
 */
require get_parent_theme_file_path( '/inc/functions/wp_head.php' );

/**
 * Script Loader Tag
 */
require get_parent_theme_file_path( '/inc/functions/script_loader_tag.php' );

/**
 * Style Loader Tag
 */
require get_parent_theme_file_path( '/inc/functions/style_loader_tag.php' );

/**
 * WP Enqueue Scripts
 */
require get_parent_theme_file_path( '/inc/functions/wp_enqueue_scripts.php' );

/**
 * WP Social menu
 */
require get_parent_theme_file_path( '/inc/functions/wp_social_menu.php' );

/**
 * WP Simple NavWalker
 */
require get_parent_theme_file_path( '/inc/functions/wp_simple_navwalker.php' );

/**
 * WP Nav Cut Menu
 */
require get_parent_theme_file_path( '/inc/functions/wp_nav_cut_menu.php' );

/**
 * WP Nav Cut Menu
 */
require get_parent_theme_file_path( '/inc/functions/add_shortcode.php' );

/**
 * Pre Get Posts
 */
require get_parent_theme_file_path( '/inc/functions/pre_get_posts.php' );

/**
 * WP Ajax
 */
require get_parent_theme_file_path( '/inc/ajax/wp_ajax.php' );

/**
 * Slider
 */
require get_parent_theme_file_path( '/inc/plugins/slider/slider.php' );

/**
 * Reviews
 */
require get_parent_theme_file_path( '/inc/plugins/reviews/reviews.php' );

/**
 * Shop
 */
require get_parent_theme_file_path( '/inc/plugins/shop/shop.php' );

/**
 * ACF Save Post
 */
require get_parent_theme_file_path( '/inc/functions/save_post.php' );

/**
 * Contact Form 7 Hook
 */
require get_parent_theme_file_path( '/inc/functions/contact-form-7.php' );

/**
 * Mobile Detect
 */
require get_parent_theme_file_path( '/inc/mobile-detect/wp-mobile-detect.php' );