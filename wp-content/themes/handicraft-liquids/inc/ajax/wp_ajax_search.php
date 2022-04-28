<?php
/**
 * Wp Ajax Search
 *
 * @package Handicraft Liquids
 * @subpackage Handicraft Liquids
 * @since Handicraft Liquids 1.0.0
 */

require_once('../../../../../wp-load.php');

$s = $_POST[ 's' ];
$order = $_POST[ 'order' ];
$orderby = $_POST[ 'orderby' ];
$term_id = $_POST[ 'term' ];
$posts_per_page = $_POST[ 'posts_per_page' ];
$meta_key = '';

if( $orderby == 'price' ) {
	$meta_key = $orderby;
	$orderby = 'meta_value_num';
} else {
	$orderby = 'title';
}

$post_type = $_POST[ 'post_type' ];
if($post_type == 'post') {
	$taxonomy = 'category';
} else {
	$taxonomy = 'product_cat';
}

?>

<?php
	$args = array(
		's'              => $s,
		'post_type'      => 'product',
		'posts_per_page' => $posts_per_page,
		'orderby'        => $orderby,
		'order'          => $order,
		'meta_key'       => $meta_key,
		'tax_query' => array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'id',
				'terms'    => array( $term_id ),
			),
		)
	);
	$query = new WP_Query( $args );
?>
<?php /*<h3 class="search-title">Результаты поиска для: <?php echo $s; ?> <span>"<?php echo $query->found_posts;?>"</span></h3> */?>
<?php if ( $query->have_posts() ) :?>
	<?php $paged = (isset($query->query[ 'paged' ])) ? $query->query[ 'paged' ] : 1; ?>
	<?php $post_per_page = $query->query_vars[ 'posts_per_page' ];?>
	<?php $fount_posts = $query->found_posts; ?>
	<?php $more_posts = $fount_posts - ( $post_per_page * $paged ); ?>
	<?php $next_posts = ( $more_posts > 6 ) ? 6 : $more_posts; ?>
	<div class="ajax-content" data-posts="<?php echo $fount_posts;?>">
	<?php while ( $query->have_posts() ) : $query->the_post(); ?>
		<?php $terms =  wp_get_post_terms( get_the_ID(), 'product_cat', array( 'fields' => 'ids' ) );?>
		<article class="catalog-item">
			<div class="content">
				<div class="image">
					<?php if( has_post_thumbnail()){?>
						<img src="<?php the_post_thumbnail_url( 'catalog' );?>" alt="">
					<?php } else { ?>
						<img src="<?php echo get_theme_file_uri( '/img/thumb.png' );?>" alt="">
					<?php } ?>
				</div>
				<?php if( ! in_array( '8', $terms )) echo '<div class="rightinf">';?>
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
				<?php if( ! in_array( '8', $terms )) echo '</div>';?>
				<div class="clear"></div>
			</div>
		</article>
		
	<?php endwhile;?>
	</div><!-- .ajax-content -->
	<?php if( $more_posts > 0 ) {?>
		<button class="load-more-content load-more-content-search more-item" data-offset="<?php echo $post_per_page;?>" data-perpage="6" data-post-type="product" data-term="<?php echo $term_id;?>" data-next-posts="<?php echo $next_posts;?>">еще  <span><?php echo $next_posts;?> </span></button><span class="ajax-loader"></span>
		<?php } ?>
		
					
	<?php if(function_exists( 'wp_pagenavi' )) {?>
		<?php //wp_pagenavi( array( 'query' => $query ) );?>
	<?php } ?>
<?php else : ?>
	<p class="empty-category-msg">По вашему запросу ничего не найдено!</p>
<?php endif;?>
<?php wp_reset_postdata();?>
<?php /*

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
							<?php if( ! in_array( '8', $terms )) echo '<div class="rightinf">';?>
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
							<?php if( ! in_array( '8', $terms )) echo '</div>';?>
							<div class="clear"></div>
						</div>
					</article>
				<?php endwhile; ?>
			</div><!-- .ajax-content -->
			<?php if (!isset($_GET['search'])){?>
				<?php if ( !is_paged() ) {?>
					<?php if( $more_posts > 0 ) {?>
						<button class="load-more-content more-item" data-offset="<?php echo $post_per_page;?>" data-perpage="6" data-post-type="product" data-term="<?php echo $term_id;?>">еще  <span><?php echo $next_posts;?> </span></button><span class="ajax-loader"></span>
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