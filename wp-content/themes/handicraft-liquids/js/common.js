/**
 * Scripts
 */

(function ($) {
	"use strict";

	$(document).mouseup(function (e){
		var div = $(".popup.cart");
		if (!div.is(e.target) 
			&& div.has(e.target).length === 0
			&& div.has(e.target).length === 0) {
			 $('.popup.cart').fadeOut(function(){
				$('.left-menu .cart').removeClass('close');
			});
		}
	});

	$('.review-item .content .link').click(function() {
		$(this).hide();
		$(this).prev('.review-item .content .more-text').slideToggle();
	});
	$('.site-form-order .select').click(function() {
		$('.site-form-order .select').toggleClass('active');
		$('.site-form-order .form').toggleClass('hidden');
	});
	$('.searchbg').click(function() {
		$(this).fadeOut();
		$('.left-search').removeClass('opened');
		$('.right-search').removeClass('opened');
	});
	$('.left-menu .bottom-info .search').click(function() {
		$('.searchbg').fadeIn();
		$('.left-search').addClass('opened');
	});
	$('.right-social .search').click(function() {
		$('.searchbg').fadeIn();
		$('.right-search').addClass('opened');
	});
	$('.search-event').click(function(e) {
		e.preventDefault();
	});
	$('.faq-page .faq-item .top-text').click(function() {
		$(this).next('.faq-page .faq-item .bottom-text').slideToggle();
		$(this).parent().toggleClass('active');
	});
	
	$(document).on('click', '.cart-info .top-link', function(e){
		e.preventDefault();
		$('.cart-table').slideToggle();
		$(this).toggleClass('active');
	});
	
	$('.footer .bottom-menu a.politic-popup').click(function() {
		$('.popup.politic').fadeIn();
		$('.popupbg').fadeIn();
	});
	$('.review-item .content .links a.a2').click(function(e) {
		e.preventDefault();
		var thisHref =  $(this).attr('href');
		$('.popup.mail img').attr('src',thisHref);
		$('.popup.mail').fadeIn();
		$('.popupbg').fadeIn();
	});
	$('.review-item .content .links a.a1').click(function(e) {
		e.preventDefault();
		var thisHref =  $(this).attr('href');
		$('.popup.video iframe').attr('src',thisHref);
		$('.popup.video').fadeIn();
		$('.popupbg').fadeIn();
	});
	$('.left-menu .toggle-left-cart').click(function(e) {
		e.preventDefault();
		if(!$(this).hasClass('close')){
			$('.popup.cart').fadeToggle();
			$(this).toggleClass('close');
		}
	});
	$('.left-menu .site-menu li a.more-menu-link').click(function() {
		$(this).hide();
		$('.left-menu .site-menu li ul.more-menu').slideToggle();
		$('.left-menu .site-menu').addClass('opened');
	});
	$('.callback-text .right-text .button').click(function(e) {
		e.preventDefault();
		$('.popupbg').fadeIn();
		$('.popup.callback').fadeIn();
	});
	$('.callback-popup').click(function(e) {
		e.preventDefault();
		$('.popupbg').fadeIn();
		$('.popup.callback').fadeIn();
	});
	$('.writeus-popup').click(function(e) {
		e.preventDefault();
		$('.popupbg').fadeIn();
		$('.popup.writeus').fadeIn();
	});
	$('.popupbg').click(function() {
		$(this).fadeOut();
		$('.popup').fadeOut();
	});
	$('.popup .close').click(function() {
		$('.popupbg').fadeOut();
		$('.popup').fadeOut();
	});
	$('.menubg').click(function() {
		$('.left-menu nav').removeClass('opened');
		$('.menubg').fadeOut();
	});
	$('.left-menu .menu-button').click(function() {
		$('.left-menu nav').addClass('opened');
		$('.menubg').fadeIn();
	});

	$('.index-slider').slick({
		autoplay: false,
		dots: false,
		arrows: true
	});

	$('.slider_2 .list').slick({
		autoplay: false,
		dots: false,
		arrows: true
	});

	$('.slider_1').slick({
		autoplay: false,
		dots: false,
		arrows: true
	});

	$('.index-page-slider').slick({
		autoplay: true,
		dots: true
	});
	
	/**
	 * Scripts
	 */
	if($().onepage_scroll){
		$(".main").onepage_scroll();
	}
	
	if($().waypoint){
		$('.footer').waypoint(function(){
			var win_height = $(window).height();
			var doc_height = $(document).height();
			var dif_height = doc_height - win_height - 120;
				if( dif_height > 0 ) {
					$('.phone').slideToggle(300);
					$('.catalog-menu').slideToggle(300);
					$('.site-menu').slideToggle(300);
					$('.bottom-info').slideToggle(300);
				}
			},{
			offset: '88%'
		});
	}
	
	/**
	 * BootWP: wp_ajax.js
	 * 
	 * Alax Load More Content
	 * 
	 * @link http://bootwp.com/javascript/#wp_ajax
	 * 
	 * @package BootWP
	 * @subpackage Buttons
	 * @since: 0.1.0
	 */
	$(document).on('click', '.load-more-content', function(e){
		e.preventDefault();
		var thisBtn = $(this);
		thisBtn.next('.ajax-loader').addClass('is-active');
		var dataOffset = thisBtn.data('offset');
		var dataPerPage = thisBtn.data('perpage');
		var dataPostType = thisBtn.data('post-type');
		var dataTerm = thisBtn.data('term');
		var nextPosts = thisBtn.data('next-posts');
		var updateNextPosts = dataOffset + nextPosts;
		$.post( '/wp-admin/admin-ajax.php', {
				action :        'load_next_posts',
				posts_per_page: dataPerPage,
				offset:         dataOffset,
				post_type:      dataPostType,
				term:           dataTerm
			},
			function( response ) {
				$('.ajax-content').append( response );
				var postsCount = $('.ajax-content').data('posts');
				var itemsCount = $('.ajax-content > article').length;
				$('.load-more-content').data('offset', itemsCount );
				if( postsCount > itemsCount) {
					thisBtn.find('span').text( postsCount - itemsCount );
				}
				if( postsCount == itemsCount ){
					$('.load-more-content').addClass('disabled');
				};
				$('.wp-pagenavi').fadeOut();
				thisBtn.next('.ajax-loader').removeClass('is-active');
				$('#filter_form').find('[name="posts_per_page"]').val(updateNextPosts);
			}
		);
		
		return false;

	});
	
	/** 
	 * Ajax Search products
	 */
	$('#filter_form').on('submit', function(e){
		e.preventDefault();
		//$('.ajax-content').fadeOut( 'slow', function(){
		$('.catalog-list-ajax').html('<div class="ajax-loader ajax-loader-search"></div>');
		//});
		var thisForm = $(this);
		var searchString = thisForm.find('[name="search"]').val();
		var term = thisForm.find('[name="term"]').val();
		var order = thisForm.find('[name="order"]').val();
		var orderby = thisForm.find('[name="orderby"]').val();
		var postsPerPage = thisForm.find('[name="posts_per_page"]').val();
		$.post( '/wp-content/themes/handicraft-liquids/inc/ajax/wp_ajax_search.php', {
				s:       searchString,
				term:    term,
				order:   order,
				orderby: orderby,
				posts_per_page: postsPerPage
			},
			function( response ) {
				$('.catalog-list-ajax').html(response);
			}
		);
		
		return false;

	});
	
	/**
	 * Scroll to
	 */
	$('.go-to-order-form').on('click', function(){
		$('html, body').stop().animate({
			scrollTop: $('#order-form').offset().top - 35
		}, 500 );
	});
	
	/**
	 * Select Orderby
	 */
	$(document).on('click', '.select-orderby > a', function(e){
		e.preventDefault();
		$(this).parent().find('a').removeClass('active');
		$(this).addClass('active');
		var thisOrder = $(this).data('order');
		var thisOrderby = $(this).data('orderby');
		$('#filter_form [name="order"]').val(thisOrder);
		$('#filter_form [name="orderby"]').val(thisOrderby);
		$('#filter_form').submit();
	});
	
	/**
	 * Select Orderby Option
	 */
	$(document).on('change', '.select-orderby-option', function(){
		var thisOrder = $(this).find(':selected').attr('data-order');
		var thisOrderby = $(this).find(':selected').attr('data-orderby');
		$('#filter_form [name="order"]').val(thisOrder);
		$('#filter_form [name="orderby"]').val(thisOrderby);
		$('#filter_form').submit();
	});

})( jQuery );