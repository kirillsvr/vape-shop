/**
 * Cart Scripts
 */


jQuery(function($){
	
	var themeUrl = '/wp-content/themes/handicraft-liquids/';
	
	//Cart Functions
	$ajaxCart = function(){
		$.ajax({
			url: themeUrl + 'inc/ajax/ajax_cart.php',
			success: function(data) {
				data = $.parseJSON(data);
				var cartQty = data['cartQty'];
				$('.cart-widget__count').text(cartQty);
				$('.sidebar-cart-msg').fadeIn();
				setTimeout(function(){
					$('.sidebar-cart-msg').fadeOut();
				}, 2000 );
				
				$.ajax({
					url: themeUrl + 'inc/ajax/ajax_cart_content.php',
					success: function(data) {
						$('.sidebar-cart-info').html(data);
					}
				});
				
				$.ajax({
					url: themeUrl + 'inc/ajax/ajax_inner_cart_content.php',
					success: function(data) {
						$('.sidebar-cart-catalog').html(data);
					}
				});
				
				$.ajax({
					url: themeUrl + 'inc/ajax/ajax_cart_page.php',
					success: function(data) {
						$('.sidebar-cart-page').html(data);
					}
				});
				
			}
		});
	};
	
	//Cart Functions
	$ajaxCartSum = function(){
		$.ajax({
			url: themeUrl + 'inc/ajax/ajax_cart_sum.php',
			success: function(data) {
				data = $.parseJSON(data);
				var cartSum = data['cartSum'];
				$('.cart-widget__sum').text(cartSum);
				$('.cart-product-total-price').text(cartSum);		
			}
		});
	};

	$(document).on('click', '.add-to-cart', function(e){
		event.preventDefault();
		var productId = $(this).data('id');
		var productQty = $(this).attr('data-qty');
		var volumeType = $(this).attr('data-volume');
		
		if (productId && productQty) {
			var cartCookie = $.cookie('cartCookie');

			if (cartCookie) {
				cartCookie = $.parseJSON($.cookie('cartCookie'));
				var newId = true;
				for (var i=0; i<cartCookie.length; i++) {
					if (productId == cartCookie[i].id) {
						cartCookie[i].qty = productQty;
						cartCookie[i].volume = volumeType;
						newId = false;
					}
				}
				if (newId) {
					cartCookie.push({'id' : productId, 'qty' : productQty, 'volume' : volumeType});
				}
				$.cookie("cartCookie", JSON.stringify(cartCookie), {path: '/'});
			} else {
				var cartCookie = [
					{'id' : productId, 'qty' : productQty, 'volume' : volumeType}
				]; 
				$.cookie("cartCookie", JSON.stringify(cartCookie), {path: '/'});
			}
		};
		$ajaxCart();
		$ajaxCartSum();
	});

	$(document).on('click', '.remove-from-cart', function(e){
		e.preventDefault();
		var productId = $(this).data('id') ? $(this).data('id') : 0;
		if (productId) { // daca id-ul e un numar si e mai mare decat 0
			var cartCookie = $.cookie('cartCookie');
			if (cartCookie) {
				cartCookie = $.parseJSON($.cookie('cartCookie'));
				elem = -1;
				for (var i=0; i<cartCookie.length; i++) {
					if (productId == cartCookie[i].id) {
						elem = i;
					}
				}
				if (elem > -1) {
					cartCookie.splice(elem, 1);
				}
				$.cookie("cartCookie", JSON.stringify(cartCookie), {path: '/'});
				//$ajaxCart();
			}
		}
		location.reload();
	});
	
	$(document).on('click', '.delete-from-cart', function(e){
		e.preventDefault();
		var productId = $(this).data('id') ? $(this).data('id') : 0;
		if (productId) { // daca id-ul e un numar si e mai mare decat 0
			var cartCookie = $.cookie('cartCookie');
			if (cartCookie) {
				cartCookie = $.parseJSON($.cookie('cartCookie'));
				elem = -1;
				for (var i=0; i<cartCookie.length; i++) {
					if (productId == cartCookie[i].id) {
						elem = i;
					}
				}
				if (elem > -1) {
					cartCookie.splice(elem, 1);
				}
				$.cookie("cartCookie", JSON.stringify(cartCookie), {path: '/'});
				$ajaxCart();
			}
		}
	});
	
	//Refresh page button
	$('.btn-refresh').click(function() {
		location.reload();
	});
	
	// Btn Cart Minus
	$(document).on('click', '.btn-cart-minus', function(event){
		event.preventDefault();
		var $input = $(this).parent().find('input');
		var divPrice = $(this).parents('tr').find('.price-count');
		var priceDefault = $(this).parents('tr').find('.price-count-default').val();
		var count = parseInt($input.val()) - 1;
		count = count < 1 ? 1 : count;
		$input.val(count);
		$input.change();
		divPrice.text( priceDefault * count );
		var volumeType = $(this).parents('tr').find('.select-volume-option-cart option:selected').attr('data-volume');
				
		// Update database
		var productId = $(this).parents('tr').find('.cart-product-id').val();
		var productQty = count;
		
		if (productId && productQty) {
			var cartCookie = $.cookie('cartCookie');

			if (cartCookie) {
				cartCookie = $.parseJSON($.cookie('cartCookie'));
				var newId = true;
				for (var i=0; i<cartCookie.length; i++) {
					if (productId == cartCookie[i].id) {
						cartCookie[i].qty = productQty;
						newId = false;
						}
					}
					if (newId) {
						cartCookie.push({'id' : productId, 'qty' : productQty, 'volume' : volumeType});
					}
					$.cookie("cartCookie", JSON.stringify(cartCookie), {path: '/'});
				} else {
					var cartCookie = [
						{'id' : productId, 'qty' : productQty, 'volume' : volumeType}
					]; 
					$.cookie("cartCookie", JSON.stringify(cartCookie), {path: '/'});
				}
		};
		$ajaxCart();
		$ajaxCartSum();
	});
	
	// Btn Cart Plus
	$(document).on('click', '.btn-cart-plus', function(event){
		event.preventDefault();
		var $input = $(this).parent().find('input');
		var divPrice = $(this).parents('tr').find('.price-count');
		var priceDefault = $(this).parents('tr').find('.price-count-default').val();
		var count = parseInt($input.val()) + 1;
		$input.val(count);
		$input.change();
		divPrice.text( priceDefault * count );
		var volumeType = $(this).parents('tr').find('.select-volume-option-cart option:selected').attr('data-volume');
				
		// Update database
		var productId = $(this).parents('tr').find('.cart-product-id').val();
		var productQty = count;
		var volumeType = $(this).data('volume');
		
		if (productId && productQty) {
			var cartCookie = $.cookie('cartCookie');

			if (cartCookie) {
				cartCookie = $.parseJSON($.cookie('cartCookie'));
				var newId = true;
				for (var i=0; i<cartCookie.length; i++) {
					if (productId == cartCookie[i].id) {
						cartCookie[i].qty = productQty;
						newId = false;
						}
					}
					if (newId) {
						cartCookie.push({'id' : productId, 'qty' : productQty, 'volume' : volumeType});
					}
					$.cookie("cartCookie", JSON.stringify(cartCookie), {path: '/'});
				} else {
					var cartCookie = [
						{'id' : productId, 'qty' : productQty, 'volume' : volumeType }
					]; 
					$.cookie("cartCookie", JSON.stringify(cartCookie), {path: '/'});
				}
		};
		$ajaxCart();
		$ajaxCartSum();
	});
	
	/**
	 * Plus Minus
	 */
	 $(document).on('click', '.btn-minus', function(event){
		event.preventDefault();
		var $input = $(this).parent().find('input');
		var cartButton = $(this).parents('.catalog-item').find('.add-to-cart');
		var divPrice = $(this).parents('.catalog-item').find('.price-count');
		var priceDefault = $(this).parents('.catalog-item').find('.price-count-default').val();
		var count = parseInt($input.val()) - 1;
		count = count < 1 ? 1 : count;
		$input.val(count);
		$input.change();
		cartButton.attr('data-qty', count );
		divPrice.text( priceDefault * count );
		return false;
	});
	$(document).on('click', '.btn-plus', function(event){
		event.preventDefault();
		var $input = $(this).parent().find('input');
		var cartButton = $(this).parents('.catalog-item').find('.add-to-cart');
		var divPrice = $(this).parents('.catalog-item').find('.price-count');
		var priceDefault = $(this).parents('.catalog-item').find('.price-count-default').val();
		var count = parseInt($input.val()) + 1;
		$input.val(count);
		$input.change();
		cartButton.attr('data-qty', count );
		divPrice.text( priceDefault * count );
		return false;
	});
	
	/**
	 * Select Volume by button
	 */
	$(document).on('click', '.select-volume > a', function(e){
		e.preventDefault();
		$(this).parent().find('a').removeClass('active');
		$(this).addClass('active');
		var thisPrice = $(this).data('price');
		var thisVolume = $(this).data('volume');
		var thisQty = $(this).parents('.catalog-item').find('.input-qty').val();
		$(this).parents('.catalog-item').find('.price-count-default').val(thisPrice);
		$(this).parents('.catalog-item').find('.price-count').text(thisPrice * thisQty);
		$(this).parents('.catalog-item').find('.add-to-cart').attr('data-volume', thisVolume);
		$(this).parents('.catalog-item').find('.select-volume-option option').removeAttr('selected');
		$(this).parents('.catalog-item').find('.select-volume-option option[value="' + thisVolume + '"]').attr('selected','selected');
	});
	
	/**
	 * Select Volume by select option
	 */
	$(document).on('change', '.select-volume-option', function(){
		var thisPrice = $(this).find(':selected').attr('data-price');
		var thisVolume = $(this).val();
		var thisQty = $(this).parents('.catalog-item').find('.input-qty').val();
		$(this).parents('.catalog-item').find('.select-volume a').removeClass('active');
		$(this).parents('.catalog-item').find('.select-volume a[data-volume="' + thisVolume + '"]').addClass('active');
		$(this).parents('.catalog-item').find('.price-count-default').val(thisPrice);
		$(this).parents('.catalog-item').find('.price-count').text(thisPrice * thisQty);
		$(this).parents('.catalog-item').find('.add-to-cart').attr('data-volume', thisVolume);
	});
	
	/**
	 * Select Volume by select option cart page
	 */
	$(document).on('change', '.select-volume-option-cart', function(){

		var thisPrice = $(this).find(':selected').attr('data-price');
		var thisVolume = $(this).val();
		var thisQty = $(this).parents('tr').find('.input-qty').val();
		$(this).parents('tr').find('.price-count-default').val(thisPrice);
		$(this).parents('tr').find('.price span').text(thisPrice);

		$(this).parents('tr').find('.price-count').text(thisPrice * thisQty);
		
		var productId = $(this).parents('tr').find('.cart-product-id').val();
		var volumeType = thisVolume;
		var productQty = thisQty;
		
		//alert(productId + volumeType + productQty);
		
		if (productId && productQty) {
			var cartCookie = $.cookie('cartCookie');

			if (cartCookie) {
				cartCookie = $.parseJSON($.cookie('cartCookie'));
				var newId = true;
				for (var i=0; i<cartCookie.length; i++) {
					if (productId == cartCookie[i].id) {
						cartCookie[i].qty = productQty;
						cartCookie[i].volume = volumeType;
						newId = false;
					}
				}
				if (newId) {
					cartCookie.push({'id' : productId, 'qty' : productQty, 'volume' : volumeType});
				}
				$.cookie("cartCookie", JSON.stringify(cartCookie), {path: '/'});
			} else {
				var cartCookie = [
					{'id' : productId, 'qty' : productQty, 'volume' : volumeType }
				]; 
				$.cookie("cartCookie", JSON.stringify(cartCookie), {path: '/'});
			}
		};
		$ajaxCart();
		$ajaxCartSum();
		
	});

});
