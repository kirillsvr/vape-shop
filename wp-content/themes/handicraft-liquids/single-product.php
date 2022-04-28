<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package Handicraft Liquids
 * @subpackage Handicraft Liquids
 * @since Handicraft Liquids 1.0.0
 */

get_header(); ?>

	<div class="blue-zag">
		<?php wp_social_menu( 'right-social', '<a href="#" class="search-event"><span class="search"></span></a>' );?>
		<?php the_title( '<h1>', '</h1>' );?>
		<?php if(function_exists('bcn_display')) {?>
			<ol class="breadcrumb">
				<?php bcn_display();?>
			</ol>
		<?php } ?>
	</div>
	<div class="page-content">
		<?php while ( have_posts() ) : the_post();?>
			<article class="catalog-item">
				<div class="content">
					<div class="image">
						<?php if( has_post_thumbnail()){?>
							<img src="<?php the_post_thumbnail_url( 'catalog' );?>" alt="">
						<?php } else { ?>
							<img src="<?php echo get_theme_file_uri( '/img/thumb.png' );?>" alt="">
						<?php } ?>
					</div>
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
								$terms =  wp_get_post_terms( get_the_ID(), 'product_cat', array( 'fields' => 'ids' ) );
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
					</div>
					<div class="clear"></div>
				</div>
			</article>
	
		<?php endwhile; ?>
	</div>

<?php get_footer(); ?>