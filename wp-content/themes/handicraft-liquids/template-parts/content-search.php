<?php
/**
 * Template part for search
 */

?>

<?php wp_social_menu( 'right-social', '<a href="#" class="search-event"><span class="search"></span></a>' );?>
<div class="page-content">
	<h1>Результаты поиска</h1>
	<div class="page-search-well">
		<?php get_search_form();?>
		<div class="page-search-well-result">По запросу «<?php echo esc_html( get_search_query() );?>» найдено результатов: <span><?php echo $wp_query->found_posts;?></span></div>
	</div><!-- .page-search-well -->
	
	<div class="search-result">
		<div class="search-result-heading">
			<h4>Страница</h4>
			<h4>Результаты поиска</h4>
		</div>
		<div class="search-result-items">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
				<?php 
					$post_type = $post->post_type;
					if ( $post_type == 'post' ) {
						$type_name = 'Новости';
					} else if ( $post_type == 'page' ) {
						$type_name = 'Страница';
					} else if ( $post_type == 'review' ) {
						$type_name = 'Отзывы';
					} else if ( $post_type == 'product' ) {
						$terms = get_the_terms( get_the_ID(), 'product_cat' );
						if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
							$type_name = $terms[0]->name;
						} else {
							$type_name = 'Продукты';
						}
					}
				?>
				
				<article class="search-item">
					<h4><?php echo $type_name;?></h4>
					<div class="search-item-content">
						<h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
						<?php echo wpautop( strip_shortcodes( wp_trim_words( get_the_content(), 15, '...' ) ) );?>
					</div>
				</article>
				<?php endwhile; ?>
			<?php if(function_exists( 'wp_pagenavi' )) {?>
				<?php wp_pagenavi();?>
			<?php } ?>

		<?php endif; ?>
		</div>
	</div><!-- .search-result -->

</div>