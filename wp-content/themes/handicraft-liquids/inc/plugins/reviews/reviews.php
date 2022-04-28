<?php
/**
 * Reviews
 */

/**
 * Register Post Type Review
 */
function register_post_type_review() {

	$labels = array(
		'name'                  => 'Отзывы',
		'singular_name'         => 'Отзыв',
		'menu_name'             => 'Отзывы',
		'name_admin_bar'        => 'Отзывы',
		'all_items'             => 'Все отзывы',
		'add_new_item'          => 'Добавить отзыв',
		'add_new'               => 'Добавить новый отзыв',
		'new_item'              => 'Новый отзыв',
		'edit_item'             => 'Редактировать',
		'update_item'           => 'Обновить',
		'view_item'             => 'Посмотреть'
	);
	$rewrite = array(
		'slug'                  => 'reviews',
		'with_front'            => true,
		'pages'                 => true,
	);
	$args = array(
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail', 'editor' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 6,
		'menu_icon'             => 'dashicons-testimonial',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'post',
	  ); 

	register_post_type( 'review' , $args );

} 
add_action('init', 'register_post_type_review');

/**
 * Register Taxonomy
 */
//require 'inc/register_taxonomy.php';