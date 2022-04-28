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
		<h1>Отзывы</h1>
		
		<div class="reviews-page">
			<?php if ( have_posts() ) : ?>
				<?php $paged = (isset($wp_query->query[ 'paged' ])) ? $wp_query->query[ 'paged' ] : 1; ?>
				<?php $post_per_page = $wp_query->query_vars[ 'posts_per_page' ];?>
				<?php $fount_posts = $wp_query->found_posts; ?>
				<?php $more_posts = $fount_posts - ( $post_per_page * $paged ); ?>
				<?php $next_posts = ( $more_posts > 6 ) ? 6 : $more_posts; ?>
				<div class="ajax-content" data-posts="<?php echo $fount_posts;?>">
					<?php while ( have_posts() ) : the_post(); ?>
					<article class="review-item">
						<?php if(has_post_thumbnail()){?>
							<img src="<?php the_post_thumbnail_url( 'review' );?>" class="image">
						<?php } ?>
						<div class="content">
							<a href="<?php the_permalink();?>" class="name"><?php the_title();?></a>
							
							<?php $str = wpautop( get_the_content() );?>
							<?php //echo $str;?>
							<?php
								preg_match_all ( '#<p>(.+?)</p>#', $str, $str_arr );
								$count = count($str_arr[1]);
								$i = 0;
								foreach($str_arr[1] as $item){ $i++;
									if($i == 2) {
										echo '<div class="more-text">';
									}
									echo '<p>'.$item.'</p>';
									if($i == $count  && $i > 1){
										echo '</div>';
									}
								}
								if($count > 1 ) {
									echo '<a class="link">Смотреть полностью</a>';
								}
							?>
							
							<div class="links">
								<?php if( get_field('video_review')){?>
								<img src="<?php echo get_theme_file_uri( '/img/review1.jpg' );?>"> <a href="<?php the_field('video_review'); ?>" class="a1">видеоотзыв</a><br/>
								<?php } ?>
								<?php if( get_field('letter_thanks') ){?>
									<img src="<?php echo get_theme_file_uri( '/img/review2.jpg' );?>"> <a href="<?php echo wp_get_attachment_image_url( get_field('letter_thanks'), 'large' ); ?>" class="a2">благодарственное письмо</a>
								<?php } ?>
							</div>
						</div>
						<div class="clear"></div>
					</article>
					<?php endwhile; ?>
				</div><!-- .ajax-content -->
				<?php if( $more_posts > 0 ) {?>
					<button class="load-more-content" data-offset="<?php echo $post_per_page;?>" data-perpage="6" data-post-type="review">еще отзывы</button><span class="ajax-loader"></span>
				<?php } ?>
			<?php endif; ?>
		</div>
	</div>
<?php get_footer(); ?>