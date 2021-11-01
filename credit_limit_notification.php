<?php

// Credit Limit balance Notification
add_action( 'woocommerce_before_cart', 'pn_alert_credit_limit' );

// Alerts the user when they exceed their credit limit at the basket.
function pn_alert_credit_limit() {

	?>


	<script>

		var timeout;

		jQuery( function( $ ) {
			$('.woocommerce').on('change', 'input.qty', function(){

				if ( timeout !== undefined ) {
					clearTimeout( timeout );
				}

				timeout = setTimeout(function() {
					$("[name='update_cart']").trigger("click");


				}, 1000 ); // 1 second delay, half a second (500) seems comfortable too

			});
		} );

	</script>


	<?php

	$test_acc = 1036;

	global $woocommerce;
	$cart_contents = WC()->cart->cart_contents;
	
	$user_id = get_current_user_id();
	$cart_total = WC()->cart->subtotal;
	
	$users_credit_limit = get_user_meta( $user_id, 'b2bking_user_credit_limit', true);
	$users_credit_balance = get_user_meta( $user_id, 'b2bking_user_credit_consumed_balance', true);
	
	$product_id = 21814;
	$in_cart = false;
	
	// Loop through the cart items, check if they are "credit" e.g. product_id = 21814.
	foreach( WC()->cart->get_cart() as $cart_item ) {
		$product_in_cart = $cart_item['product_id'];
		if ( $product_in_cart === $product_id ) $in_cart = true;
	}

	// If "credit" is found in the cart, check there's only 1 product.
	if ( $in_cart ) {

		// If there's only 1 product, and it's credit, show the adding credit notice.
		if (sizeof($cart_contents) === 1) {

			foreach($cart_contents as $item){
				$b2bking_credit_amount = $item['b2bking_credit_amount'];
			}

			$notice = 'This order will update your company credit balance by £'.$b2bking_credit_amount;
			wc_print_notice( $notice, 'notice' );
		}

	} else {

	//... if they're buying anything other than credit, show the message.

	// If the user has a credit limit...
	if ($users_credit_limit) {
		
		// Check the available balance...
		$users_available_credit = $users_credit_limit - $users_credit_balance;
	
		// If the available balance is less than the cart total...
		if ($cart_total > $users_available_credit) {

			$notice = '<span id="pn_credit_limit_notice">This order will take you over your available credit (£'.$users_available_credit.'), you can continue to checkout and pay by credit card or add funds to reduce your account balance <a href="https://textile-care.co.uk/my-account/company-credit/">here</a>.</span>';

			echo '<div id="pn-credit-limit-notice-wrapper">'.$notice.'</div>';
		}
	}

   }

}

// This refreshes the page whenever the cart is updated, to provide an up-to-date credit limit notification.
function pn_refresh_on_cart_update(){ ?>
	<script>
	jQuery(document).ready(function($) {
		
		// When the cart is updated, refresh the page.
		jQuery(document.body).on('removed_from_cart updated_cart_totals', function () {
	
			location.reload();
	
		});
	});
	</script>
	<?php
}

add_action('wp_footer', 'pn_refresh_on_cart_update');

function get_credit_product_price() {

	global $woocommerce;
    $items = $woocommerce->cart->get_cart();

	foreach($items as $item => $values) { 
		$_product =  wc_get_product( $values['data']->get_id() );

		$price = get_post_meta($values['product_id'] , '_price', true);
		$reg_price = get_post_meta($values['product_id'] , '_regular_price', true);
        $sale_price = get_post_meta($values['product_id'] , '_sale_price', true);

		$all_details = array("price"=>$price, "reg_price"=>$reg_price, "sale_price"=>$sale_price);

		return $all_details;
	}
}