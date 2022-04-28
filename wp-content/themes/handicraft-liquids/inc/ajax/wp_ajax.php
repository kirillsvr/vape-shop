<?php
/**
 * Wp Ajax
 *
 * @package Handicraft Liquids
 * @subpackage Handicraft Liquids
 * @since Handicraft Liquids 1.0.0
 */

/**
 * Ajax Load More Posts
 */
function ajax_load_next_posts() {

	$offset = $_POST[ 'offset' ];
	$posts_per_page = $_POST[ 'offset' ];
	$post_type = $_POST[ 'post_type' ];
	if($post_type == 'post') {
		$taxonomy = 'category';
	} else {
		$taxonomy = 'product_cat';
	}
	$term = $_POST[ 'term' ];
	$tax_query = 0;
	if($term != 0){
		$tax_query = array(
			array(
				'taxonomy' => $taxonomy,
				'field'    => 'id',
				'terms'    => array( $term ),
			),
		);
	}
	$args = array(
		'posts_per_page' => $posts_per_page,
		'post_type'      => $post_type,
		'offset'         => $offset,
		'tax_query'      => $tax_query,
	);
	
	$query = new WP_Query( $args );

	// Цикл
	if ( $query->have_posts() ) { while ( $query->have_posts() ) { $query->the_post();
		if($post_type == 'post') { ?>
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
			<?php
		} else if($post_type == 'review'){ ?>
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
			<?php 
			} else if($post_type == 'product'){ ?>
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
													<option value="<?php the_field('price');?>"><?php the_field('price');?></option>
												<?php } ?>
												<?php if( get_field('price_100')){?>
													<option value="<?php the_field('price_100');?>"><?php the_field('price_100');?></option>
												<?php } ?>
												<?php if( get_field('price_250')){?>
													<option value="<?php the_field('price_250');?>"><?php the_field('price_250');?></option>
												<?php } ?>
												<?php if( get_field_object('price_gallon')){
													$price_gallon = get_field_object('price_gallon');
													?>
													<option value="<?php echo $price_gallon['value'];?>">галлон</option>
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
			<?php 
			}
		}
	}
	wp_reset_postdata();
	exit;
}
add_action('wp_ajax_load_next_posts', 'ajax_load_next_posts');
add_action('wp_ajax_nopriv_load_next_posts', 'ajax_load_next_posts');