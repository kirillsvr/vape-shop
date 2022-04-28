<?php
/**
 * Shop
 */

/**
 * Register Post Type product
 */
function register_post_type_product() {

	$labels = array(
		'name'                  => 'Продукты',
		'singular_name'         => 'Продукт',
		'menu_name'             => 'Продукты',
		'name_admin_bar'        => 'Продукты',
		'all_items'             => 'Все продукты',
		'add_new_item'          => 'Добавить продукт',
		'add_new'               => 'Добавить новый продукт',
		'new_item'              => 'Новый продукт',
		'edit_item'             => 'Редактировать',
		'update_item'           => 'Обновить',
		'view_item'             => 'Посмотреть'
	);
	$rewrite = array(
		'slug'                  => 'catalog',
		'with_front'            => true,
		'pages'                 => true,
	);
	$args = array(
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'taxonomies'            => array( 'product_cat' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 6,
		'menu_icon'             => 'dashicons-cart',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'post',
	  ); 

	register_post_type( 'product' , $args );

} 
add_action('init', 'register_post_type_product');

/**
 * Register Product Cat Taxonomy
 */
function product_cat_taxonomy() {

	$labels = array(
		'name'                       => 'Категории Продуктов',
		'singular_name'              => 'Категория',
		'menu_name'                  => 'Категории',
		'all_items'                  => 'Все категории',
		'new_item_name'              => 'Новая категория',
		'add_new_item'               => 'Добавить новую категорию',
		'edit_item'                  => 'Редактировать категорию',
		'update_item'                => 'Обновить категорию',
		'view_item'                  => 'Посмотреть категорию',
		'add_or_remove_items'        => 'Добавить или удалить',
		'choose_from_most_used'      => 'Использовать из популярные',
		'popular_items'              => null,
		'search_items'               => 'Поиск',
		'not_found'                  => 'Не найдено',
		'no_terms'                   => 'Нет категорий'
	);
	$rewrite = array(
		'slug'                       => 'category',
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'product_cat', array( 'product' ), $args );

}
add_action( 'init', 'product_cat_taxonomy', 0 );

/**
 * The Product filter
 */
require get_parent_theme_file_path( '/inc/plugins/shop/the_products_filter.php' );