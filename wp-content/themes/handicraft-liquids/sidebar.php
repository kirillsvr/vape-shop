<?php
/**
 * The template for the sidebar containing the main widget area
 *
 * @package Handicraft Liquids
 * @subpackage Handicraft Liquids
 * @since Handicraft Liquids 1.0.0
 */
?>

	<div class="menubg"></div>
	<div class="left-menu">
		<div class="menu-button"></div>
		<div class="content">
			<div class="cart <?php if(!is_page(186)){ echo 'toggle-left-cart'; } ?>">
				<?php 
					$arrQty = 0;
					if(isset($_COOKIE['cartCookie'])) {
						$cartCookie = json_decode(stripslashes($_COOKIE['cartCookie']));
					//print_r($cartCookie);
						foreach ($cartCookie as $cartpost) {
							$arrQty += $cartpost->qty;
						}
					}
					$cart_total = $arrQty;
				?>
				<span class="cart-widget__count"><?php echo $cart_total;?></span>
				<div class="sidebar-cart-msg">Корзина обновлена!</div>
			</div>
			<div class="logo">
				<a href="<?php echo esc_url( home_url( '/' ) );?>">
					<?php echo add_tag_to_n_word( get_bloginfo( 'name' ), 2 );?>
				</a>
			</div>
			<nav>
				<?php 
					wp_nav_menu( array(
						'theme_location'    => 'catalog',
						'depth'             => 1,
						'container'         => 'false',
						'menu_class'        => 'catalog-menu',
						'items_wrap'        => '<ul class="%2$s">%3$s</ul>',
						'walker'            => new WP_Simple_NavWalker(),
					) );
				?>
				<?php wp_nav_cut_menu( 'primary', 4 ); ?>
			</nav>
			<div class="phone">
				<a href="tel:<?php echo get_clean_tel( theme_field( 'phone' , false ) );?>" class="link"><?php theme_field( 'phone' );?></a>
				<a class="callback-popup">заказать звонок</a>
			</div>
			
			<?php if( ! is_front_page() ) {?>
				<div class="bottom-info">
					<div class="search"></div>
					<div class="left-search">
						<?php get_search_form();?>
					</div>
					<?php wp_social_menu( 'social' );?>
					<div class="item">
						<a href="mailto:<?php theme_field( 'email' );?>" class="link"><?php theme_field( 'email' );?></a>
						<a href="#" class="writeus-popup">написать нам</a>
					</div>
					<div class="item">
						<span><?php theme_field( 'address' );?></span>
						<a href="<?php the_permalink( 20 );?>#map">посмотреть на карте</a>
					</div>
					<div class="item">
						<a href="tel:<?php echo get_clean_tel( theme_field( 'phone' , false ) );?>" class="link"><?php theme_field( 'phone' );?></a>
						<a class="callback-popup">заказать звонок</a>
					</div>
				</div>
			<?php } ?>

		</div>
	</div>
