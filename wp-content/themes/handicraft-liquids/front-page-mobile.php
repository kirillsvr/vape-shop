<?php
/**
 * The front page template file
 *
 * @package Handicraft Liquids
 * @subpackage Handicraft Liquids
 * @since Handicraft Liquids 1.0.0
 */

get_header(); ?>
	
	<section class="s1">
		<?php wp_social_menu( 'right-social show_on_mobile', '<a href="#" class="search-event"><span class="search"></span></a>' );?>
		<div class="main-content no_m">
			<?php handicraft_liquids_slider(); // inc/plugins/slider/slider.php ?>
		</div>
	</section>

	<section>
		<?php wp_social_menu( 'right-social', '<a href="#" class="search-event"><span class="search"></span></a>' );?>
		<div class="main-content no_m">
		
			<?php echo do_shortcode( get_field('products') );?>
			
		</div>
	</section>
	<section>
		<?php wp_social_menu( 'right-social', '<a href="#" class="search-event"><span class="search"></span></a>' );?>
		<div class="main-content no_m">
		
			<?php echo do_shortcode( get_field('advantages') );?>

		</div>
	</section>
	<section>
		<?php wp_social_menu( 'right-social', '<a href="#" class="search-event"><span class="search"></span></a>' );?>
		<div class="main-content no_m">
		
			<?php echo do_shortcode( get_field('prices') );?>
			
		</div>
	</section>
	<section>
		<?php wp_social_menu( 'right-social', '<a href="#" class="search-event"><span class="search"></span></a>' );?>
		<div class="main-content no_m">
		
			<?php echo do_shortcode( get_field('why') );?>

		</div>
	</section>
	<section>
		<?php wp_social_menu( 'right-social', '<a href="#" class="search-event"><span class="search"></span></a>' );?>
		<div class="main-content no_m">
			<div class="index-page-right-side">
				<div class="content">
					<div class="text">
						<div class="index-page-slider-right">
						
							<?php echo do_shortcode( get_field( 'subscribe' ) );?>
							<?php theme_field( 'subscribe' );?>

						</div>
					</div>
				</div>
			</div>
			<div class="index-page-left-side">
				<?php
					$args = array(
						'posts_per_page' => 3,
					);
					$query = new WP_Query( $args );
				?>
				<?php if ( $query->have_posts() ) :?>
					<div class="index-news">
						<div class="zag">
							<a href="<?php the_permalink( get_option( 'page_for_posts' ) );?>">все новости</a>
							новости и акции
						</div>
						<?php while ( $query->have_posts() ) : $query->the_post(); ?>
							<div class="item">
								<div class="content">
									<div class="date"><?php the_time('d.m');?></div>
									<a href="<?php the_permalink();?>" class="name"><?php the_title();?></a>
									<?php echo wp_trim_words( get_the_content(), 15, '' );?>
								</div>
							</div>
					
						<?php endwhile;?>
					</div>
				<?php endif;?>
				<?php wp_reset_postdata();?>
			</div>
		</div>
	</section>	

<?php get_footer( 'home' ); ?>