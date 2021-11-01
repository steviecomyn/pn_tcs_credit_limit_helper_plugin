<?php

// Remove the "Theme Colours" bit from the User Profile page.
remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );

// Add QuickLinks to top of the page.
add_action( 'personal_options', 'pn_add_quicklinks_to_user_profile_page' );

function pn_add_quicklinks_to_user_profile_page() {
  ?>
    <script type="text/javascript">
        jQuery( document ).ready(function( $ ){
			
			// Add id's to the headings.
			$('h3:contains("B2B User Settings (B2BKing)")').attr('id', 'b2b-settings');	
			$('h2:contains("Customer billing address")').attr('id', 'billing-address');
			$('h2:contains("Customer shipping address")').attr('id', 'shipping-address');
			
			// Create links to id's.
			var $b2b_settings_link = $("<a>B2B Settings</a>");
			$b2b_settings_link.attr("href", "#b2b-settings");
			$b2b_settings_link.attr("class", "page-title-action");
			
			var $billing_address_link = $("<a>Billing Address</a>");
			$billing_address_link.attr("href", "#billing-address");
			$billing_address_link.attr("class", "page-title-action");
						
			var $shipping_address_link = $("<a>Shipping Address</a>");
			$shipping_address_link.attr("href", "#shipping-address");
			$shipping_address_link.attr("class", "page-title-action");
						
			var $user_credit_link = $("<a>User Credit</a>");
			$user_credit_link.attr("href", "#b2bking_user_credit_container");
			$user_credit_link.attr("class", "page-title-action");
			
			// Create wrapper for links and append to the page.
			var $wrapper = $('<div id="pn_quicklinks" style="margin: 2rem 0;"><h3>QuickLinks</h3><p>Jump to sections within this page:</p></div>');

			$("#your-profile").before($wrapper);
			$("#pn_quicklinks").append($b2b_settings_link);
			$("#pn_quicklinks").append($user_credit_link);
			$("#pn_quicklinks").append($shipping_address_link);
			$("#pn_quicklinks").append($billing_address_link);
			
        } );
    </script>
  
<?php
}