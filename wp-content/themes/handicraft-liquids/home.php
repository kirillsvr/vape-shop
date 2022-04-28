<?php
/**
 * The home template file
 *
 * @package Handicraft Liquids
 * @subpackage Handicraft Liquids
 * @since Handicraft Liquids 1.0.0
 */

get_header(); ?>

	<?php wp_social_menu( 'right-social', '<a href="#" class="search-event"><span class="search"></span></a>' );?>
	<div class="page-content">
		<h1>Новости и акции</h1>
		<div class="news-page">
		
			<?php if ( have_posts() ) : ?>
				<?php $paged = (isset($wp_query->query[ 'paged' ])) ? $wp_query->query[ 'paged' ] : 1; ?>
				<?php $post_per_page = $wp_query->query_vars[ 'posts_per_page' ];?>
				<?php $fount_posts = $wp_query->found_posts; ?>
				<?php $more_posts = $fount_posts - ( $post_per_page * $paged ); ?>
				<?php $next_posts = ( $more_posts > 6 ) ? 6 : $more_posts; ?>
				<div class="news-list ajax-content" data-posts="<?php echo $fount_posts;?>">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php if(has_post_thumbnail()){?>
						<article class="news-item">
							<div class="image">
								<img src="<?php the_post_thumbnail_url( 'thumbnail' );?>" alt="">
								<?php
								$post_categories = wp_get_post_categories( get_the_ID() );
								if( in_array( 5 ,$post_categories )) {
									echo '<img src="' . get_theme_file_uri( '/img/action.png' ) . '" class="action">';
								}?>
							</div>
						<?php } else { ?>
						<article class="news-item no_image">
						<?php } ?>
							<div class="content">
								<div class="date"><?php the_time('d.m'); ?></div>
								<a href="<?php the_permalink();?>" class="name"><?php the_title();?></a>
								<?php echo wpautop( wp_trim_words( get_the_content(), 15, '' ) );?>
							</div>
							<div class="clear"></div>
						</article>
					<?php endwhile; ?>
				</div><!-- .news-list -->
				<?php if ( !is_paged() ) {?>
					<?php if( $more_posts > 0 ) {?>
						<button class="load-more-content" data-offset="<?php echo $post_per_page;?>" data-perpage="6" data-post-type="post">еще  <span><?php echo $next_posts;?></span></button><span class="ajax-loader"></span>
					<?php } ?>
				<?php } ?>
				<?php if(function_exists( 'wp_pagenavi' )) {?>
					<?php wp_pagenavi();?>
				<?php } ?>

			<?php endif; ?>
	
		</div>
	</div>
<?php get_footer(); ?>