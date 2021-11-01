<?php
/** 
* @snippet       Set Custom Order Status during Checkout
* @how-to        Get CustomizeWoo.com FREE 
* @sourcecode    https://businessbloomer.com/?p=77911
* @author        Rodolfo Melogli 
* @compatible    WooCommerce 3.5.4
* @donate $9     https://businessbloomer.com/bloomer-armada/
*/
 
// ---------------------
// 1. Register Order Status
 
add_filter( 'woocommerce_register_shop_order_post_statuses', 'pn_register_credit_added_status' );
 
function pn_register_credit_added_status( $order_statuses ){
    
   // Status must start with "wc-"
   $order_statuses['wc-credit-added'] = array(                                 
   'label'                     => _x( 'Credit Added', 'Order status', 'woocommerce' ),
   'public'                    => false,                                 
   'exclude_from_search'       => false,                                 
   'show_in_admin_all_list'    => true,                                 
   'show_in_admin_status_list' => true,                                 
   'label_count'               => _n_noop( 'Credit Added <span class="count">(%s)</span>', 'Credit Added <span class="count">(%s)</span>', 'woocommerce' ),                              
   );      
   return $order_statuses;
}
 
// ---------------------
// 2. Show Order Status in the Dropdown @ Single Order and "Bulk Actions" @ Orders
 
add_filter( 'wc_order_statuses', 'pn_show_credit_added_status' );
 
function pn_show_credit_added_status( $order_statuses ) {      
   $order_statuses['wc-credit-added'] = _x( 'Credit Added', 'Order status', 'woocommerce' );       
   return $order_statuses;
}
 
add_filter( 'bulk_actions-edit-shop_order', 'pn_get_credit_added_status_bulk' );
 
function pn_get_credit_added_status_bulk( $bulk_actions ) {
   // Note: "mark_" must be there instead of "wc"
   $bulk_actions['mark_credit-added'] = 'Change status to Credit Added';
   return $bulk_actions;
}
 
 
 
// ---------------------
// 3. Set Custom Order Status @ WooCommerce Checkout Process
 
add_action( 'woocommerce_thankyou', 'pn_thankyou_change_order_status' );
 
function pn_thankyou_change_order_status( $order_id ){
   if( ! $order_id ) return;
   $order = wc_get_order( $order_id );
 
   // Status without the "wc-" prefix
   $order->update_status( 'credit-added' );
}

// 4. Send an email

add_action( 'woocommerce_order_status_credit-added', 'pn_status_custom_notification', 20, 2 );
  
function pn_status_custom_notification( $order_id, $order ) {
      
    $heading = 'Credit added';
    $subject = 'TCS - Your company credit has been updated';
  
    // Get WooCommerce email objects
    $mailer = WC()->mailer()->get_emails();
  
    // Use one of the active emails e.g. "Customer_Completed_Order"
    // Wont work if you choose an object that is not active
    // Assign heading & subject to chosen object
    $mailer['WC_Email_Customer_Completed_Order']->heading = $heading;
    $mailer['WC_Email_Customer_Completed_Order']->settings['heading'] = $heading;
    $mailer['WC_Email_Customer_Completed_Order']->subject = $subject;
    $mailer['WC_Email_Customer_Completed_Order']->settings['subject'] = $subject;
  
    // Send the email with custom heading & subject
    $mailer['WC_Email_Customer_Completed_Order']->trigger( $order_id );
  
}

// 5. add extra info.

add_action( 'woocommerce_email_before_order_table', 'custom_content_to_processing_customer_email', 10, 4 );
function custom_content_to_processing_customer_email( $order, $sent_to_admin, $plain_text, $email ) {

	// If it's a complete order...
    if( 'customer_completed_order' == $email->id ){
		// specifically for a credit added order.
		if ('credit-added' == $order->get_status()) {
			
			// Gather all the bits and bobs we need.
			$user_id   = $order->get_user_id();
			$users_credit_limit = get_user_meta( $user_id, 'b2bking_user_credit_limit', true);
			$users_credit_balance = get_user_meta( $user_id, 'b2bking_user_credit_consumed_balance', true);
			
			// Put the minus before the pound sign (for human readablity).
			if (substr($users_credit_balance, 0, 1) === '-') {
				//$currency_user_balance = "-£".ltrim($user_credit_balance, $user_credit_balance[0]);
				$currency_user_balance = "-£".substr($users_credit_balance, 1);
			}
			
			// Add a little status card of their company credit.
        	echo '<div style="padding: 1em; border: 1px solid #ededed; border-radius: 6px; text-align: center;"><h5 style="margin-bottom: 8px;">Current Balance:</h5><h2 style="color: #3c3c3c; font-size: 38px; width: 100%; text-align: center;">'.$currency_user_balance.'</h2><p>Your credit limit is: £'.$users_credit_limit.'. To view your balance online, <a href="https://textile-care.co.uk/my-account/company-credit/">click here</a>.</p></div><br>';
		}

    }

}