<?php
/**
 * The template for displaying taxonomy pages
 *
 * @package Handicraft Liquids
 * @subpackage Handicraft Liquids
 * @since Handicraft Liquids 1.0.0
 */

$queried_object = get_queried_object();
$term_id = $queried_object->term_id;
$taxonomy = $queried_object->taxonomy;
$parent_id = $queried_object->parent;

$parent = get_term( $parent_id, $taxonomy );
if ( !empty( $parent ) && !is_wp_error( $parent ) ) {
	$term_name = $parent->name;
} else {
	$term_name = single_term_title( '', false);
}

get_header(); ?>

	<?php wp_social_menu( 'right-social', '<a href="#" class="search-event"><span class="search"></span></a>' );?>
	<div class="page-content">
		<h1><?php echo $term_name; ?></h1>
		<?php if(function_exists('bcn_display')) {?>
			<ol class="breadcrumb">
				<?php bcn_display();?>
			</ol>
		<?php } ?>

		<?php if ( !empty( $parent ) && !is_wp_error( $parent ) ) {?>
		
			<?php 
			$args = array(
				'taxonomy'      => $taxonomy,
				'hide_empty'    => false, 
				'child_of'      => $parent->term_id,
			); 
			$terms = get_terms( $args );
			if ( !empty( $terms ) && !is_wp_error( $terms ) ) { ?>
			<div class="tabs">
				<ul class="tabNavigation">
					<?php foreach ($terms as $term) { ?>
						<?php 
							$selected = '';
							if( $term_id == $term->term_id ) {
								$selected = ' class="selected"';
							}
						?>
						<li><a href="<?php echo get_term_link( $term );?>"<?php echo $selected;?>><?php echo $term->name;?></a></li>
					<?php } ?>
				</ul>
			</div>
			<?php } ?>
			
			<div id="t1">
				<div class="callback-text">
					<div class="right-text">
						<?php theme_field( 'catalog_feedback' );?>
					</div>
					<div class="main-text">
						<?php 
							if( get_field( 'desc', $queried_object ) ) {
								the_field( 'desc', $queried_object );
							} else {
								theme_field( 'catalog_desc' );
							}
						?>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			
		<?php } else { ?>
		
			<div class="catalog catalog-parent-cat">
				<div class="item">
					<div class="content">
						<div class="zag"><?php echo $term_name; ?></div>
						<?php 
							$args_child = array(
							'taxonomy'      => $taxonomy,
							'hide_empty'    => false, 
							'child_of'      => $term_id,
						); 
						$terms_child = get_terms( $args_child );
						$count = count( $terms_child );
						if ( !empty( $terms_child ) && !is_wp_error( $terms_child ) ) {
							$class = '';
							if ( $count > 2 ) {
								$class = ' class="small"';
							}?>
							
							<ul<?php echo $class;?>>
							<?php foreach ($terms_child as $term_child) { ?>
								<li><a href="<?php echo get_term_link( $term_child );?>"><?php echo $term_child->name;?></a></li>
							<?php } ?>
							</ul>
						<?php } else { ?>
							<?php echo term_description( $term_id, $taxonomy ) ?>
						<?php } ?>
						<div class="price"><?php the_field( 'price', $queried_object ); ?></div>
						<div class="clear"></div>
					</div>
				</div>
			</div><!-- .catalog -->
			
			<?php if (!isset($_GET['search'])){?>
				
			<div id="t1">
				<div class="callback-text">
					<div class="right-text">
						<?php theme_field( 'catalog_feedback' );?>
					</div>
					<div class="main-text">
						<?php 
							if( get_field( 'desc', $queried_object ) ) {
								the_field( 'desc', $queried_object );
							} else {
								theme_field( 'catalog_desc' );
							}
						?>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<?php } ?>
			
		<?php } ?>

	</div>
	
	<?php if (!isset($_GET['search'])){?>
	<div class="bottom-icons">
		<?php theme_field( 'catalog_icons' );?>
		<div class="clear"></div>
	</div>
	<?php } ?>
	
	<?php the_products_filter( $term_id ); // inc/plugins/shop/the_products_filter.php ?>
	
	<div class="catalog-list catalog-list-ajax">
		<?php if (isset($_GET['search'])){?>
			<h3 class="search-title">Результаты поиска для: <?php echo get_search_query(); ?></h3>
		<?php } ?>
		<?php if ( have_posts() ) : ?>
			<?php $paged = (isset($wp_query->query[ 'paged' ])) ? $wp_query->query[ 'paged' ] : 1; ?>
			<?php $post_per_page = $wp_query->query_vars[ 'posts_per_page' ];?>
			<?php $fount_posts = $wp_query->found_posts; ?>
			<?php $more_posts = $fount_posts - ( $post_per_page * $paged ); ?>
			<?php $next_posts = ( $more_posts > 6 ) ? 6 : $more_posts; ?>
			<div class="ajax-content" data-posts="<?php echo $fount_posts;?>">
				<?php while ( have_posts() ) : the_post(); 
					$terms =  wp_get_post_terms( get_the_ID(), 'product_cat', array( 'fields' => 'ids' ) );
					?>
					<article class="catalog-item">
						<div class="content">
							<div class="image">
								<?php if( has_post_thumbnail()){?>
									<img src="<?php the_post_thumbnail_url( 'catalog' );?>" alt="">
								<?php } else { ?>
									<img src="<?php echo get_theme_file_uri( '/img/thumb.png' );?>" alt="">
								<?php } ?>
							</div>
							<?php // if( ! in_array( '8', $terms )) echo '<div class="rightinf">';?>
							<div class="rightinf">
								<div class="name">
									<div>
										<span><?php the_title();?></span>
										<?php the_field( 'tastes' );?>
									</div>
								</div>
								<div class="price">
									<div class="number">
										<span class="minus btn-minus"><img src="<?php echo get_theme_file_uri( '/img/minus.jpg' );?>"></span>
										<input type="text" value="1" class="input-qty">
										<span class="plus btn-plus"><img src="<?php echo get_theme_file_uri( '/img/plus.jpg' );?>"></span>
									</div>
									<?php if( get_field( 'price' )) {?>
										<input type="hidden" class="price-count-default" value="<?php the_field( 'price' );?>">
										<span class="price-count"><?php the_field( 'price' );?></span> p
									<?php } ?>
								</div>
								
								<div class="clear"></div>
								
								<div class="buy">
									<?php
										if( in_array( '8', $terms )) {?>
											<div class="select select-volume">
												<?php if( get_field('price')){?>
													<a href="#" class="active" data-price="<?php the_field('price');?>" data-volume="price">10 мл.</a>
												<?php } ?>
												<?php if( get_field('price_100')){?>
													<a href="#" data-price="<?php the_field('price_100');?>" data-volume="price_100">100 мл.</a>
												<?php } ?>
												<?php if( get_field('price_250')){?>
													<a href="#" data-price="<?php the_field('price_250');?>" data-volume="price_250">250 мл.</a>
												<?php } ?>
												<?php if( get_field_object('price_gallon')){
													$price_gallon = get_field_object('price_gallon');
													?>
													<a href="#" data-price="<?php echo $price_gallon['value'];?>" data-volume="price_gallon">галлон</a>
												<?php } ?>
												
												<select class="select-volume-option">
													<?php if( get_field('price')){?>
														<option value="price" data-price="<?php the_field('price');?>">10 мл.</option>
													<?php } ?>
													<?php if( get_field('price_100')){?>
														<option value="price_100" data-price="<?php the_field('price_100');?>">100 мл.</option>
													<?php } ?>
													<?php if( get_field('price_250')){?>
														<option value="price_250" data-price="<?php the_field('price_250');?>">250 мл.</option>
													<?php } ?>
													<?php if( get_field_object('price_gallon')){
														$price_gallon = get_field_object('price_gallon');
														?>
														<option value="price_gallon" data-price="<?php the_field('price_gallon');?>">галлон</option>
													<?php } ?>
												
												</select>
												
											</div>
										<?php } else { ?>
											<?php echo wpautop( wp_trim_words( get_the_content(), 12, '' ) ); ?>
										<?php } ?>
									<a href="#" class="link add-to-cart" data-id="<?php the_ID();?>" data-qty="1" data-volume="price"></a>
								</div>
							<?php //if( ! in_array( '8', $terms )) echo '</div>';?>
							</div>
							<div class="clear"></div>
						</div>
					</article>
				<?php endwhile; ?>
			</div><!-- .ajax-content -->
			<?php if (!isset($_GET['search'])){?>
				<?php if ( !is_paged() ) {?>
					<?php if( $more_posts > 0 ) {?>
						<button class="load-more-content more-item" data-offset="<?php echo $post_per_page;?>" data-perpage="6" data-post-type="product" data-term="<?php echo $term_id;?>" data-next-posts="<?php echo $next_posts;?>">еще  <span><?php echo $next_posts;?> </span></button><span class="ajax-loader"></span>
					<?php } ?>
				<?php } ?>
			<?php } ?>
			<?php if(function_exists( 'wp_pagenavi' )) {?>
				<?php wp_pagenavi();?>
			<?php } ?>
		<?php else : ?>
			<?php if (!isset($_GET['search'])){?>
				<p class="empty-category-msg">В этой категории пока нет товаров!</p>
				<p><a href="<?php echo get_post_type_archive_link( 'product' ); ?>" class="button-info">Перейти в каталог</a>
			<?php } else { ?>
				<p class="empty-category-msg">По вашему запросу ничего не найдено!</p>
			<?php } ?>
		<?php endif; ?>
		
	</div>
	
	<?php get_sidebar('catalog');?>

<?php get_footer(); ?>