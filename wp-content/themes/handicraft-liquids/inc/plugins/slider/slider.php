<?php
/**
 * Slider
 */

/**
 * Register Post Type Slider
 */
function register_post_type_slider() {

	$labels = array(
		'name'                  => 'Слайдер',
		'singular_name'         => 'Слайд',
		'name'                  => 'Слайдер',
		'menu_name'             => 'Слайдер',
		'name_admin_bar'        => 'Слайдер',
		'add_new'               => 'Добавить слайд',
		'add_new_item'          => 'Добавить новый слайд',
		'edit_item'             => 'Редактировать слайд',
		'new_item'              => 'Новый слайд',
		'view_item'             => 'Посмотреть слайд',
		'featured_image'        => 'Изображение слайда',
		'set_featured_image'    => 'Добавить изображение',
		'remove_featured_image' => 'Удалить изображение',
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'query_var'          => true,
		'menu_icon'          => 'dashicons-slides',
		'rewrite'            => true,
		'capability_type'    => 'post',
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'excerpt' , 'editor', 'thumbnail' )
	);

	register_post_type( 'slider' , $args );

}
add_action('init', 'register_post_type_slider');

/**
 * Slider Meta Boxes
 */
function slider_meta_boxes(){
	// add meta Box
	remove_meta_box( 'postimagediv', 'slider', 'side' );
	add_meta_box('postimagediv', 'Изображение слайда', 'post_thumbnail_meta_box', 'slider', 'normal', 'low');
}
add_action( 'add_meta_boxes' , 'slider_meta_boxes' );

/**
 * Manage Slider Custom Column
 */

/**
 * Manage admin columns
 */
function slider_manage_colums($cols){

	unset($cols['date']);
	$cols['slider_thumb'] = 'Изображение';
		
	return $cols;
	
}
add_filter( 'manage_slider_posts_columns', 'slider_manage_colums' );

// Grab featured-thumbnail size post thumbnail and display it.
function slider_display_columns($col, $id){
	
	switch($col){
	  
	case 'slider_thumb':
	 	if( function_exists('the_post_thumbnail') ){
	
		$post_thumbnail_id = get_post_thumbnail_id($id);
		$post_thumbnail_img = wp_get_attachment_image_url($post_thumbnail_id, 'large');
		if($post_thumbnail_img !='')
		 	echo '<img height="80" style="width: auto;" src="' . $post_thumbnail_img . '" />';
		else
			echo 'Нет фото';	
		}
	 	else{
			echo 'Нет фото';
		}
	}
}
add_action( 'manage_slider_posts_custom_column', 'slider_display_columns', 10, 2);

/**
 * Featured image slider, displayed on front page for static page and blog
 */
function handicraft_liquids_slider() {
	
	$args = array(
		'post_type'      => 'slider',
		'posts_per_page' => 10,
		'orderby'        => 'menu_order',
	);
	$query = new WP_Query( $args );

	if ( $query->have_posts() ) :
	?>
	<div class="slider_1">
		<?php while ( $query->have_posts() ) : $query->the_post(); ?>
			<div class="item">
				<?php the_title( '<div class="name">', '</div>');?>
				<div class="left">
					<div class="content">
						<div class="text">
							<div class="zag"><?php echo get_the_excerpt();?></div>
							<?php the_content();?>
							<?php if( get_field( 'button_title' ) || get_field( 'button_link' ) ) {?>
								<a href="<?php the_field( 'button_link' );?>" class="button"><?php the_field( 'button_title' );?></a>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="right">
					<img src="<?php the_post_thumbnail_url( 'large' );?>" alt="">
				</div>
			</div>
		<?php endwhile;?>
	</div>
	<?php 
	endif;
	wp_reset_postdata();
}